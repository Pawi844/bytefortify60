@extends('layouts.admin')
@section('page-title','Order #' . $order->order_number)
@section('page-subtitle', $event->name)
@section('header-actions')
<a href="{{ route('admin.orders.invoice', [$event->id, $order->id]) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700"><i class="fas fa-file-invoice mr-1"></i>Invoice</a>
<a href="{{ route('admin.orders.receipt', [$event->id, $order->id]) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700"><i class="fas fa-receipt mr-1"></i>Receipt</a>
@if($order->status === 'pending')
<form action="{{ route('admin.orders.approve', [$event->id, $order->id]) }}" method="POST" class="inline">
    @csrf <button class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-emerald-700"><i class="fas fa-check mr-1"></i>Approve</button>
</form>
@endif
@if($order->status === 'paid')
<form action="{{ route('admin.orders.refund', [$event->id, $order->id]) }}" method="POST" class="inline">
    @csrf <button onclick="return confirm('Refund this order?')" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700"><i class="fas fa-undo mr-1"></i>Refund</button>
</form>
@endif
@endsection
@section('content')
<div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Order Details</h3>
        <dl class="space-y-3">
            <div class="flex justify-between"><dt class="text-gray-500 text-sm">Order Number</dt><dd class="font-mono font-bold">#{{ $order->order_number }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500 text-sm">Status</dt><dd><span class="px-2 py-0.5 rounded-full text-xs {{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500 text-sm">Ticket</dt><dd class="font-medium">{{ $order->ticket?->name }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500 text-sm">Amount</dt><dd class="font-bold text-lg text-green-600">${{ number_format($order->total_amount, 2) }}</dd></div>
            <div class="flex justify-between"><dt class="text-gray-500 text-sm">Ordered On</dt><dd>{{ $order->created_at->format('M d, Y g:ia') }}</dd></div>
            @if($order->paid_at)<div class="flex justify-between"><dt class="text-gray-500 text-sm">Paid On</dt><dd class="text-green-600">{{ $order->paid_at->format('M d, Y g:ia') }}</dd></div>@endif
            @if($order->refunded_at)<div class="flex justify-between"><dt class="text-gray-500 text-sm">Refunded On</dt><dd class="text-red-600">{{ $order->refunded_at->format('M d, Y g:ia') }}</dd></div>@endif
        </dl>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Attendee Information</h3>
        @if($order->attendee)
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold">
                {{ strtoupper(substr($order->attendee->first_name,0,1)) }}
            </div>
            <div>
                <p class="font-bold">{{ $order->attendee->first_name }} {{ $order->attendee->last_name }}</p>
                <p class="text-gray-400 text-sm">{{ $order->attendee->email }}</p>
            </div>
        </div>
        <dl class="space-y-2 text-sm">
            @if($order->attendee->phone)<div class="flex gap-2"><i class="fas fa-phone text-gray-400 w-4 mt-0.5"></i><span>{{ $order->attendee->phone }}</span></div>@endif
            @if($order->attendee->organization)<div class="flex gap-2"><i class="fas fa-building text-gray-400 w-4 mt-0.5"></i><span>{{ $order->attendee->organization }}</span></div>@endif
            @if($order->attendee->job_title)<div class="flex gap-2"><i class="fas fa-briefcase text-gray-400 w-4 mt-0.5"></i><span>{{ $order->attendee->job_title }}</span></div>@endif
        </dl>
        <div class="mt-4 flex gap-2">
            <a href="{{ route('admin.attendees.show', [$event->id, $order->attendee->id]) }}" class="text-indigo-600 text-sm hover:underline"><i class="fas fa-user mr-1"></i>View Attendee</a>
            <a href="{{ route('admin.attendees.badge', [$event->id, $order->attendee->id]) }}" class="text-purple-600 text-sm hover:underline ml-3"><i class="fas fa-id-badge mr-1"></i>Print Badge</a>
        </div>
        @endif
    </div>
</div>
@endsection