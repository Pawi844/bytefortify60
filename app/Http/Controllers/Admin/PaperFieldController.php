<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\PaperField;
use Illuminate\Http\Request;

class PaperFieldController extends Controller
{
    private function authCheck()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event  = Event::findOrFail($eventId);
        $fields = PaperField::where('event_id', $eventId)->orderBy('sort_order')->get();
        return view('admin.paper-fields.index', compact('event','fields'));
    }

    public function create($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($eventId);
        return view('admin.paper-fields.create', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $validated = $request->validate([
            'label'       => 'required|string|max:255',
            'field_type'  => 'required|in:text,textarea,select,checkbox,radio,file',
            'options'     => 'nullable|string',
            'is_required' => 'boolean',
            'sort_order'  => 'nullable|integer',
            'help_text'   => 'nullable|string|max:500',
        ]);
        $validated['event_id'] = $eventId;
        PaperField::create($validated);
        return redirect()->route('admin.paper-fields.index', $eventId)->with('success', 'Field added!');
    }

    public function edit($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($eventId);
        $field = PaperField::findOrFail($id);
        return view('admin.paper-fields.edit', compact('event','field'));
    }

    public function update(Request $request, $eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $field = PaperField::findOrFail($id);
        $validated = $request->validate([
            'label'       => 'required|string|max:255',
            'field_type'  => 'required|in:text,textarea,select,checkbox,radio,file',
            'options'     => 'nullable|string',
            'is_required' => 'boolean',
            'sort_order'  => 'nullable|integer',
            'help_text'   => 'nullable|string|max:500',
        ]);
        $field->update($validated);
        return redirect()->route('admin.paper-fields.index', $eventId)->with('success', 'Field updated!');
    }

    public function destroy($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        PaperField::findOrFail($id)->delete();
        return redirect()->route('admin.paper-fields.index', $eventId)->with('success', 'Field deleted.');
    }
}