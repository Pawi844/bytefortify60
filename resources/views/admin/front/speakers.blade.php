@extends('layouts.app')
@section('title', 'Speakers — '.$event->name)
@section('content')
<div class="py-12" style="background: linear-gradient(135deg, {{ $event->website_primary_color ?? '#6366f1' }} 0%, #1e1b4b 100%)">
    <div class="max-w-5xl mx-auto px-4 text-center text-white">
        <a href="{{ route('event.show', $event->slug) }}" class="text-white/70 text-sm hover:text-white"><i class="fas fa-arrow-left mr-1"></i>{{ $event->name }}</a>
        <h1 class="text-4xl font-extrabold mt-2">Our Speakers</h1>
    </div>
</div>
<section class="py-16 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4">
        @if($speakers->count())
        <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($speakers as $speaker)
            <div class="bg-white rounded-2xl shadow-sm p-6 text-center hover:shadow-md transition">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4">{{ strtoupper(substr($speaker->first_name,0,1)) }}</div>
                <h3 class="font-bold text-lg">{{ $speaker->first_name }} {{ $speaker->last_name }}</h3>
                <p class="text-gray-500 text-sm">{{ $speaker->job_title }}</p>
                <p class="text-gray-400 text-sm">{{ $speaker->organization }}</p>
                @if($speaker->bio)<p class="text-gray-500 text-xs mt-3 line-clamp-3">{{ $speaker->bio }}</p>@endif
                <div class="flex justify-center gap-3 mt-4">
                    @if($speaker->social_linkedin)<a href="{{ $speaker->social_linkedin }}" target="_blank" class="text-blue-600 hover:text-blue-800"><i class="fab fa-linkedin"></i></a>@endif
                    @if($speaker->social_twitter)<a href="{{ $speaker->social_twitter }}" target="_blank" class="text-sky-500 hover:text-sky-700"><i class="fab fa-twitter"></i></a>@endif
                    @if($speaker->social_website)<a href="{{ $speaker->social_website }}" target="_blank" class="text-gray-500 hover:text-gray-700"><i class="fas fa-globe"></i></a>@endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-20 text-gray-400"><i class="fas fa-microphone text-5xl mb-4 block"></i><p class="text-xl">Speakers to be announced soon.</p></div>
        @endif
    </div>
</section>
@endsection
