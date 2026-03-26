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
    <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700"><i class="fas fa-print mr-2"></i>Print Invoice</button>
    <a href="{{ route('portal.tickets') }}" class="bg-white border px-6 py-2 rounded-lg hover:bg-gray-50">← Back to Tickets</a>
</div>
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8">
    <div class="flex justify-between items-start mb-8">
        <div>
            <h1 class="text-4xl font-black text-indigo-700">INVOICE</h1>
            <p class="text-gray-400 text-sm mt-1">#{{ $order->order_number }}</p>
            <p class="text-gray-400 text-sm">Issued: {{ $order->created_at->format('M d, Y') }}</p>
        </div>
        <div class="text-right">
            <p class="font-bold text-lg">EventPro</p>
            <p class="text-gray-400 text-sm">hello@eventpro.com</p>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-6 mb-8 p-6 bg-gray-50 rounded-xl">
        <div>
            <p class="text-xs font-bold uppercase text-gray-400 mb-1">Bill To</p>
            <p class="font-bold">{{ $attendee->first_name }} {{ $attendee->last_name }}</p>
            <p class="text-gray-500 text-sm">{{ $attendee->email }}</p>
            @if($attendee->organization)<p class="text-gray-500 text-sm">{{ $attendee->organization }}</p>@endif
        </div>
        <div>
            <p class="text-xs font-bold uppercase text-gray-400 mb-1">Event</p>
            <p class="font-bold">{{ $order->event->name }}</p>
            <p class="text-gray-500 text-sm">{{ $order->event->start_date->format('M d, Y') }}</p>
            @if($order->event->venue)<p class="text-gray-500 text-sm">{{ $order->event->venue }}</p>@endif
        </div>
    </div>
    <table class="w-full mb-8">
        <thead><tr class="border-b-2 border-gray-200"><th class="text-left py-3 text-sm font-bold text-gray-600">Description</th><th class="text-right py-3 text-sm font-bold text-gray-600">Amount</th></tr></thead>
        <tbody>
            <tr class="border-b border-gray-100"><td class="py-4"><p class="font-medium">{{ $order->ticket?->name }}</p><p class="text-gray-400 text-sm">Event Registration Ticket</p></td><td class="py-4 text-right font-bold">${{ number_format($order->total_amount,2) }}</td></tr>
        </tbody>
        <tfoot>
            <tr><td class="pt-4 text-right font-bold text-gray-600" colspan="1">Total:</td><td class="pt-4 text-right text-2xl font-black text-indigo-700">${{ number_format($order->total_amount,2) }}</td></tr>
        </tfoot>
    </table>
    <div class="text-center border-t pt-6">
        <span class="px-4 py-1.5 rounded-full text-sm font-bold {{ $order->status_badge }}">{{ strtoupper($order->status) }}</span>
        @if($order->paid_at)<p class="text-gray-400 text-xs mt-2">Paid on {{ $order->paid_at->format('M d, Y') }}</p>@endif
    </div>
</div>
</body>
</html>
