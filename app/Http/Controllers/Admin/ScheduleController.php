<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Schedule;
use App\Models\Speaker;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    private function authCheck()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event    = Event::findOrFail($eventId);
        $schedule = Schedule::where('event_id', $eventId)->with('speaker')->orderBy('start_time')->get()->groupBy(fn($s) => $s->start_time->format('Y-m-d'));
        return view('admin.schedule.index', compact('event','schedule'));
    }

    public function create($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event    = Event::findOrFail($eventId);
        $speakers = Speaker::where('event_id', $eventId)->get();
        return view('admin.schedule.create', compact('event','speakers'));
    }

    public function store(Request $request, $eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time'  => 'required|date',
            'end_time'    => 'required|date|after:start_time',
            'room'        => 'nullable|string|max:100',
            'track'       => 'nullable|string|max:100',
            'session_type'=> 'required|in:keynote,talk,workshop,panel,break,networking',
            'speaker_id'  => 'nullable|exists:speakers,id',
            'capacity'    => 'nullable|integer|min:1',
            'is_public'   => 'boolean',
        ]);
        $validated['event_id'] = $eventId;
        Schedule::create($validated);
        return redirect()->route('admin.schedule.index', $eventId)->with('success', 'Session added!');
    }

    public function edit($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $event    = Event::findOrFail($eventId);
        $session  = Schedule::findOrFail($id);
        $speakers = Speaker::where('event_id', $eventId)->get();
        return view('admin.schedule.edit', compact('event','session','speakers'));
    }

    public function update(Request $request, $eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $session   = Schedule::findOrFail($id);
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'start_time'   => 'required|date',
            'end_time'     => 'required|date|after:start_time',
            'room'         => 'nullable|string|max:100',
            'track'        => 'nullable|string|max:100',
            'session_type' => 'required|in:keynote,talk,workshop,panel,break,networking',
            'speaker_id'   => 'nullable|exists:speakers,id',
            'capacity'     => 'nullable|integer|min:1',
            'is_public'    => 'boolean',
        ]);
        $session->update($validated);
        return redirect()->route('admin.schedule.index', $eventId)->with('success', 'Session updated!');
    }

    public function destroy($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        Schedule::findOrFail($id)->delete();
        return redirect()->route('admin.schedule.index', $eventId)->with('success', 'Session removed.');
    }
}