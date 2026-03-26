@extends('layouts.admin')
@section('page-title','Edit Attendee')
@section('page-subtitle', $attendee->email)
@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl shadow-sm p-8">
<form action="{{ route('admin.attendees.update', [$event->id, $attendee->id]) }}" method="POST">
@csrf @method('PUT')
<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">First Name *</label>
        <input type="text" name="first_name" value="{{ old('first_name', $attendee->first_name) }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Last Name *</label>
        <input type="text" name="last_name" value="{{ old('last_name', $attendee->last_name) }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Email *</label>
        <input type="email" name="email" value="{{ old('email', $attendee->email) }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $attendee->phone) }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Organization</label>
        <input type="text" name="organization" value="{{ old('organization', $attendee->organization) }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Job Title</label>
        <input type="text" name="job_title" value="{{ old('job_title', $attendee->job_title) }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Dietary Requirements</label>
        <input type="text" name="dietary" value="{{ old('dietary', $attendee->dietary) }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Notes</label>
        <textarea name="notes" rows="3" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">{{ old('notes', $attendee->notes) }}</textarea>
    </div>
</div>
<div class="flex gap-3 mt-6 justify-end">
    <a href="{{ route('admin.attendees.show', [$event->id, $attendee->id]) }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</a>
    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Save Changes</button>
</div>
</form>
</div>
</div>
@endsection
