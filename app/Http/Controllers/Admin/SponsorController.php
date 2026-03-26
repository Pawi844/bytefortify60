<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
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
        $sponsors = Sponsor::where('event_id', $eventId)->orderBy('tier')->get();
        return view('admin.sponsors.index', compact('event','sponsors'));
    }

    public function create($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($eventId);
        return view('admin.sponsors.create', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'tier'        => 'required|in:platinum,gold,silver,bronze,partner',
            'logo'        => 'nullable|string|max:500',
            'website'     => 'nullable|url',
            'description' => 'nullable|string',
            'contact_name'=> 'nullable|string|max:255',
            'contact_email'=>'nullable|email',
        ]);
        $validated['event_id'] = $eventId;
        Sponsor::create($validated);
        return redirect()->route('admin.sponsors.index', $eventId)->with('success', 'Sponsor added!');
    }

    public function edit($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $event   = Event::findOrFail($eventId);
        $sponsor = Sponsor::findOrFail($id);
        return view('admin.sponsors.edit', compact('event','sponsor'));
    }

    public function update(Request $request, $eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $sponsor   = Sponsor::findOrFail($id);
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'tier'        => 'required|in:platinum,gold,silver,bronze,partner',
            'logo'        => 'nullable|string|max:500',
            'website'     => 'nullable|url',
            'description' => 'nullable|string',
            'contact_name'=> 'nullable|string|max:255',
            'contact_email'=>'nullable|email',
        ]);
        $sponsor->update($validated);
        return redirect()->route('admin.sponsors.index', $eventId)->with('success', 'Sponsor updated!');
    }

    public function destroy($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        Sponsor::findOrFail($id)->delete();
        return redirect()->route('admin.sponsors.index', $eventId)->with('success', 'Sponsor removed.');
    }
}