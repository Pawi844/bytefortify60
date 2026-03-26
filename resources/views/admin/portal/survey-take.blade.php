@extends('layouts.portal')
@section('page-title', $survey->title)
@section('page-subtitle','Please complete this survey')
@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-8">
        @if($survey->description)<p class="text-gray-500 mb-6 pb-6 border-b">{{ $survey->description }}</p>@endif
        <form action="{{ route('portal.surveys.submit', $survey->id) }}" method="POST">
            @csrf
            @php $questions = json_decode($survey->questions, true) ?? [] @endphp
            @foreach($questions as $i => $q)
            <div class="mb-6">
                <label class="block font-semibold text-gray-800 mb-2">{{ $i+1 }}. {{ $q['q'] }}</label>
                @if(($q['type'] ?? 'text') === 'rating')
                <div class="flex gap-3">
                    @for($r=1;$r<=5;$r++)
                    <label class="flex flex-col items-center gap-1 cursor-pointer">
                        <input type="radio" name="q_{{ $i }}" value="{{ $r }}" class="w-4 h-4 text-indigo-600">
                        <span class="text-sm">{{ $r }}</span>
                    </label>
                    @endfor
                    <span class="text-gray-400 text-sm ml-2 self-end">(1=Poor, 5=Excellent)</span>
                </div>
                @elseif(($q['type'] ?? 'text') === 'radio')
                <div class="space-y-2">
                    @foreach($q['options'] ?? [] as $opt)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="q_{{ $i }}" value="{{ $opt }}" class="w-4 h-4 text-indigo-600">
                        <span>{{ $opt }}</span>
                    </label>
                    @endforeach
                </div>
                @else
                <textarea name="q_{{ $i }}" rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Your answer..."></textarea>
                @endif
            </div>
            @endforeach
            @if(empty($questions))
            <p class="text-gray-400 text-center py-4">No questions configured for this survey.</p>
            @endif
            <div class="flex gap-3 justify-end mt-6">
                <a href="{{ route('portal.surveys') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Back</a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold">
                    <i class="fas fa-paper-plane mr-2"></i>Submit Survey
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
