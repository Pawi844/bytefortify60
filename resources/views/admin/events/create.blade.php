@extends('layouts.admin')
@section('page-title','Create New Event')
@section('page-subtitle','Fill in the details for your new event')
@section('content')
<div class="max-w-3xl">
<div class="bg-white rounded-xl shadow-sm p-8">
<form action="{{ route('admin.events.store') }}" method="POST">
@csrf
<div class="grid md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Event Name *</label>
        <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="e.g. TechSummit 2025" required>
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Slug (URL)</label>
        <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="auto-generated if empty">
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
        <textarea name="description" rows="4" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">{{ old('description') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Start Date & Time *</label>
        <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">End Date & Time *</label>
        <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Venue</label>
        <input type="text" name="venue" value="{{ old('venue') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Convention Center">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Location / City</label>
        <input type="text" name="location" value="{{ old('location') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="San Francisco, CA">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
        <select name="category" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
            <option value="">Select category</option>
            @foreach(['Technology','Marketing','Healthcare','Finance','Education','Nonprofit','Entertainment','Sports','Other'] as $cat)
            <option value="{{ $cat }}" {{ old('category')==$cat?'selected':'' }}>{{ $cat }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Capacity</label>
        <input type="number" name="capacity" value="{{ old('capacity') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="500">
    </div>
    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg">
        <input type="hidden" name="is_virtual" value="0">
        <input type="checkbox" name="is_virtual" value="1" id="is_virtual" {{ old('is_virtual') ? 'checked' : '' }} class="w-4 h-4 text-indigo-600">
        <label for="is_virtual" class="font-medium text-gray-700 text-sm">This is a virtual event</label>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Virtual Link</label>
        <input type="url" name="virtual_link" value="{{ old('virtual_link') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="https://zoom.us/...">
    </div>
</div>
<div class="flex gap-3 mt-8 justify-end">
    <a href="{{ route('admin.events.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium">Cancel</a>
    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium"><i class="fas fa-plus mr-2"></i>Create Event</button>
</div>
</form>
</div>
</div>
@endsection
