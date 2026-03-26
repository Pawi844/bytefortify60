@extends('layouts.app')
@section('title', $event->name)
@section('content')

<section class="relative text-white py-24" style="background: linear-gradient(135deg, {{ $event->website_primary_color ?? '#6366f1' }} 0%, #1e1b4b 100%)">
    <div class="max-w-5xl mx-auto px-4 text-center">
        @if($event->category)<span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full mb-4 inline-block">{{ $event->category }}</span>@endif
        <h1 class="text-5xl font-extrabold mb-4">{{ $event->website_hero_title ?? $event->name }}</h1>
        <p class="text-xl text-white/80 mb-6 max-w-2xl mx-auto">{{ $event->website_hero_subtitle ?? $event->description }}</p>
        <div class="flex flex-wrap justify-center gap-6 text-sm mb-8 text-white/80">
            <span><i class="far fa-calendar mr-1"></i>{{ $event->start_date->format('D, M d') }} – {{ $event->end_date->format('M d, Y') }}</span>
            @if($event->venue)<span><i class="fas fa-map-marker-alt mr-1"></i>{{ $event->venue }}, {{ $event->location }}</span>@endif
            @if($event->is_virtual)<span><i class="fas fa-video mr-1"></i>Virtual Event</span>@endif
        </div>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('event.register', $event->slug) }}" class="bg-white text-indigo-700 font-bold px-8 py-3 rounded-xl hover:bg-yellow-300 transition shadow-lg text-lg">
                <i class="fas fa-ticket-alt mr-2"></i>Register Now
            </a>
            <a href="{{ route('event.schedule', $event->slug) }}" class="border-2 border-white text-white font-semibold px-6 py-3 rounded-xl hover:bg-white/10 transition">
                <i class="far fa-clock mr-2"></i>View Schedule
            </a>
        </div>
    </div>
</section>

<nav class="bg-white shadow-sm sticky top-16 z-40">
    <div class="max-w-5xl mx-auto px-4 flex gap-1 overflow-x-auto">
        <a href="{{ route('event.show', $event->slug) }}" class="py-4 px-4 text-sm font-medium text-indigo-600 border-b-2 border-indigo-600 whitespace-nowrap">About</a>
        <a href="{{ route('event.schedule', $event->slug) }}" class="py-4 px-4 text-sm font-medium text-gray-500 hover:text-indigo-600 border-b-2 border-transparent hover:border-indigo-600 whitespace-nowrap transition">Schedule</a>
        <a href="{{ route('event.speakers', $event->slug) }}" class="py-4 px-4 text-sm font-medium text-gray-500 hover:text-indigo-600 border-b-2 border-transparent hover:border-indigo-600 whitespace-nowrap transition">Speakers</a>
        <a href="{{ route('event.sponsors', $event->slug) }}" class="py-4 px-4 text-sm font-medium text-gray-500 hover:text-indigo-600 border-b-2 border-transparent hover:border-indigo-600 whitespace-nowrap transition">Sponsors</a>
        <a href="{{ route('event.cfp', $event->slug) }}" class="py-4 px-4 text-sm font-medium text-gray-500 hover:text-indigo-600 border-b-2 border-transparent hover:border-indigo-600 whitespace-nowrap transition">Submit Paper</a>
        <a href="{{ route('event.register', $event->slug) }}" class="ml-auto py-3 px-4 my-1 text-sm font-bold bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition whitespace-nowrap">Register →</a>
    </div>
</nav>

<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="md:col-span-2">
                <h2 class="text-2xl font-bold mb-4">About This Event</h2>
                <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $event->website_about ?? $event->description }}</p>
            </div>
            <div class="bg-gray-50 rounded-2xl p-6 space-y-4 text-sm h-fit">
                <div class="flex gap-3 items-start"><div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center flex-shrink-0"><i class="fas fa-calendar text-indigo-600 text-xs"></i></div><div><p class="font-semibold">Date & Time</p><p class="text-gray-500">{{ $event->start_date->format('M d, Y g:ia') }}</p><p class="text-gray-500">to {{ $event->end_date->format('M d, Y g:ia') }}</p></div></div>
                @if($event->venue)<div class="flex gap-3 items-start"><div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0"><i class="fas fa-map-marker-alt text-green-600 text-xs"></i></div><div><p class="font-semibold">Venue</p><p class="text-gray-500">{{ $event->venue }}</p><p class="text-gray-500">{{ $event->location }}</p></div></div>@endif
                @if($event->capacity)<div class="flex gap-3 items-start"><div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center flex-shrink-0"><i class="fas fa-users text-orange-600 text-xs"></i></div><div><p class="font-semibold">Capacity</p><p class="text-gray-500">{{ number_format($event->capacity) }} attendees</p></div></div>@endif
                <a href="{{ route('event.register', $event->slug) }}" class="block w-full text-center bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition">Get Tickets</a>
            </div>
        </div>
    </div>
