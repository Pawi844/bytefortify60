@extends('layouts.portal')
@section('page-title','My Tickets')
@section('page-subtitle','Your registrations and order history')
@section('content')
@forelse($orders as $order)
<div class="bg-white rounded-xl shadow-sm p-6 mb-4">
    <div class="flex justify-between items-start">
        <div>
            <p class="text-gray-400 text-xs font-mono mb-1">#{{ $order->order_number }}</p>
            <h3 class="font-bold text-xl">{{ $order->event->name }}</h3>
            <p class="text-gray-500">{{ $order->ticket?->name }}</p>
            <p class="text-gray-400 text-sm">{{ $order->event->start_date->format('M d, Y') }}</p>
        </div>
        <div class="text-right">
            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $order->status_badge }}">{{ ucfirst($order->status) }}</span>
            <p class="text-2xl font-black mt-2">{{ $order->total_amount > 0 ? '$'.number_format($order->total_amount,2) : 'Free' }}</p>
        </div>
    </div>
    @if($order->status === 'paid')
    <div class="flex flex-wrap gap-3 mt-5 pt-5 border-t border-gray-100">
        <a href="{{ route('portal.badge', $order->id) }}" class="flex items-center gap-2 bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition text-sm">
            <i class="fas fa-id-badge"></i> My Badge
        </a>
        <a href="{{ route('portal.invoice', $order->id) }}" class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
            <i class="fas fa-file-invoice"></i> Invoice
        </a>
        <a href="{{ route('portal.receipt', $order->id) }}" class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm">
            <i class="fas fa-receipt"></i> Receipt
        </a>
    </div>
    @endif
</div>
@empty
<div class="text-center py-20 text-gray-400 bg-white rounded-xl shadow-sm">
    <i class="fas fa-ticket-alt text-5xl mb-4 block"></i>
    <p class="text-xl font-semibold">No tickets yet</p>
    <p class="mt-2">Register for an event to see your tickets here.</p>
    <a href="{{ route('home') }}" class="mt-4 inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">Browse Events</a>
</div>
@endforelse
@endsection
