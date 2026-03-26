@extends('layouts.portal')
@section('page-title','My Dashboard')
@section('page-subtitle', 'Welcome back, '.session('attendee_name','Attendee'))
@section('content')
<div class="grid md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-indigo-500">
        <p class="text-gray-400 text-sm">My Event</p>
        <p class="font-bold text-lg mt-1">{{ $event->name }}</p>
        <p class="text-gray-400 text-sm">{{ $event->start_date->format('M d, Y') }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
        <p class="text-gray-400 text-sm">Registration Status</p>
        @php $order = $attendee->orders->first() @endphp
        <p class="font-bold text-xl mt-1 {{ $order?->status==='paid'?'text-green-600':'text-yellow-600' }}">{{ $order ? ucfirst($order->status) : 'No Order' }}</p>
        <p class="text-gray-400 text-sm">{{ $order?->ticket?->name }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
        <p class="text-gray-400 text-sm">Check-In Status</p>
        <p class="font-bold text-xl mt-1 {{ $attendee->checked_in?'text-green-600':'text-gray-400' }}">{{ $attendee->checked_in ? '✅ Checked In' : 'Not Yet' }}</p>
        @if($attendee->checked_in_at)<p class="text-gray-400 text-sm">{{ $attendee->checked_in_at->format('M d, g:ia') }}</p>@endif
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-bold text-lg mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('portal.profile') }}" class="flex flex-col items-center gap-2 p-4 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition">
                <i class="fas fa-user-edit text-indigo-600 text-xl"></i>
                <span class="text-sm font-medium">Edit Profile</span>
            </a>
            <a href="{{ route('portal.tickets') }}" class="flex flex-col items-center gap-2 p-4 bg-green-50 rounded-xl hover:bg-green-100 transition">
                <i class="fas fa-ticket-alt text-green-600 text-xl"></i>
                <span class="text-sm font-medium">My Tickets</span>
            </a>
            <a href="{{ route('portal.schedule') }}" class="flex flex-col items-center gap-2 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition">
                <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                <span class="text-sm font-medium">Schedule</span>
            </a>
            <a href="{{ route('portal.surveys') }}" class="flex flex-col items-center gap-2 p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition">
                <i class="fas fa-poll text-purple-600 text-xl"></i>
                <span class="text-sm font-medium">Surveys</span>
            </a>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-bold text-lg mb-4">Upcoming Sessions</h3>
        @forelse($schedule as $session)
        <div class="flex gap-3 py-2 border-b border-gray-50 last:border-0">
            <div class="text-center min-w-14"><p class="text-indigo-600 font-bold text-xs">{{ $session->start_time->format('g:ia') }}</p><p class="text-gray-400 text-xs">{{ $session->start_time->format('M d') }}</p></div>
            <div><p class="text-sm font-medium">{{ $session->title }}</p>@if($session->room)<p class="text-gray-400 text-xs">{{ $session->room }}</p>@endif</div>
        </div>
        @empty
        <p class="text-gray-400 text-sm">No upcoming sessions.</p>
        @endforelse
        <a href="{{ route('portal.schedule') }}" class="text-indigo-600 text-sm mt-3 inline-block hover:underline">View full schedule →</a>
    </div>
</div>
@endsection
