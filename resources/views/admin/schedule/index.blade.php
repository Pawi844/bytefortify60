@extends('layouts.admin')
@section('page-title','Schedule')
@section('page-subtitle', $event->name)
@section('header-actions')
<a href="{{ route('admin.schedule.create', $event->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 flex items-center gap-2">
    <i class="fas fa-plus"></i> Add Session
</a>
@endsection
@section('content')
@forelse($schedule as $date => $sessions)
<div class="mb-6">
    <h3 class="text-lg font-bold text-gray-700 mb-3 flex items-center gap-2">
        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center"><i class="fas fa-calendar text-indigo-600 text-sm"></i></div>
        {{ \Carbon\Carbon::parse($date)->format('l, F d, Y') }}
    </h3>
    <div class="space-y-3">
        @foreach($sessions as $session)
        <div class="bg-white rounded-xl shadow-sm p-4 flex gap-4 hover:shadow-md transition border-l-4 {{ match($session->session_type) { 'keynote' => 'border-purple-500', 'workshop' => 'border-orange-500', 'break' => 'border-gray-300', 'networking' => 'border-green-500', default => 'border-indigo-400' } }}">
            <div class="text-center min-w-[80px]">
                <p class="font-bold text-sm text-indigo-700">{{ $session->start_time->format('g:ia') }}</p>
                <p class="text-gray-400 text-xs">{{ $session->end_time->format('g:ia') }}</p>
                <p class="text-gray-300 text-xs">{{ $session->duration }}min</p>
            </div>
            <div class="flex-1">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-bold text-gray-800">{{ $session->title }}</p>
                        @if($session->speaker)<p class="text-indigo-600 text-sm"><i class="fas fa-microphone text-xs mr-1"></i>{{ $session->speaker->first_name }} {{ $session->speaker->last_name }}</p>@endif
                        @if($session->description)<p class="text-gray-400 text-sm mt-1">{{ Str::limit($session->description, 100) }}</p>@endif
                        <div class="flex gap-2 mt-2 flex-wrap">
                            @if($session->room)<span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded"><i class="fas fa-door-open mr-1"></i>{{ $session->room }}</span>@endif
                            @if($session->track)<span class="text-xs bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded">{{ $session->track }}</span>@endif
                            <span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded">{{ ucfirst($session->session_type) }}</span>
                        </div>
                    </div>
                    <div class="flex gap-2 ml-4">
                        <a href="{{ route('admin.schedule.edit', [$event->id, $session->id]) }}" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.schedule.destroy', [$event->id, $session->id]) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete session?')" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@empty
<div class="text-center py-20 text-gray-400">
    <i class="fas fa-clock text-6xl mb-4 block"></i>
    <p class="text-xl font-semibold">No sessions scheduled yet</p>
    <a href="{{ route('admin.schedule.create', $event->id) }}" class="mt-4 inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">Add First Session</a>
</div>
@endforelse
@endsection