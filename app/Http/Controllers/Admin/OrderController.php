<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
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
        $orders = Order::where('event_id', $eventId)->with(['attendee','ticket'])->latest()->paginate(20);
        $totalRevenue  = Order::where('event_id',$eventId)->where('status','paid')->sum('total_amount');
        $pendingOrders = Order::where('event_id',$eventId)->where('status','pending')->count();
        return view('admin.orders.index', compact('event','orders','totalRevenue','pendingOrders'));
    }

    public function show($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($eventId);
        $order = Order::with(['attendee','ticket','event'])->findOrFail($id);
        return view('admin.orders.show', compact('event','order'));
    }

    public function approve($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $order = Order::findOrFail($id);
        $order->update(['status' => 'paid', 'paid_at' => now()]);
        return back()->with('success', 'Order approved and marked as paid.');
    }

    public function refund($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $order = Order::findOrFail($id);
        $order->update(['status' => 'refunded', 'refunded_at' => now()]);
        return back()->with('success', 'Order marked as refunded.');
    }

    public function invoice($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($eventId);
        $order = Order::with(['attendee','ticket','event'])->findOrFail($id);
        return view('admin.orders.invoice', compact('event','order'));
    }

    public function receipt($eventId, $id)
    {
        if ($r = $this->authCheck()) return $r;
        $event = Event::findOrFail($eventId);
        $order = Order::with(['attendee','ticket','event'])->findOrFail($id);
        return view('admin.orders.receipt', compact('event','order'));
    }
}