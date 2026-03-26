@extends('layouts.app')
@section('title', 'Schedule — '.$event->name)
@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="py-12 px-4" style="background: linear-gradient(135deg, {{ $event->website_primary_color ?? '#6366f1' }} 0%, #1e1b4b 100%)">
        <div class="max-w-4xl mx-auto text-center text-white">
            <a href="{{ route('event.show', $event->slug) }}" class="text-white/70 text-sm hover:text-white"><i class="fas fa-arrow-left mr-1"></i>{{ $event->name }}</a>
            <h1 class="text-4xl font-extrabold mt-2">Event Schedule</h1>
            <p class="text-white/70 mt-2">{{ $event->start_date->format('M d') }} – {{ $event->end_date->format('M d, Y') }}</p>
        </div>
    </div>
    <div class="max-w-4xl mx-auto px-4 py-10">
        @forelse($schedule as $date => $sessions)
        <div class="mb-10">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-indigo-600 text-white rounded-xl px-4 py-2 font-bold">{{ \Carbon\Carbon::parse($date)->format('l, M d') }}</div>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>
            <div class="space-y-3">
                @foreach($sessions as $session)
                <div class="bg-white rounded-xl shadow-sm p-5 flex gap-5 items-start hover:shadow-md transition">
                    <div class="text-center min-w-20 flex-shrink-0">
                        <p class="text-indigo-600 font-bold text-sm">{{ $session->start_time->format('g:ia') }}</p>
                        <p class="text-gray-400 text-xs">{{ $session->end_time->format('g:ia') }}</p>
                        <p class="text-gray-400 text-xs mt-1">{{ $session->duration }}m</p>
                    </div>
                    <div class="flex-1">
                        <span class="px-2 py-0.5 text-xs rounded-full font-semibold mb-2 inline-block {{ $session->session_type==='keynote'?'bg-yellow-100 text-yellow-700':($session->session_type==='workshop'?'bg-green-100 text-green-700':($session->session_type==='break'?'bg-gray-100 text-gray-500':'bg-indigo-100 text-indigo-700')) }}">{{ ucfirst(str_replace('_',' ',$session->session_type)) }}</span>
                        <h3 class="font-bold text-gray-900 text-lg">{{ $session->title }}</h3>
                        @if($session->description)<p class="text-gray-500 text-sm mt-1">{{ $session->description }}</p>@endif
                        <div class="flex items-center gap-4 mt-3 text-sm text-gray-400">
                            @if($session->speaker)<span><i class="fas fa-user mr-1"></i>{{ $session->speaker->full_name }}</span>@endif
                            @if($session->room)<span><i class="fas fa-map-marker-alt mr-1"></i>{{ $session->room }}</span>@endif
                            @if($session->track)<span><i class="fas fa-tag mr-1"></i>{{ $session->track }}</span>@endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="text-center py-20 text-gray-400"><i class="fas fa-calendar-times text-5xl mb-4 block"></i><p class="text-xl font-semibold">Schedule coming soon</p></div>
        @endforelse
    </div>
</div>
@endsection
