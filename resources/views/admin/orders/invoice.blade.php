<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>@media print { .no-print { display:none; } }</style>
</head>
<body class="bg-gray-100 p-8">
<div class="no-print mb-6 flex gap-3">
    <button onclick="window.print()" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700"><i class="fas fa-print mr-2"></i>Print Invoice</button>
    <a href="{{ route('admin.orders.show', [$event->id, $order->id]) }}" class="bg-white border px-6 py-2 rounded-lg hover:bg-gray-50">← Back to Order</a>
</div>
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-10">
    <div class="flex justify-between items-start mb-10">
        <div>
            <h1 class="text-4xl font-black text-indigo-700">INVOICE</h1>
            <p class="text-gray-400 text-sm mt-1">#{{ $order->order_number }}</p>
            <p class="text-gray-400 text-sm">Issued: {{ $order->created_at->format('F d, Y') }}</p>
        </div>
        <div class="text-right">
            <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center mb-2 ml-auto">
                <span class="text-white font-bold text-sm">EP</span>
            </div>
            <p class="font-bold text-lg">EventPro</p>
            <p class="text-gray-400 text-sm">hello@eventpro.com</p>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-8 mb-10">
        <div>
            <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Bill To</p>
            <p class="font-bold">{{ $order->attendee?->first_name }} {{ $order->attendee?->last_name }}</p>
            <p class="text-gray-600 text-sm">{{ $order->attendee?->email }}</p>
            @if($order->attendee?->organization)<p class="text-gray-600 text-sm">{{ $order->attendee->organization }}</p>@endif
            @if($order->attendee?->phone)<p class="text-gray-600 text-sm">{{ $order->attendee->phone }}</p>@endif
        </div>
        <div>
            <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Event</p>
            <p class="font-bold">{{ $event->name }}</p>
            <p class="text-gray-600 text-sm">{{ $event->start_date->format('M d') }} – {{ $event->end_date->format('M d, Y') }}</p>
            <p class="text-gray-600 text-sm">{{ $event->venue }}</p>
            <p class="text-gray-600 text-sm">{{ $event->location }}</p>
        </div>
    </div>
    <table class="w-full mb-8">
        <thead>
            <tr class="border-b-2 border-gray-200">
                <th class="text-left pb-2 text-xs uppercase text-gray-500 font-semibold">Description</th>
                <th class="text-right pb-2 text-xs uppercase text-gray-500 font-semibold">Qty</th>
                <th class="text-right pb-2 text-xs uppercase text-gray-500 font-semibold">Unit Price</th>
                <th class="text-right pb-2 text-xs uppercase text-gray-500 font-semibold">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b border-gray-100 py-3">
                <td class="py-4">
                    <p class="font-medium">{{ $order->ticket?->name }}</p>
                    <p class="text-gray-400 text-sm">Event Registration — {{ $event->name }}</p>
                </td>
                <td class="py-4 text-right">1</td>
                <td class="py-4 text-right">${{ number_format($order->total_amount, 2) }}</td>
                <td class="py-4 text-right font-bold">${{ number_format($order->total_amount, 2) }}</td>
            </tr>
        </tbody>
    </table>
    <div class="flex justify-end">
        <div class="w-56">
            <div class="flex justify-between py-1 text-sm"><span class="text-gray-500">Subtotal</span><span>${{ number_format($order->total_amount, 2) }}</span></div>
            <div class="flex justify-between py-1 text-sm"><span class="text-gray-500">Tax (0%)</span><span>$0.00</span></div>
            <div class="flex justify-between py-2 border-t-2 border-gray-800 mt-1 font-black text-lg"><span>Total</span><span>${{ number_format($order->total_amount, 2) }}</span></div>
        </div>
    </div>
    <div class="mt-10 pt-6 border-t border-gray-100 flex justify-between items-center">
        <div>
            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $order->status_badge }}">{{ ucfirst($order->status) }}</span>
            @if($order->paid_at)<p class="text-gray-400 text-xs mt-1">Payment received {{ $order->paid_at->format('M d, Y') }}</p>@endif
        </div>
        <p class="text-gray-400 text-xs">Thank you for your registration!</p>
    </div>
</div>
</body>
</html>