@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard')
@section('page-subtitle','Welcome back, {{ session("admin_name","Admin") }} — here\'s your event overview')
@section('header-actions')
<a href="{{ route('admin.events.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 flex items-center gap-2">
    <i class="fas fa-plus"></i> New Event
</a>
@endsection
@section('content')
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-indigo-500">
        <p class="text-gray-400 text-xs uppercase tracking-wide">Total Events</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalEvents }}</p>
        <p class="text-xs text-indigo-600 mt-1">{{ $publishedEvents }} published</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
        <p class="text-gray-400 text-xs uppercase tracking-wide">Total Orders</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalOrders }}</p>
        <p class="text-xs text-green-600 mt-1">All time</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
        <p class="text-gray-400 text-xs uppercase tracking-wide">Revenue</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">${{ number_format($totalRevenue) }}</p>
        <p class="text-xs text-blue-600 mt-1">Paid orders</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500">
        <p class="text-gray-400 text-xs uppercase tracking-wide">Attendees</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalAttendees }}</p>
        <p class="text-xs text-purple-600 mt-1">Registered</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-orange-500">
        <p class="text-gray-400 text-xs uppercase tracking-wide">Pending Papers</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $pendingPapers }}</p>
        <p class="text-xs text-orange-600 mt-1">Awaiting review</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-teal-500">
        <p class="text-gray-400 text-xs uppercase tracking-wide">Published</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $publishedEvents }}</p>
        <p class="text-xs text-teal-600 mt-1">Live events</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-bold text-gray-800 mb-4">Recent Events</h3>
        <div class="space-y-3">
            @foreach($recentEvents as $e)
            <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                        <i class="fas fa-calendar text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="font-medium text-sm">{{ $e->name }}</p>
                        <p class="text-gray-400 text-xs">{{ $e->start_date->format('M d, Y') }} · {{ $e->location }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 text-xs rounded-full {{ $e->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ ucfirst($e->status) }}</span>
                    <a href="{{ route('admin.events.show', $e->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm"><i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            @endforeach
        </div>
        <a href="{{ route('admin.events.index') }}" class="block text-center text-indigo-600 text-sm mt-4 hover:underline">View all events →</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-bold text-gray-800 mb-4">Recent Orders</h3>
        <div class="space-y-2">
            @foreach($recentOrders as $o)
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <div>
                    <p class="text-sm font-medium">{{ $o->attendee?->first_name }} {{ $o->attendee?->last_name }}</p>
                    <p class="text-xs text-gray-400">{{ $o->order_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold">${{ number_format($o->total_amount,2) }}</p>
                    <span class="text-xs px-1.5 py-0.5 rounded {{ $o->status_badge }}">{{ ucfirst($o->status) }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
