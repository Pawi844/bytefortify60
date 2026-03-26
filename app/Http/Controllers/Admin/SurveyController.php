<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    private function authCheck()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event   = Event::findOrFail($eventId);
        $surveys = Survey::where('event_id', $eventId)->withCount('responses')->get();
        return view('admin.surveys.index', compact('event','surveys'));
    }

    public function create($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($eventId);
        return view('admin.surveys.create', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions'   => 'required|string',
            'is_active'   => 'boolean',
            'starts_at'   => 'nullable|date',
            'ends_at'     => 'nullable|date',
        ]);
        $validated['event_id'] = $eventId;
        Survey::create($validated);
        return redirect()->route('admin.surveys.index', $eventId)->with('success', 'Survey created!');
    }

    public function show($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $event  = Event::findOrFail($eventId);
        $survey = Survey::with('responses.attendee')->findOrFail($id);
        return view('admin.surveys.show', compact('event','survey'));
    }

    public function edit($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $event  = Event::findOrFail($eventId);
        $survey = Survey::findOrFail($id);
        return view('admin.surveys.edit', compact('event','survey'));
    }

    public function update(Request $request, $eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $survey = Survey::findOrFail($id);
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions'   => 'required|string',
            'is_active'   => 'boolean',
            'starts_at'   => 'nullable|date',
            'ends_at'     => 'nullable|date',
        ]);
        $survey->update($validated);
        return redirect()->route('admin.surveys.index', $eventId)->with('success', 'Survey updated!');
    }

    public function destroy($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        Survey::findOrFail($id)->delete();
        return redirect()->route('admin.surveys.index', $eventId)->with('success', 'Survey deleted.');
    }
}