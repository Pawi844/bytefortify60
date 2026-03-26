<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Http\Request;

class CheckInController extends Controller
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
            ->orderBy('last_name')
            ->get();
        $checkedInCount = Attendee::where('event_id', $eventId)->where('checked_in', true)->count();
        $totalCount     = Attendee::where('event_id', $eventId)->count();
        return view('admin.check-in.index', compact('event','attendees','search','checkedInCount','totalCount'));
    }

    public function checkIn(Request $request, $eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $request->validate(['attendee_id' => 'required|exists:attendees,id']);
        $attendee = Attendee::findOrFail($request->attendee_id);
        $attendee->update(['checked_in' => true, 'checked_in_at' => now()]);
        return back()->with('success', "✅ {$attendee->first_name} {$attendee->last_name} checked in!");
    }

    public function undo($eventId, $attendeeId)
    {
        if ($r = $this->authCheck()) return $r;
        $attendee = Attendee::findOrFail($attendeeId);
        $attendee->update(['checked_in' => false, 'checked_in_at' => null]);
        return back()->with('info', 'Check-in undone.');
    }
}