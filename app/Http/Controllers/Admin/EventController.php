<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    private function authCheck()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    /**
     * Generate a unique slug, appending a counter if slug already exists.
     */
    private function uniqueSlug(string $base, ?int $excludeId = null): string
    {
        $slug      = Str::slug($base);
        $original  = $slug;
        $counter   = 1;

        while (true) {
            $query = Event::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            if (!$query->exists()) {
                break;
            }
            $slug = $original . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function index()
    {
        if ($r = $this->authCheck()) return $r;
        $events = Event::withCount(['attendees','orders','speakers','papers'])->latest()->paginate(12);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        if ($r = $this->authCheck()) return $r;
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        if ($r = $this->authCheck()) return $r;

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'slug'         => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'venue'        => 'nullable|string|max:255',
            'location'     => 'nullable|string|max:255',
            'timezone'     => 'nullable|string|max:100',
            'capacity'     => 'nullable|integer|min:1',
            'category'     => 'nullable|string|max:100',
            'cover_image'  => 'nullable|string|max:500',
            'is_virtual'   => 'boolean',
            'virtual_link' => 'nullable|url',
        ]);

        // Always generate a guaranteed-unique slug
        $baseSlug           = !empty($validated['slug']) ? $validated['slug'] : $validated['name'];
        $validated['slug']  = $this->uniqueSlug($baseSlug);

        $validated['status']     = 'draft';
        $validated['created_by'] = session('admin_email');

        $event = Event::create($validated);

        return redirect()->route('admin.events.show', $event->id)
            ->with('success', 'Event created successfully!');
    }

    public function show($id)
    {
        if ($r = $this->authCheck()) return $r;
        $event     = Event::withCount(['attendees','orders','speakers','papers','schedules'])->findOrFail($id);
        $revenue   = $event->orders()->where('status','paid')->sum('total_amount');
        $checkedIn = $event->attendees()->where('checked_in', true)->count();
        return view('admin.events.show', compact('event','revenue','checkedIn'));
    }

    public function edit($id)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'venue'        => 'nullable|string|max:255',
            'location'     => 'nullable|string|max:255',
            'timezone'     => 'nullable|string|max:100',
            'capacity'     => 'nullable|integer|min:1',
            'category'     => 'nullable|string|max:100',
            'cover_image'  => 'nullable|string|max:500',
            'is_virtual'   => 'boolean',
            'virtual_link' => 'nullable|url',
        ]);

        $event->update($validated);

        return redirect()->route('admin.events.show', $id)
            ->with('success', 'Event updated successfully!');
    }

    public function destroy($id)
    {
        if ($r = $this->authCheck()) return $r;
        Event::findOrFail($id)->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted.');
    }

    public function publish($id)
    {
        if ($r = $this->authCheck()) return $r;
        Event::findOrFail($id)->update(['status' => 'published']);
        return back()->with('success', 'Event published!');
    }

    public function unpublish($id)
    {
        if ($r = $this->authCheck()) return $r;
        Event::findOrFail($id)->update(['status' => 'draft']);
        return back()->with('success', 'Event set to draft.');
    }
}