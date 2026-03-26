<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\Attendee;
use App\Models\Paper;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $totalEvents      = Event::count();
        $publishedEvents  = Event::where('status', 'published')->count();
        $totalOrders      = Order::count();
        $totalRevenue     = Order::where('status', 'paid')->sum('total_amount');
        $totalAttendees   = Attendee::count();
        $pendingPapers    = Paper::where('status', 'submitted')->count();

        $recentEvents     = Event::latest()->take(5)->get();
        $recentOrders     = Order::with(['attendee', 'event'])->latest()->take(8)->get();

        $monthlyRevenue   = Order::where('status', 'paid')
            ->where('created_at', '>=', now()->subMonths(6))
            ->get()
            ->groupBy(fn($o) => $o->created_at->format('M Y'))
            ->map(fn($g) => $g->sum('total_amount'));

        return view('admin.dashboard', compact(
            'totalEvents', 'publishedEvents', 'totalOrders', 'totalRevenue',
            'totalAttendees', 'pendingPapers', 'recentEvents', 'recentOrders', 'monthlyRevenue'
        ));
    }
}