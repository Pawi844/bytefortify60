@extends('layouts.admin')
@section('page-title','Add Session')
@section('page-subtitle', $event->name)
@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl shadow-sm p-8">
<form action="{{ route('admin.schedule.store', $event->id) }}" method="POST">
@csrf
<div class="grid md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Session Title *</label>
        <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
        <textarea name="description" rows="3" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Start Time *</label>
        <input type="datetime-local" name="start_time" value="{{ old('start_time') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">End Time *</label>
        <input type="datetime-local" name="end_time" value="{{ old('end_time') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Session Type *</label>
        <select name="session_type" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
            @foreach(['keynote','talk','workshop','panel','break','networking'] as $type)
            <option value="{{ $type }}" {{ old('session_type') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Speaker</label>
        <select name="speaker_id" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">No speaker</option>
            @foreach($speakers as $speaker)
            <option value="{{ $speaker->id }}" {{ old('speaker_id') == $speaker->id ? 'selected' : '' }}>{{ $speaker->first_name }} {{ $speaker->last_name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Room</label>
        <input type="text" name="room" value="{{ old('room') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" placeholder="e.g. Main Hall, Room A">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Track</label>
        <input type="text" name="track" value="{{ old('track') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" placeholder="e.g. Cloud, AI, Keynote">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Capacity</label>
        <input type="number" name="capacity" value="{{ old('capacity') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Leave blank for unlimited">
    </div>
    <div class="md:col-span-2 flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
        <input type="hidden" name="is_public" value="0">
        <input type="checkbox" name="is_public" value="1" id="is_public" checked class="w-4 h-4 text-indigo-600">
        <label for="is_public" class="text-sm font-medium text-gray-700">Show on public event schedule</label>
    </div>
</div>
<div class="flex gap-3 mt-6 justify-end">
    <a href="{{ route('admin.schedule.index', $event->id) }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</a>
    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Add Session</button>
</div>
</form>
</div>
</div>
@endsection