@extends('layouts.portal')
@section('page-title','Event Schedule')
@section('page-subtitle','Browse and personalise your agenda')
@section('content')
@forelse($allSessions as $date => $sessions)
<div class="mb-8">
    <div class="flex items-center gap-4 mb-4">
        <div class="bg-indigo-600 text-white rounded-xl px-4 py-2 font-bold text-sm">{{ \Carbon\Carbon::parse($date)->format('l, M d') }}</div>
        <div class="flex-1 h-px bg-gray-200"></div>
    </div>
    <div class="space-y-3">
        @foreach($sessions as $session)
        <div class="bg-white rounded-xl shadow-sm p-5 flex gap-5 items-start {{ in_array($session->id, $mySessions) ? 'border-l-4 border-indigo-500' : '' }}">
            <div class="text-center min-w-16 flex-shrink-0">
                <p class="text-indigo-600 font-bold text-sm">{{ $session->start_time->format('g:ia') }}</p>
                <p class="text-gray-400 text-xs">{{ $session->end_time->format('g:ia') }}</p>
            </div>
            <div class="flex-1">
                <span class="px-2 py-0.5 text-xs rounded-full {{ $session->session_type==='keynote'?'bg-yellow-100 text-yellow-700':'bg-indigo-50 text-indigo-600' }} mb-1 inline-block">{{ ucfirst(str_replace('_',' ',$session->session_type)) }}</span>
                <h3 class="font-bold">{{ $session->title }}</h3>
                @if($session->description)<p class="text-gray-400 text-sm mt-1">{{ $session->description }}</p>@endif
                <div class="flex gap-4 mt-2 text-xs text-gray-400">
                    @if($session->speaker)<span><i class="fas fa-user mr-1"></i>{{ $session->speaker->full_name }}</span>@endif
                    @if($session->room)<span><i class="fas fa-map-marker-alt mr-1"></i>{{ $session->room }}</span>@endif
                    @if($session->track)<span><i class="fas fa-tag mr-1"></i>{{ $session->track }}</span>@endif
                </div>
            </div>
            @if($session->session_type !== 'break')
            <form action="{{ route('portal.schedule.toggle', $session->id) }}" method="POST" class="flex-shrink-0">
                @csrf
                @if(in_array($session->id, $mySessions))
                <button type="submit" class="px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-lg text-xs font-semibold hover:bg-red-100 hover:text-red-700 transition"><i class="fas fa-check mr-1"></i>Added</button>
                @else
                <button type="submit" class="px-3 py-1.5 bg-gray-100 text-gray-600 rounded-lg text-xs font-semibold hover:bg-indigo-100 hover:text-indigo-700 transition"><i class="fas fa-plus mr-1"></i>Add</button>
                @endif
            </form>
            @endif
        </div>
        @endforeach
    </div>
</div>
@empty
<div class="text-center py-20 text-gray-400 bg-white rounded-xl shadow-sm">
    <i class="fas fa-calendar-times text-5xl mb-4 block"></i>
    <p class="text-xl font-semibold">Schedule not available yet</p>
</div>
@endforelse
@endsection