</section>

@if($tickets->count())
<section class="py-12 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Ticket Options</h2>
        <div class="grid md:grid-cols-3 gap-4">
            @foreach($tickets as $i => $ticket)
            <div class="bg-white rounded-xl shadow p-6 border-2 {{ $i===1 ? 'border-indigo-500' : 'border-gray-100' }} hover:shadow-lg transition">
                @if($i===1)<div class="text-indigo-600 text-xs font-bold uppercase tracking-wider mb-2">★ Most Popular</div>@endif
                <h3 class="font-bold text-lg mb-1">{{ $ticket->name }}</h3>
                @if($ticket->description)<p class="text-gray-400 text-sm mb-3">{{ $ticket->description }}</p>@endif
                <p class="text-3xl font-black mb-4 text-indigo-700">{{ $ticket->price > 0 ? '$'.number_format($ticket->price,2) : 'Free' }}</p>
                <a href="{{ route('event.register', $event->slug) }}?ticket={{ $ticket->id }}" class="block w-full text-center {{ $i===1?'bg-indigo-600':'bg-gray-800' }} text-white py-2 rounded-lg hover:opacity-90 transition text-sm font-semibold">Select</a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($event->website_show_speakers && $speakers->count())
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold">Featured Speakers</h2>
            <a href="{{ route('event.speakers', $event->slug) }}" class="text-indigo-600 text-sm hover:underline">View all →</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($speakers as $speaker)
            <div class="text-center">
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-3">{{ strtoupper(substr($speaker->first_name,0,1)) }}</div>
                <p class="font-bold text-sm">{{ $speaker->first_name }} {{ $speaker->last_name }}</p>
                <p class="text-gray-400 text-xs">{{ $speaker->job_title }}</p>
                <p class="text-gray-400 text-xs">{{ $speaker->organization }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($event->website_show_schedule && $schedule->count())
<section class="py-12 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Schedule Highlights</h2>
            <a href="{{ route('event.schedule', $event->slug) }}" class="text-indigo-600 text-sm hover:underline">Full schedule →</a>
        </div>
        <div class="space-y-3">
            @foreach($schedule as $session)
            <div class="bg-white rounded-xl p-4 flex gap-4 shadow-sm items-center">
                <div class="text-center min-w-16"><p class="text-indigo-600 font-bold text-sm">{{ $session->start_time->format('g:ia') }}</p><p class="text-gray-400 text-xs">{{ $session->start_time->format('M d') }}</p></div>
                <div class="flex-1"><p class="font-semibold">{{ $session->title }}</p>@if($session->speaker)<p class="text-gray-400 text-sm">{{ $session->speaker->full_name }}@if($session->room) · {{ $session->room }}@endif</p>@endif</div>
                <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded text-xs capitalize">{{ str_replace('_',' ',$session->session_type) }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($event->website_show_sponsors && $sponsors->count())
<section class="py-12 bg-white">
    <div class="max-w-5xl mx-auto px-4 text-center">
        <h2 class="text-2xl font-bold mb-8">Our Sponsors</h2>
        <div class="flex flex-wrap justify-center gap-4">
            @foreach($sponsors as $s)
            <div class="bg-gray-50 rounded-xl px-6 py-4 flex items-center gap-3">
                <span class="text-xs font-bold uppercase tracking-wider px-2 py-0.5 rounded {{ ['platinum'=>'bg-slate-200 text-slate-700','gold'=>'bg-yellow-100 text-yellow-700','silver'=>'bg-gray-200 text-gray-600','bronze'=>'bg-orange-100 text-orange-700','partner'=>'bg-blue-100 text-blue-700'][$s->tier] ?? 'bg-gray-100 text-gray-600' }}">{{ ucfirst($s->tier) }}</span>
                <span class="font-semibold">{{ $s->name }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="py-16 text-white text-center" style="background: {{ $event->website_primary_color ?? '#6366f1' }}">
    <h2 class="text-3xl font-bold mb-4">Ready to Join Us?</h2>
    <p class="text-white/80 mb-6">Secure your spot before tickets sell out.</p>
    <a href="{{ route('event.register', $event->slug) }}" class="bg-white text-indigo-700 font-bold px-10 py-3 rounded-xl hover:bg-yellow-300 transition shadow text-lg inline-block">Register Now →</a>
</section>
@endsection