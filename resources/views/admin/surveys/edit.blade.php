@extends('layouts.admin')
@section('page-title','Edit Survey')
@section('page-subtitle', $event->name)
@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl shadow-sm p-8">
<form action="{{ route('admin.surveys.update', [$event->id, $survey->id]) }}" method="POST">
@csrf @method('PUT')
<div class="space-y-4">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Survey Title *</label>
        <input type="text" name="title" value="{{ old('title', $survey->title) }}" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
        <textarea name="description" rows="2" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">{{ old('description', $survey->description) }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Questions (JSON) *</label>
        <textarea name="questions" rows="8" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none font-mono text-sm">{{ old('questions', $survey->questions) }}</textarea>
    </div>
    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Opens At</label>
            <input type="datetime-local" name="starts_at" value="{{ old('starts_at', $survey->starts_at?->format('Y-m-d\TH:i')) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Closes At</label>
            <input type="datetime-local" name="ends_at" value="{{ old('ends_at', $survey->ends_at?->format('Y-m-d\TH:i')) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
        </div>
    </div>
    <div class="flex items-center gap-2">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" id="is_active" {{ $survey->is_active?'checked':'' }} class="w-4 h-4 text-indigo-600">
        <label for="is_active" class="text-sm font-medium text-gray-700">Active</label>
    </div>
</div>
<div class="flex gap-3 mt-6 justify-end">
    <a href="{{ route('admin.surveys.index', $event->id) }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</a>
    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium">Save Changes</button>
</div>
</form>
</div>
</div>
@endsection
