@extends('layouts.admin')
@section('page-title','Edit Event')
@section('page-subtitle', $event->name)
@section('content')
<div class="max-w-3xl">
<div class="bg-white rounded-xl shadow-sm p-8">
<form action="{{ route('admin.events.update', $event->id) }}" method="POST">
@csrf @method('PUT')
<div class="grid md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Event Name *</label>
        <input type="text" name="name" value="{{ old('name', $event->name) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
        <textarea name="description" rows="4" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $event->description) }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Start Date *</label>
        <input type="datetime-local" name="start_date" value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">End Date *</label>
        <input type="datetime-local" name="end_date" value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Venue</label>
        <input type="text" name="venue" value="{{ old('venue', $event->venue) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Location</label>
        <input type="text" name="location" value="{{ old('location', $event->location) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
        <select name="category" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
            @foreach(['Technology','Marketing','Healthcare','Finance','Education','Nonprofit','Entertainment','Sports','Other'] as $cat)
            <option value="{{ $cat }}" {{ old('category',$event->category)==$cat?'selected':'' }}>{{ $cat }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Capacity</label>
        <input type="number" name="capacity" value="{{ old('capacity', $event->capacity) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
</div>
<div class="flex gap-3 mt-8 justify-end">
    <a href="{{ route('admin.events.show', $event->id) }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium">Cancel</a>
    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium">Save Changes</button>
</div>
</form>
</div>
</div>
@endsection
