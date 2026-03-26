@extends('layouts.portal')
@section('page-title','Surveys')
@section('page-subtitle','Share your feedback')
@section('content')
<div class="grid md:grid-cols-2 gap-4">
@forelse($surveys as $survey)
<div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
    <div class="flex justify-between items-start mb-3">
        <h3 class="font-bold text-lg">{{ $survey->title }}</h3>
        @if(in_array($survey->id, $responded))
        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold"><i class="fas fa-check mr-1"></i>Completed</span>
        @else
        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold">Pending</span>
        @endif
    </div>
    @if($survey->description)<p class="text-gray-400 text-sm mb-4">{{ $survey->description }}</p>@endif
    @if($survey->ends_at)<p class="text-gray-400 text-xs mb-4"><i class="far fa-clock mr-1"></i>Closes {{ $survey->ends_at->format('M d, Y') }}</p>@endif
    @if(!in_array($survey->id, $responded))
    <a href="{{ route('portal.surveys.take', $survey->id) }}" class="block w-full text-center bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition text-sm font-semibold">
        Take Survey →
    </a>
    @else
    <p class="text-center text-green-600 text-sm"><i class="fas fa-check-circle mr-1"></i>Thank you for your response!</p>
    @endif
</div>
@empty
<div class="col-span-2 text-center py-20 text-gray-400 bg-white rounded-xl shadow-sm">
    <i class="fas fa-poll text-5xl mb-4 block"></i>
    <p class="text-xl font-semibold">No surveys available yet</p>
</div>
@endforelse
</div>
@endsection
