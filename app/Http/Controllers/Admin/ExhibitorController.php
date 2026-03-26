<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Exhibitor;
use Illuminate\Http\Request;

class ExhibitorController extends Controller
{
    private function authCheck()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return null;
    }

    public function index($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event      = Event::findOrFail($eventId);
        $exhibitors = Exhibitor::where('event_id', $eventId)->get();
        return view('admin.exhibitors.index', compact('event','exhibitors'));
    }

    public function create($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($eventId);
        return view('admin.exhibitors.create', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'booth_number' => 'nullable|string|max:50',
            'description'  => 'nullable|string',
            'logo'         => 'nullable|string|max:500',
            'website'      => 'nullable|url',
            'contact_name' => 'nullable|string|max:255',
            'contact_email'=> 'nullable|email',
            'booth_size'   => 'nullable|in:small,medium,large,extra_large',
        ]);
        $validated['event_id'] = $eventId;
        Exhibitor::create($validated);
        return redirect()->route('admin.exhibitors.index', $eventId)->with('success', 'Exhibitor added!');
    }

    public function edit($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $event     = Event::findOrFail($eventId);
        $exhibitor = Exhibitor::findOrFail($id);
        return view('admin.exhibitors.edit', compact('event','exhibitor'));
    }

    public function update(Request $request, $eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $exhibitor = Exhibitor::findOrFail($id);
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'booth_number' => 'nullable|string|max:50',
            'description'  => 'nullable|string',
            'logo'         => 'nullable|string|max:500',
            'website'      => 'nullable|url',
            'contact_name' => 'nullable|string|max:255',
            'contact_email'=> 'nullable|email',
            'booth_size'   => 'nullable|in:small,medium,large,extra_large',
        ]);
        $exhibitor->update($validated);
        return redirect()->route('admin.exhibitors.index', $eventId)->with('success', 'Exhibitor updated!');
    }

    public function destroy($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        Exhibitor::findOrFail($id)->delete();
        return redirect()->route('admin.exhibitors.index', $eventId)->with('success', 'Exhibitor removed.');
    }
}