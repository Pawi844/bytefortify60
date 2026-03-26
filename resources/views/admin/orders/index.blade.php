@extends('layouts.admin')
@section('page-title','Orders')
@section('page-subtitle', $event->name)
@section('content')
<div class="grid md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5">
        <p class="text-gray-400 text-sm">Total Revenue</p>
        <p class="text-2xl font-bold text-green-600">${{ number_format($totalRevenue, 2) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5">
        <p class="text-gray-400 text-sm">Total Orders</p>
        <p class="text-2xl font-bold">{{ $orders->total() }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5">
        <p class="text-gray-400 text-sm">Pending Orders</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $pendingOrders }}</p>
    </div>
</div>
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Order #</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Attendee</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Ticket</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Amount</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
        @forelse($orders as $order)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3 text-sm font-mono text-gray-500">#{{ $order->order_number }}</td>
            <td class="px-4 py-3 text-sm font-medium">{{ $order->attendee?->first_name }} {{ $order->attendee?->last_name }}</td>
            <td class="px-4 py-3 text-sm text-gray-500">{{ $order->ticket?->name }}</td>
            <td class="px-4 py-3 text-sm font-bold">${{ number_format($order->total_amount, 2) }}</td>
            <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></td>
            <td class="px-4 py-3 text-sm text-gray-400">{{ $order->created_at->format('M d, Y') }}</td>
            <td class="px-4 py-3 text-right">
                <a href="{{ route('admin.orders.show', [$event->id, $order->id]) }}" class="text-indigo-600 text-sm mr-2 hover:underline">View</a>
                @if($order->status === 'pending')
                <form action="{{ route('admin.orders.approve', [$event->id, $order->id]) }}" method="POST" class="inline">
                    @csrf <button class="text-green-600 text-sm hover:underline">Approve</button>
                </form>
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center py-10 text-gray-400">No orders yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $orders->links() }}</div>
@endsection
