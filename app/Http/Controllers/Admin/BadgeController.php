<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Http\Request;

class BadgeController extends Controller
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
        return view('admin.badges.index', compact('event'));
    }

    public function update(Request $request, $eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($eventId);
        $event->update(['badge_settings' => json_encode($request->except('_token','_method'))]);
        return back()->with('success', 'Badge template saved!');
    }

    public function printAll($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event     = Event::findOrFail($eventId);
        $attendees = Attendee::where('event_id', $eventId)->with('orders.ticket')->get();
        return view('admin.badges.print-all', compact('event','attendees'));
    }
}