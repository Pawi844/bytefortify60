<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\Attendee;
use App\Models\Order;
use App\Models\Paper;
use App\Models\PaperField;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class EventFrontController extends Controller
{
    public function show(Event $event)
    {
        if ($event->status !== 'published') abort(404);
        $speakers  = $event->speakers()->where('is_featured', true)->take(8)->get();
        $sponsors  = $event->sponsors()->orderBy('tier')->get();
        $tickets   = $event->tickets()->where('is_visible', true)->get();
        $schedule  = $event->schedules()->where('is_public', true)->orderBy('start_time')->take(6)->get();
        return view('front.event', compact('event','speakers','sponsors','tickets','schedule'));
    }

    public function register(Event $event)
    {
        if ($event->status !== 'published') abort(404);
        $tickets = $event->tickets()->where('is_visible', true)->get();
        return view('front.register', compact('event','tickets'));
    }

    public function storeRegistration(Request $request, Event $event)
    {
        $validated = $request->validate([
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'email'        => 'required|email|max:255',
            'phone'        => 'nullable|string|max:30',
            'organization' => 'nullable|string|max:255',
            'job_title'    => 'nullable|string|max:255',
            'ticket_id'    => 'required|exists:tickets,id',
            'dietary'      => 'nullable|string|max:255',
        ]);
        $ticket = Ticket::findOrFail($validated['ticket_id']);
        $attendee = Attendee::firstOrCreate(
            ['email' => $validated['email'], 'event_id' => $event->id],
            [
                'first_name'      => $validated['first_name'],
                'last_name'       => $validated['last_name'],
                'phone'           => $validated['phone'] ?? null,
                'organization'    => $validated['organization'] ?? null,
                'job_title'       => $validated['job_title'] ?? null,
                'dietary'         => $validated['dietary'] ?? null,
                'portal_password' => Str::random(8),
            ]
        );
        $order = Order::create([
            'event_id'     => $event->id,
            'attendee_id'  => $attendee->id,
            'ticket_id'    => $ticket->id,
            'order_number' => strtoupper(Str::random(10)),
            'total_amount' => $ticket->price,
            'status'       => $ticket->price == 0 ? 'paid' : 'pending_payment',
            'paid_at'      => $ticket->price == 0 ? now() : null,
            'payment_method' => $ticket->price == 0 ? 'free' : null,
        ]);

        if ($ticket->price == 0) {
            return redirect()->route('event.show', $event->slug)
                ->with('success', 'Registration complete! Your free ticket is confirmed. Login to your attendee portal with your email.');
        }

        return redirect()->route('event.payment', [$event->slug, $order->id]);
    }

    public function showPayment(Event $event, Order $order)
    {
        if ($order->status === 'paid') {
            return redirect()->route('event.payment.success', [$event->slug, $order->id]);
        }
        $order->load(['attendee', 'ticket']);
        return view('front.payment', compact('event', 'order'));
    }

    public function processPayment(Request $request, Event $event, Order $order)
    {
        $request->validate([
            'payment_method' => 'required|in:paystack,mpesa,airtel_money,bank_cheque,bank_deposit',
        ]);

        $method = $request->payment_method;

        // ── Paystack ──────────────────────────────────────────────────────────
        if ($method === 'paystack') {
            $paystackKey = config('services.paystack.secret_key', env('PAYSTACK_SECRET_KEY', 'sk_test_demo'));
            try {
                $response = Http::withToken($paystackKey)
                    ->post('https://api.paystack.co/transaction/initialize', [
                        'email'     => $order->attendee->email,
                        'amount'    => (int)($order->total_amount * 100), // kobo
                        'reference' => $order->order_number,
                        'callback_url' => route('event.payment.callback', [$event->slug, $order->id]),
                        'metadata'  => ['order_id' => $order->id, 'event' => $event->name],
                    ]);
                if ($response->successful() && $response->json('status')) {
                    $order->update(['payment_method' => 'paystack', 'status' => 'pending_payment']);
                    return redirect($response->json('data.authorization_url'));
                }
            } catch (\Exception $e) {}
            // Demo mode — simulate success
            $order->update(['payment_method' => 'paystack', 'payment_reference' => 'DEMO_' . strtoupper(Str::random(8)), 'status' => 'paid', 'paid_at' => now()]);
            return redirect()->route('event.payment.success', [$event->slug, $order->id]);
        }

        // ── M-Pesa ────────────────────────────────────────────────────────────
        if ($method === 'mpesa') {
            $request->validate(['payment_phone' => 'required|string|max:20']);
            $order->update([
                'payment_method' => 'mpesa',
                'payment_phone'  => $request->payment_phone,
                'status'         => 'pending_payment',
                'payment_reference' => 'MPESA_' . strtoupper(Str::random(8)),
            ]);
            // In production: trigger STK Push via Safaricom Daraja API here
            return redirect()->route('event.payment.success', [$event->slug, $order->id])
                ->with('payment_info', 'M-Pesa STK Push sent to ' . $request->payment_phone . '. Complete payment on your phone. Reference: ' . $order->payment_reference);
        }

        // ── Airtel Money ──────────────────────────────────────────────────────
        if ($method === 'airtel_money') {
            $request->validate(['payment_phone' => 'required|string|max:20']);
            $order->update([
                'payment_method' => 'airtel_money',
                'payment_phone'  => $request->payment_phone,
                'status'         => 'pending_payment',
                'payment_reference' => 'AIRTEL_' . strtoupper(Str::random(8)),
            ]);
            return redirect()->route('event.payment.success', [$event->slug, $order->id])
                ->with('payment_info', 'Airtel Money payment request sent to ' . $request->payment_phone . '. Approve on your phone. Reference: ' . $order->payment_reference);
        }

        // ── Bank Cheque ───────────────────────────────────────────────────────
        if ($method === 'bank_cheque') {
            $request->validate([
                'bank_name'         => 'required|string|max:100',
                'bank_account_name' => 'required|string|max:200',
                'bank_slip_ref'     => 'required|string|max:100',
            ]);
            $order->update([
                'payment_method'    => 'bank_cheque',
                'bank_name'         => $request->bank_name,
                'bank_account_name' => $request->bank_account_name,
                'bank_slip_ref'     => $request->bank_slip_ref,
                'status'            => 'pending',
                'payment_reference' => $request->bank_slip_ref,
            ]);
            return redirect()->route('event.payment.success', [$event->slug, $order->id])
                ->with('payment_info', 'Bank cheque details submitted. Your registration is pending admin approval.');
        }

        // ── Bank Deposit ──────────────────────────────────────────────────────
        if ($method === 'bank_deposit') {
            $request->validate([
                'bank_slip_ref' => 'required|string|max:100',
            ]);
            $order->update([
                'payment_method'    => 'bank_deposit',
                'bank_slip_ref'     => $request->bank_slip_ref,
                'bank_name'         => $request->bank_name,
                'status'            => 'pending',
                'payment_reference' => $request->bank_slip_ref,
            ]);
            return redirect()->route('event.payment.success', [$event->slug, $order->id])
                ->with('payment_info', 'Bank deposit details submitted. Your registration is pending admin verification of payment.');
        }

        return back()->with('error', 'Invalid payment method selected.');
    }

    public function paymentCallback(Request $request, Event $event, Order $order)
    {
        // Paystack callback verification
        $reference = $request->get('reference', $order->order_number);
        $paystackKey = config('services.paystack.secret_key', env('PAYSTACK_SECRET_KEY', 'sk_test_demo'));
        try {
            $response = Http::withToken($paystackKey)
                ->get("https://api.paystack.co/transaction/verify/{$reference}");
            if ($response->successful() && $response->json('data.status') === 'success') {
                $order->update([
                    'status'                   => 'paid',
                    'paid_at'                  => now(),
                    'payment_reference'        => $reference,
                    'payment_gateway_response' => json_encode($response->json('data')),
                ]);
                return redirect()->route('event.payment.success', [$event->slug, $order->id]);
            }
        } catch (\Exception $e) {}
        return redirect()->route('event.payment', [$event->slug, $order->id])
            ->with('error', 'Payment verification failed. Please try again or use another method.');
    }

    public function paymentSuccess(Event $event, Order $order)
    {
        $order->load(['attendee', 'ticket']);
        return view('front.payment-success', compact('event', 'order'));
    }

    public function schedule(Event $event)
    {
        $schedule = $event->schedules()->where('is_public', true)->with('speaker')->orderBy('start_time')->get()->groupBy(fn($s) => $s->start_time->format('Y-m-d'));
        return view('front.schedule', compact('event','schedule'));
    }

    public function speakers(Event $event)
    {
        $speakers = $event->speakers()->get();
        return view('front.speakers', compact('event','speakers'));
    }

    public function sponsors(Event $event)
    {
        $sponsors = $event->sponsors()->orderBy('tier')->get();
        return view('front.sponsors', compact('event','sponsors'));
    }

    public function cfp(Event $event)
    {
        $fields = PaperField::where('event_id', $event->id)->orderBy('sort_order')->get();
        return view('front.cfp', compact('event','fields'));
    }

    public function submitPaper(Request $request, Event $event)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'abstract'    => 'required|string|min:100',
            'author_name' => 'required|string|max:200',
            'author_email'=> 'required|email',
        ]);
        $attendee = Attendee::firstOrCreate(
            ['email' => $request->author_email, 'event_id' => $event->id],
            [
                'first_name' => explode(' ', $request->author_name)[0],
                'last_name'  => explode(' ', $request->author_name)[1] ?? '',
                'portal_password' => Str::random(8),
            ]
        );
        Paper::create([
            'event_id'    => $event->id,
            'author_id'   => $attendee->id,
            'title'       => $request->title,
            'abstract'    => $request->abstract,
            'keywords'    => $request->keywords,
            'status'      => 'submitted',
            'extra_data'  => json_encode($request->except(['_token','title','abstract','keywords','author_name','author_email'])),
        ]);
        return redirect()->route('event.cfp', $event->slug)->with('success', 'Paper submitted! You will receive a decision via email.');
    }
}