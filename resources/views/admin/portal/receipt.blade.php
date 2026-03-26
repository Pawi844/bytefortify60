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
    <button onclick="window.print()" class="bg-green-600 text-white px-6 py-2 rounded-lg"><i class="fas fa-print mr-2"></i>Print Receipt</button>
    <a href="{{ route('portal.tickets') }}" class="bg-white border px-6 py-2 rounded-lg">← Back</a>
</div>
<div class="max-w-md mx-auto bg-white rounded-xl shadow-lg">
    <div class="p-6 text-center border-b" style="background: #6366f1">
        <i class="fas fa-check-circle text-white text-4xl mb-2"></i>
        <h1 class="text-2xl font-black text-white">Payment Receipt</h1>
        <p class="text-indigo-200 text-sm">Thank you for your purchase!</p>
    </div>
    <div class="p-6 space-y-3">
        <div class="flex justify-between text-sm"><span class="text-gray-500">Order #</span><span class="font-mono font-bold">{{ $order->order_number }}</span></div>
        <div class="flex justify-between text-sm"><span class="text-gray-500">Date</span><span>{{ $order->created_at->format('M d, Y g:ia') }}</span></div>
        <div class="flex justify-between text-sm"><span class="text-gray-500">Event</span><span class="font-medium text-right max-w-40">{{ $order->event->name }}</span></div>
        <div class="flex justify-between text-sm"><span class="text-gray-500">Ticket</span><span>{{ $order->ticket?->name }}</span></div>
        <div class="flex justify-between text-sm"><span class="text-gray-500">Attendee</span><span>{{ $attendee->first_name }} {{ $attendee->last_name }}</span></div>
        <hr class="my-3">
        <div class="flex justify-between font-black text-xl"><span>Total Paid</span><span class="text-green-600">${{ number_format($order->total_amount,2) }}</span></div>
        <div class="text-center pt-3">
            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold"><i class="fas fa-check mr-1"></i>CONFIRMED</span>
        </div>
    </div>
    <div class="p-4 bg-gray-50 text-center text-xs text-gray-400 rounded-b-xl">
        Questions? Contact us at hello@eventpro.com
    </div>
</div>
</body>
</html>
