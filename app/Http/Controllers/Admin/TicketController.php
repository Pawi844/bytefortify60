<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
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
        $tickets = Ticket::where('event_id', $eventId)->withCount('orders')->get();
        return view('admin.tickets.index', compact('event', 'tickets'));
    }

    public function create($eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($eventId);
        return view('admin.tickets.create', compact('event'));
    }

    public function store(Request $request, $eventId)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($eventId);
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'required|numeric|min:0',
            'quantity'        => 'required|integer|min:1',
            'sale_start'      => 'nullable|date',
            'sale_end'        => 'nullable|date',
            'min_per_order'   => 'nullable|integer|min:1',
            'max_per_order'   => 'nullable|integer|min:1',
            'ticket_type'     => 'required|in:free,paid,donation',
            'is_visible'      => 'boolean',
        ]);
        $validated['event_id'] = $eventId;
        Ticket::create($validated);
        return redirect()->route('admin.tickets.index', $eventId)->with('success', 'Ticket created!');
    }

    public function edit($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $event  = Event::findOrFail($eventId);
        $ticket = Ticket::findOrFail($id);
        return view('admin.tickets.edit', compact('event', 'ticket'));
    }

    public function update(Request $request, $eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $ticket = Ticket::findOrFail($id);
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'required|numeric|min:0',
            'quantity'        => 'required|integer|min:1',
            'sale_start'      => 'nullable|date',
            'sale_end'        => 'nullable|date',
            'min_per_order'   => 'nullable|integer|min:1',
            'max_per_order'   => 'nullable|integer|min:1',
            'ticket_type'     => 'required|in:free,paid,donation',
            'is_visible'      => 'boolean',
        ]);
        $ticket->update($validated);
        return redirect()->route('admin.tickets.index', $eventId)->with('success', 'Ticket updated!');
    }

    public function destroy($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        Ticket::findOrFail($id)->delete();
        return redirect()->route('admin.tickets.index', $eventId)->with('success', 'Ticket deleted.');
    }
}