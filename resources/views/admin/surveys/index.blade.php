@extends('layouts.admin')
@section('page-title','Surveys')
@section('page-subtitle', $event->name)
@section('header-actions')
<a href="{{ route('admin.surveys.create', $event->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 flex items-center gap-2"><i class="fas fa-plus"></i> Create Survey</a>
@endsection
@section('content')
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($surveys as $survey)
    <div class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition">
        <div class="flex justify-between items-start mb-2">
            <h3 class="font-bold text-gray-800">{{ $survey->title }}</h3>
            <span class="text-xs px-2 py-0.5 rounded-full {{ $survey->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $survey->is_active ? 'Active' : 'Inactive' }}</span>
        </div>
        @if($survey->description)<p class="text-gray-400 text-sm mb-3">{{ Str::limit($survey->description, 80) }}</p>@endif
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
            <i class="fas fa-users text-indigo-400"></i>
            <span>{{ $survey->responses_count }} responses</span>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.surveys.show', [$event->id, $survey->id]) }}" class="flex-1 text-center bg-indigo-50 text-indigo-700 py-1.5 rounded-lg text-sm hover:bg-indigo-100">Results</a>
            <a href="{{ route('admin.surveys.edit', [$event->id, $survey->id]) }}" class="px-3 py-1.5 bg-gray-50 text-gray-600 rounded-lg text-sm hover:bg-gray-100"><i class="fas fa-edit"></i></a>
            <form action="{{ route('admin.surveys.destroy', [$event->id, $survey->id]) }}" method="POST">
                @csrf @method('DELETE')
                <button onclick="return confirm('Delete survey?')" class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-sm hover:bg-red-100"><i class="fas fa-trash"></i></button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-16 text-gray-400">
        <i class="fas fa-poll text-5xl mb-3 block"></i>
        <p class="text-lg font-semibold">No surveys yet</p>
        <a href="{{ route('admin.surveys.create', $event->id) }}" class="mt-3 inline-block bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">Create First Survey</a>
    </div>
    @endforelse
</div>
@endsection