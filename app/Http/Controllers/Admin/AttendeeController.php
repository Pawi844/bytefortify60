<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    private function authCheck()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event     = Event::findOrFail($eventId);
        $search    = request('search');
        $attendees = Attendee::where('event_id', $eventId)
            ->when($search, fn($q) => $q->where('first_name','like',"%$search%")->orWhere('last_name','like',"%$search%")->orWhere('email','like',"%$search%"))
            ->with('orders')
            ->paginate(20);
        return view('admin.attendees.index', compact('event','attendees','search'));
    }

    public function show($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $event    = Event::findOrFail($eventId);
        $attendee = Attendee::with(['orders.ticket','papers'])->findOrFail($id);
        return view('admin.attendees.show', compact('event','attendee'));
    }

    public function edit($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $event    = Event::findOrFail($eventId);
        $attendee = Attendee::findOrFail($id);
        return view('admin.attendees.edit', compact('event','attendee'));
    }

    public function update(Request $request, $eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $attendee  = Attendee::findOrFail($id);
        $validated = $request->validate([
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'email'        => 'required|email|max:255',
            'phone'        => 'nullable|string|max:30',
            'organization' => 'nullable|string|max:255',
            'job_title'    => 'nullable|string|max:255',
            'dietary'      => 'nullable|string|max:255',
            'notes'        => 'nullable|string',
        ]);
        $attendee->update($validated);
        return redirect()->route('admin.attendees.show', [$eventId, $id])->with('success', 'Attendee updated!');
    }

    public function destroy($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        Attendee::findOrFail($id)->delete();
        return redirect()->route('admin.attendees.index', $eventId)->with('success', 'Attendee removed.');
    }

    public function badge($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $event    = Event::findOrFail($eventId);
        $attendee = Attendee::with('orders.ticket')->findOrFail($id);
        return view('admin.attendees.badge', compact('event','attendee'));
    }

    public function export($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $attendees = Attendee::where('event_id', $eventId)->with('orders.ticket')->get();
        $csv  = "First Name,Last Name,Email,Phone,Organization,Job Title,Checked In,Ticket\n";
        foreach ($attendees as $a) {
            $ticket = $a->orders->first()?->ticket?->name ?? 'N/A';
            $csv   .= "\"{$a->first_name}\",\"{$a->last_name}\",\"{$a->email}\",\"{$a->phone}\",\"{$a->organization}\",\"{$a->job_title}\",\".($a->checked_in?'Yes':'No')."\",\"{$ticket}\"\n";
        }
        return response($csv, 200, ['Content-Type'=>'text/csv','Content-Disposition'=>'attachment; filename="attendees.csv"']);
    }

    public function import(Request $request, $eventId)
    {
        if ($r = $this->authCheck()) return $r;
        return back()->with('info', 'CSV import feature — upload handled via storage.');
    }
}