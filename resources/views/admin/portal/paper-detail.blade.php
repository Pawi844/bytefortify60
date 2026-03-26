@extends('layouts.portal')
@section('page-title', Str::limit($paper->title,50))
@section('page-subtitle','Paper submission detail')
@section('content')
<div class="max-w-3xl">
    <a href="{{ route('portal.papers') }}" class="text-indigo-600 text-sm hover:underline mb-4 inline-block"><i class="fas fa-arrow-left mr-1"></i>Back to My Papers</a>
    <div class="bg-white rounded-xl shadow-sm p-8">
        <div class="flex justify-between items-start mb-6">
            <h1 class="text-2xl font-bold flex-1">{{ $paper->title }}</h1>
            <span class="ml-4 px-3 py-1 rounded-full text-sm font-semibold {{ $paper->status_badge }}">{{ ucfirst(str_replace('_',' ',$paper->status)) }}</span>
        </div>
        @if($paper->keywords)<p class="text-gray-400 mb-4"><i class="fas fa-tag mr-1"></i>{{ $paper->keywords }}</p>@endif
        <h3 class="font-bold text-gray-700 mb-2">Abstract</h3>
        <p class="text-gray-600 leading-relaxed mb-6 whitespace-pre-line">{{ $paper->abstract }}</p>
        @if($paper->decision_comment)
        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl mb-6">
            <p class="font-bold text-yellow-800 mb-2"><i class="fas fa-gavel mr-1"></i>Editorial Decision</p>
            <p class="text-yellow-700">{{ $paper->decision_comment }}</p>
            @if($paper->decided_at)<p class="text-yellow-500 text-xs mt-2">{{ $paper->decided_at->format('M d, Y g:ia') }}</p>@endif
        </div>
        @endif
        @if($paper->reviews->count())
        <h3 class="font-bold text-gray-700 mb-3">Peer Reviews</h3>
        @foreach($paper->reviews as $review)
        <div class="bg-gray-50 rounded-xl p-5 mb-3 border border-gray-100">
            <div class="flex justify-between mb-3">
                <span class="font-semibold">Anonymous Reviewer</span>
                <div class="flex items-center gap-2">
                    <div class="flex gap-0.5">
                        @for($i=1;$i<=10;$i++)<div class="w-3 h-3 rounded-sm {{ $i<=$review->score?'bg-indigo-500':'bg-gray-200' }}"></div>@endfor
                    </div>
                    <span class="text-sm font-bold text-indigo-600">{{ $review->score }}/10</span>
                </div>
            </div>
            <p class="text-gray-600 text-sm">{{ $review->comments }}</p>
            <p class="text-xs text-gray-400 mt-3 capitalize bg-white inline-block px-2 py-0.5 rounded">Recommendation: {{ str_replace('_',' ',$review->recommendation) }}</p>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection
