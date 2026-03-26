<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Badge — {{ $attendee->first_name }} {{ $attendee->last_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>@media print { .no-print { display:none; } body { margin:0; } }</style>
</head>
<body class="bg-gray-100 p-8">
<div class="no-print mb-6 flex gap-3">
    <button onclick="window.print()" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700"><i class="fas fa-print mr-2"></i>Print Badge</button>
    <a href="{{ route('portal.tickets') }}" class="bg-white border text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-50">← Back</a>
</div>
<div class="bg-white rounded-2xl shadow-2xl overflow-hidden mx-auto flex flex-col" style="width:336px;min-height:480px">
    <div class="h-24 flex items-center justify-center" style="background: {{ $order->event->website_primary_color ?? '#6366f1' }}">
        <div class="text-center text-white">
            <p class="font-bold text-lg">{{ $order->event->name }}</p>
            <p class="text-sm opacity-80">{{ $order->event->start_date->format('M d') }} – {{ $order->event->end_date->format('d, Y') }}</p>
        </div>
    </div>
    <div class="flex-1 flex flex-col items-center justify-center p-6 text-center">
        <div class="w-24 h-24 rounded-full flex items-center justify-center text-white text-4xl font-black mb-4" style="background: {{ $order->event->website_primary_color ?? '#6366f1' }}">
            {{ strtoupper(substr($attendee->first_name,0,1).substr($attendee->last_name,0,1)) }}
        </div>
        <h2 class="text-3xl font-black text-gray-900 leading-tight">{{ $attendee->first_name }}</h2>
        <h2 class="text-3xl font-black text-gray-900">{{ $attendee->last_name }}</h2>
        <p class="text-gray-500 mt-2 text-base">{{ $attendee->job_title }}</p>
        <p class="text-gray-400 text-sm">{{ $attendee->organization }}</p>
        <div class="mt-4 px-4 py-1.5 rounded-full text-sm font-bold text-white" style="background: {{ $order->event->website_primary_color ?? '#6366f1' }}">{{ $order->ticket?->name }}</div>
        <div class="mt-4 text-xs text-gray-300 font-mono border border-gray-200 px-4 py-1 rounded">#{{ str_pad($attendee->id, 6, '0', STR_PAD_LEFT) }}</div>
    </div>
    <div class="h-12 flex items-center justify-center bg-gray-50 border-t border-gray-100">
        <p class="text-xs text-gray-400">{{ $order->event->venue }} · {{ $order->event->location }}</p>
    </div>
</div>
</body>
</html>
