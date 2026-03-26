<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\AccessCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccessCodeController extends Controller
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
        $codes = AccessCode::where('event_id', $eventId)->withCount('usages')->get();
        return view('admin.access-codes.index', compact('event','codes'));
    }

    public function create($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($eventId);
        return view('admin.access-codes.create', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $validated = $request->validate([
            'code'         => 'nullable|string|unique:access_codes,code',
            'discount_type'=> 'required|in:percentage,fixed',
            'discount'     => 'required|numeric|min:0',
            'max_uses'     => 'nullable|integer|min:1',
            'expires_at'   => 'nullable|date',
            'description'  => 'nullable|string|max:255',
        ]);
        $validated['event_id'] = $eventId;
        $validated['code']     = $validated['code'] ?? strtoupper(Str::random(8));
        AccessCode::create($validated);
        return redirect()->route('admin.access-codes.index', $eventId)->with('success', 'Access code created!');
    }

    public function destroy($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        AccessCode::findOrFail($id)->delete();
        return redirect()->route('admin.access-codes.index', $eventId)->with('success', 'Code deleted.');
    }
}