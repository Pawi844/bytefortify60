@extends('layouts.admin')
@section('page-title','Speakers')
@section('page-subtitle', $event->name)
@section('header-actions')
<a href="{{ route('admin.speakers.create', $event->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 flex items-center gap-2">
    <i class="fas fa-plus"></i> Add Speaker
</a>
@endsection
@section('content')
<div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    @forelse($speakers as $speaker)
    <div class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition text-center">
        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-2xl font-black mx-auto mb-3">
            {{ strtoupper(substr($speaker->first_name,0,1)) }}
        </div>
        @if($speaker->is_featured)<span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full"><i class="fas fa-star mr-1"></i>Featured</span>@endif
        <h3 class="font-bold mt-2">{{ $speaker->first_name }} {{ $speaker->last_name }}</h3>
        <p class="text-gray-500 text-sm">{{ $speaker->job_title }}</p>
        <p class="text-gray-400 text-xs">{{ $speaker->organization }}</p>
        @if($speaker->bio)<p class="text-gray-400 text-xs mt-2">{{ Str::limit($speaker->bio, 80) }}</p>@endif
        <div class="flex justify-center gap-2 mt-3">
            @if($speaker->social_twitter)<a href="{{ $speaker->social_twitter }}" target="_blank" class="text-blue-400 hover:text-blue-600"><i class="fab fa-twitter"></i></a>@endif
            @if($speaker->social_linkedin)<a href="{{ $speaker->social_linkedin }}" target="_blank" class="text-blue-700 hover:text-blue-900"><i class="fab fa-linkedin"></i></a>@endif
        </div>
        <div class="flex gap-2 mt-4">
            <a href="{{ route('admin.speakers.edit', [$event->id, $speaker->id]) }}" class="flex-1 bg-indigo-50 text-indigo-700 py-1.5 rounded-lg text-sm hover:bg-indigo-100"><i class="fas fa-edit mr-1"></i>Edit</a>
            <form action="{{ route('admin.speakers.destroy', [$event->id, $speaker->id]) }}" method="POST" class="flex-1">
                @csrf @method('DELETE')
                <button onclick="return confirm('Remove speaker?')" class="w-full bg-red-50 text-red-600 py-1.5 rounded-lg text-sm hover:bg-red-100"><i class="fas fa-trash"></i></button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-4 text-center py-16 text-gray-400">
        <i class="fas fa-microphone text-5xl mb-3 block"></i>
        <p class="text-lg font-semibold">No speakers yet</p>
        <a href="{{ route('admin.speakers.create', $event->id) }}" class="mt-3 inline-block bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">Add First Speaker</a>
    </div>
    @endforelse
</div>
@endsection