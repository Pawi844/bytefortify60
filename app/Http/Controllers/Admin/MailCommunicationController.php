<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\MailCommunication;
use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailCommunicationController extends Controller
{
    private function authCheck()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($eventId);
        $comms = MailCommunication::where('event_id', $eventId)->latest()->paginate(15);
        return view('admin.communications.index', compact('event','comms'));
    }

    public function create($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($eventId);
        return view('admin.communications.create', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $validated = $request->validate([
            'subject'    => 'required|string|max:255',
            'body'       => 'required|string',
            'recipients' => 'required|in:all,paid,pending,checked_in',
            'send_at'    => 'nullable|date',
        ]);
        $validated['event_id'] = $eventId;
        $validated['status']   = 'draft';
        $validated['sent_by']  = session('admin_email');
        $comm = MailCommunication::create($validated);
        return redirect()->route('admin.communications.show', [$eventId, $comm->id])->with('success', 'Email draft saved!');
    }

    public function show($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($eventId);
        $comm  = MailCommunication::findOrFail($id);
        return view('admin.communications.show', compact('event','comm'));
    }

    public function send($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $comm  = MailCommunication::findOrFail($id);
        $event = Event::findOrFail($eventId);
        $query = Attendee::where('event_id', $eventId);
        if ($comm->recipients === 'paid') {
            $query->whereHas('orders', fn($q) => $q->where('status','paid'));
        } elseif ($comm->recipients === 'pending') {
            $query->whereHas('orders', fn($q) => $q->where('status','pending'));
        } elseif ($comm->recipients === 'checked_in') {
            $query->where('checked_in', true);
        }
        $attendees = $query->get();
        $sentCount = 0;
        foreach ($attendees as $attendee) {
            try {
                Mail::raw($comm->body, function($m) use ($attendee, $comm, $event) {
                    $m->to($attendee->email, $attendee->first_name.' '.$attendee->last_name)
                      ->subject($comm->subject)
                      ->from(config('mail.from.address'), $event->name);
                });
                $sentCount++;
            } catch (\Exception $e) {
                // Log failure silently
            }
        }
        $comm->update(['status' => 'sent', 'sent_at' => now(), 'sent_count' => $sentCount]);
        return back()->with('success', "Email sent to {$sentCount} attendees!");
    }

    public function destroy($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        MailCommunication::findOrFail($id)->delete();
        return redirect()->route('admin.communications.index', $eventId)->with('success', 'Communication deleted.');
    }
}