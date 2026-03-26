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
        $attendee = Attendee::create([
            'event_id'        => $event->id,
            'first_name'      => $validated['first_name'],
            'last_name'       => $validated['last_name'],
            'email'           => $validated['email'],
            'phone'           => $validated['phone'] ?? null,
            'organization'    => $validated['organization'] ?? null,
            'job_title'       => $validated['job_title'] ?? null,
            'dietary'         => $validated['dietary'] ?? null,
            'portal_password' => Str::random(8),
        ]);
        $order = Order::create([
            'event_id'      => $event->id,
            'attendee_id'   => $attendee->id,
            'ticket_id'     => $ticket->id,
            'order_number'  => strtoupper(Str::random(10)),
            'total_amount'  => $ticket->price,
            'status'        => $ticket->price == 0 ? 'paid' : 'pending',
            'paid_at'       => $ticket->price == 0 ? now() : null,
        ]);
        return redirect()->route('event.show', $event->slug)->with('success', 'Registration complete! Check your email for details. Your portal login is your email address.');
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