<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Badges — {{ $event->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print { .no-print { display:none; } }
        .badge-page { page-break-after: always; }
    </style>
</head>
<body class="bg-gray-100 p-6">
<div class="no-print mb-6 flex gap-3 items-center">
    <button onclick="window.print()" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700"><i class="fas fa-print mr-2"></i>Print All {{ $attendees->count() }} Badges</button>
    <a href="{{ route('admin.badges.index', $event->id) }}" class="bg-white border text-gray-700 px-6 py-2 rounded-lg">← Back</a>
    <p class="text-gray-500 text-sm">{{ $attendees->count() }} badges ready to print</p>
</div>
<div class="grid grid-cols-2 md:grid-cols-3 gap-4">
@foreach($attendees as $attendee)
<div class="bg-white rounded-2xl shadow overflow-hidden">
    <div class="h-14 flex items-center justify-center" style="background: {{ $event->website_primary_color ?? '#6366f1' }}">
        <p class="text-white font-bold text-xs text-center px-2">{{ $event->name }}</p>
    </div>
    <div class="p-4 text-center">
        <div class="w-14 h-14 rounded-full flex items-center justify-center text-white text-xl font-black mx-auto mb-2" style="background: {{ $event->website_primary_color ?? '#6366f1' }}">{{ strtoupper(substr($attendee->first_name,0,1).substr($attendee->last_name,0,1)) }}</div>
        <p class="text-xl font-black leading-tight">{{ $attendee->first_name }}</p>
        <p class="text-xl font-black">{{ $attendee->last_name }}</p>
        <p class="text-gray-500 text-xs mt-1">{{ $attendee->job_title }}</p>
        <p class="text-gray-400 text-xs">{{ $attendee->organization }}</p>
        @php $ticket = $attendee->orders->first()?->ticket @endphp
        @if($ticket)<div class="mt-2 px-2 py-0.5 rounded-full text-xs text-white font-bold inline-block" style="background: {{ $event->website_primary_color ?? '#6366f1' }}">{{ $ticket->name }}</div>@endif
        <p class="text-xs text-gray-300 font-mono mt-2">#{{ str_pad($attendee->id,6,'0',STR_PAD_LEFT) }}</p>
    </div>
</div>
@endforeach
</div>
</body>
</html>
