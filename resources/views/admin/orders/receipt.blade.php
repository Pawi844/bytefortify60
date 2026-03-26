<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt #{{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>@media print { .no-print { display:none; } }</style>
</head>
<body class="bg-gray-100 p-8">
<div class="no-print mb-6 flex gap-3">
    <button onclick="window.print()" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700"><i class="fas fa-print mr-2"></i>Print Receipt</button>
    <a href="{{ route('admin.orders.show', [$event->id, $order->id]) }}" class="bg-white border px-6 py-2 rounded-lg hover:bg-gray-50">← Back</a>
</div>
<div class="max-w-sm mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6 text-center text-white">
        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-check text-3xl"></i>
        </div>
        <h1 class="text-2xl font-black">Payment Receipt</h1>
        <p class="text-green-100 text-sm">{{ $order->paid_at?->format('F d, Y') ?? $order->created_at->format('F d, Y') }}</p>
    </div>
    <div class="p-6">
        <div class="text-center mb-6">
            <p class="text-gray-400 text-sm">Amount Paid</p>
            <p class="text-4xl font-black text-gray-800">${{ number_format($order->total_amount, 2) }}</p>
            <span class="px-3 py-0.5 bg-green-100 text-green-700 text-xs rounded-full font-semibold">{{ strtoupper($order->status) }}</span>
        </div>
        <div class="space-y-3 text-sm border-t border-dashed border-gray-200 pt-4">
            <div class="flex justify-between"><span class="text-gray-500">Order #</span><span class="font-mono font-bold">{{ $order->order_number }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Attendee</span><span class="font-medium">{{ $order->attendee?->first_name }} {{ $order->attendee?->last_name }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Email</span><span>{{ $order->attendee?->email }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Ticket</span><span class="font-medium">{{ $order->ticket?->name }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Event</span><span class="font-medium text-right max-w-[180px]">{{ $order->event?->name }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Event Date</span><span>{{ $order->event?->start_date->format('M d, Y') }}</span></div>
        </div>
        <div class="mt-6 pt-4 border-t border-dashed border-gray-200 text-center">
            <p class="text-gray-400 text-xs">This receipt confirms your payment.</p>
            <p class="text-gray-400 text-xs">Keep this for your records.</p>
            <p class="text-gray-300 text-xs mt-2">EventPro · hello@eventpro.com</p>
        </div>
    </div>
</div>
</body>
</html>