<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Http\Request;

class SpeakerController extends Controller
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
        $speakers = Speaker::where('event_id', $eventId)->get();
        return view('admin.speakers.index', compact('event','speakers'));
    }

    public function create($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($eventId);
        return view('admin.speakers.create', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $validated = $request->validate([
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'email'        => 'nullable|email|max:255',
            'bio'          => 'nullable|string',
            'organization' => 'nullable|string|max:255',
            'job_title'    => 'nullable|string|max:255',
            'photo'        => 'nullable|string|max:500',
            'social_twitter'  => 'nullable|url',
            'social_linkedin' => 'nullable|url',
            'social_website'  => 'nullable|url',
            'is_featured'  => 'boolean',
        ]);
        $validated['event_id'] = $eventId;
        Speaker::create($validated);
        return redirect()->route('admin.speakers.index', $eventId)->with('success', 'Speaker added!');
    }

    public function edit($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $event   = Event::findOrFail($eventId);
        $speaker = Speaker::findOrFail($id);
        return view('admin.speakers.edit', compact('event','speaker'));
    }

    public function update(Request $request, $eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $speaker   = Speaker::findOrFail($id);
        $validated = $request->validate([
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'email'        => 'nullable|email|max:255',
            'bio'          => 'nullable|string',
            'organization' => 'nullable|string|max:255',
            'job_title'    => 'nullable|string|max:255',
            'photo'        => 'nullable|string|max:500',
            'social_twitter'  => 'nullable|url',
            'social_linkedin' => 'nullable|url',
            'social_website'  => 'nullable|url',
            'is_featured'  => 'boolean',
        ]);
        $speaker->update($validated);
        return redirect()->route('admin.speakers.index', $eventId)->with('success', 'Speaker updated!');
    }

    public function destroy($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        Speaker::findOrFail($id)->delete();
        return redirect()->route('admin.speakers.index', $eventId)->with('success', 'Speaker removed.');
    }
}