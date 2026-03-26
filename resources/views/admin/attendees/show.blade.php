@extends('layouts.admin')
@section('page-title', $attendee->first_name . ' ' . $attendee->last_name)
@section('page-subtitle', $attendee->email)
@section('header-actions')
<a href="{{ route('admin.attendees.badge', [$event->id, $attendee->id]) }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700"><i class="fas fa-id-badge mr-1"></i>Print Badge</a>
<a href="{{ route('admin.attendees.edit', [$event->id, $attendee->id]) }}" class="bg-white border text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-50"><i class="fas fa-edit mr-1"></i>Edit</a>
@endsection
@section('content')
<div class="grid md:grid-cols-3 gap-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="text-center mb-6">
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-3xl font-bold mx-auto mb-3">{{ strtoupper(substr($attendee->first_name,0,1)) }}</div>
            <h2 class="text-xl font-bold">{{ $attendee->first_name }} {{ $attendee->last_name }}</h2>
            <p class="text-gray-400 text-sm">{{ $attendee->job_title }}</p>
            <p class="text-gray-400 text-sm">{{ $attendee->organization }}</p>
        </div>
        <div class="space-y-2 text-sm">
            <div class="flex gap-2"><i class="fas fa-envelope text-gray-400 w-4 mt-0.5"></i><span>{{ $attendee->email }}</span></div>
            @if($attendee->phone)<div class="flex gap-2"><i class="fas fa-phone text-gray-400 w-4 mt-0.5"></i><span>{{ $attendee->phone }}</span></div>@endif
            @if($attendee->dietary)<div class="flex gap-2"><i class="fas fa-utensils text-gray-400 w-4 mt-0.5"></i><span>{{ $attendee->dietary }}</span></div>@endif
        </div>
        <div class="mt-4 pt-4 border-t">
            @if($attendee->checked_in)
            <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm"><i class="fas fa-check-circle"></i>Checked In {{ $attendee->checked_in_at?->format('M d, g:ia') }}</span>
            @else
            <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-sm"><i class="fas fa-clock"></i>Not Yet Checked In</span>
            @endif
        </div>
    </div>
    <div class="md:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-bold mb-4">Orders & Tickets</h3>
            @forelse($attendee->orders as $order)
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg mb-2">
                <div>
                    <p class="font-medium text-sm">{{ $order->ticket?->name }}</p>
                    <p class="text-gray-400 text-xs">#{{ $order->order_number }}</p>
                </div>
                <div class="text-right flex items-center gap-2">
                    <span class="px-2 py-0.5 rounded-full text-xs {{ $order->status_badge }}">{{ ucfirst($order->status) }}</span>
                    <a href="{{ route('admin.orders.invoice', [$event->id, $order->id]) }}" class="text-blue-600 text-xs hover:underline">Invoice</a>
                    <a href="{{ route('admin.orders.receipt', [$event->id, $order->id]) }}" class="text-green-600 text-xs hover:underline">Receipt</a>
                </div>
            </div>
            @empty<p class="text-gray-400 text-sm">No orders.</p>@endforelse
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-bold mb-4">Submitted Papers</h3>
            @forelse($attendee->papers as $paper)
            <div class="p-3 bg-gray-50 rounded-lg mb-2">
                <p class="font-medium text-sm">{{ $paper->title }}</p>
                <span class="px-2 py-0.5 rounded-full text-xs {{ $paper->status_badge }}">{{ ucfirst(str_replace('_',' ',$paper->status)) }}</span>
            </div>
            @empty<p class="text-gray-400 text-sm">No papers submitted.</p>@endforelse
        </div>
    </div>
</div>
@endsection
