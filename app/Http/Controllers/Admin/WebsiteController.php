<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class WebsiteController extends Controller
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
        return view('admin.website.index', compact('event'));
    }

    public function update(Request $request, $eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($eventId);
        $validated = $request->validate([
            'website_hero_title'    => 'nullable|string|max:255',
            'website_hero_subtitle' => 'nullable|string|max:500',
            'website_primary_color' => 'nullable|string|max:20',
            'website_about'         => 'nullable|string',
            'website_show_speakers' => 'boolean',
            'website_show_schedule' => 'boolean',
            'website_show_sponsors' => 'boolean',
            'custom_domain'         => 'nullable|string|max:255',
        ]);
        $event->update($validated);
        return back()->with('success', 'Website settings saved!');
    }
}