@extends('layouts.portal')
@section('page-title','My Papers')
@section('page-subtitle','Track your CFP submissions')
@section('content')
@forelse($papers as $paper)
<div class="bg-white rounded-xl shadow-sm p-6 mb-4 hover:shadow-md transition">
    <div class="flex justify-between items-start">
        <div class="flex-1">
            <h3 class="font-bold text-xl mb-1">{{ $paper->title }}</h3>
            @if($paper->keywords)<p class="text-gray-400 text-sm mb-2"><i class="fas fa-tag mr-1"></i>{{ $paper->keywords }}</p>@endif
            <p class="text-gray-500 text-sm line-clamp-2">{{ $paper->abstract }}</p>
        </div>
        <div class="ml-4 flex-shrink-0 text-right">
            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $paper->status_badge }}">{{ ucfirst(str_replace('_',' ',$paper->status)) }}</span>
            <p class="text-gray-400 text-xs mt-1">{{ $paper->created_at->format('M d, Y') }}</p>
        </div>
    </div>
    @if($paper->decision_comment)
    <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
        <p class="text-sm font-semibold text-yellow-800 mb-1"><i class="fas fa-comment mr-1"></i>Decision Comment:</p>
        <p class="text-yellow-700 text-sm">{{ $paper->decision_comment }}</p>
    </div>
    @endif
    @if($paper->reviews->count())
    <div class="mt-4">
        <p class="font-semibold text-sm mb-2">Review Feedback ({{ $paper->reviews->count() }} review(s)):</p>
        @foreach($paper->reviews as $review)
        <div class="bg-gray-50 rounded-lg p-4 mb-2">
            <div class="flex justify-between mb-2">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">Reviewer Feedback</span>
                <span class="text-sm font-bold text-indigo-600">Score: {{ $review->score }}/10</span>
            </div>
            <p class="text-gray-600 text-sm">{{ $review->comments }}</p>
            <p class="text-xs text-gray-400 mt-2 capitalize">Recommendation: {{ str_replace('_',' ',$review->recommendation) }}</p>
        </div>
        @endforeach
    </div>
    @endif
</div>
@empty
<div class="text-center py-20 text-gray-400 bg-white rounded-xl shadow-sm">
    <i class="fas fa-file-alt text-5xl mb-4 block"></i>
    <p class="text-xl font-semibold">No papers submitted yet</p>
    <p class="mt-2">Submit a paper through the event CFP page.</p>
</div>
@endforelse
@endsection
