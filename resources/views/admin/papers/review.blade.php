@extends('layouts.admin')
@section('page-title','Submit Review')
@section('page-subtitle', Str::limit($paper->title, 60))
@section('content')
<div class="max-w-2xl">
<div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 mb-6">
    <p class="text-sm font-semibold text-indigo-800 mb-1">{{ $paper->title }}</p>
    <p class="text-indigo-600 text-sm">{{ Str::limit($paper->abstract, 200) }}</p>
    <p class="text-xs text-indigo-400 mt-2">Author: {{ $paper->author?->first_name }} {{ $paper->author?->last_name }}</p>
</div>
<div class="bg-white rounded-xl shadow-sm p-8">
<form action="{{ route('admin.papers.reviews.store', [$event->id, $paper->id]) }}" method="POST">
@csrf
<div class="mb-6">
    <label class="block text-sm font-semibold text-gray-700 mb-2">Score (1-10) *</label>
    <div class="flex items-center gap-2">
        <input type="range" name="score" min="1" max="10" value="7" class="flex-1 accent-indigo-600" id="scoreRange" oninput="document.getElementById('scoreVal').textContent=this.value">
        <span id="scoreVal" class="text-2xl font-black text-indigo-700 w-8 text-center">7</span>
    </div>
    <div class="flex justify-between text-xs text-gray-400 mt-1"><span>1 - Poor</span><span>5 - Average</span><span>10 - Excellent</span></div>
</div>
<div class="mb-6">
    <label class="block text-sm font-semibold text-gray-700 mb-2">Recommendation *</label>
    <div class="grid grid-cols-2 gap-3">
        @foreach(['accept'=>['✅','Accept','text-green-700 bg-green-50 border-green-200'],'minor_revision'=>['🔄','Minor Revision','text-blue-700 bg-blue-50 border-blue-200'],'major_revision'=>['⚠️','Major Revision','text-orange-700 bg-orange-50 border-orange-200'],'reject'=>['❌','Reject','text-red-700 bg-red-50 border-red-200']] as $val => $data)
        <label class="flex items-center gap-2 border rounded-lg p-3 cursor-pointer hover:bg-gray-50 {{ $data[2] }}">
            <input type="radio" name="recommendation" value="{{ $val }}" class="text-indigo-600" required>
            <span>{{ $data[0] }} {{ $data[1] }}</span>
        </label>
        @endforeach
    </div>
</div>
<div class="mb-6">
    <label class="block text-sm font-semibold text-gray-700 mb-2">Review Comments * <span class="text-gray-400 font-normal">(will be shared with author)</span></label>
    <textarea name="comments" rows="6" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Provide constructive feedback on the paper's strengths, weaknesses, methodology, and suggestions for improvement..." required></textarea>
</div>
<div class="flex gap-3 justify-end">
    <a href="{{ route('admin.papers.show', [$event->id, $paper->id]) }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</a>
    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700"><i class="fas fa-paper-plane mr-2"></i>Submit Review</button>
</div>
</form>
</div>
</div>
@endsection