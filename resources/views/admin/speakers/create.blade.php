@extends('layouts.admin')
@section('page-title','Add Speaker')
@section('page-subtitle', $event->name)
@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl shadow-sm p-8">
<form action="{{ route('admin.speakers.store', $event->id) }}" method="POST">
@csrf
<div class="grid md:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">First Name *</label>
        <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Last Name *</label>
        <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Job Title</label>
        <input type="text" name="job_title" value="{{ old('job_title') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Organization</label>
        <input type="text" name="organization" value="{{ old('organization') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Bio</label>
        <textarea name="bio" rows="4" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">{{ old('bio') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Twitter URL</label>
        <input type="url" name="social_twitter" value="{{ old('social_twitter') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" placeholder="https://twitter.com/...">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">LinkedIn URL</label>
        <input type="url" name="social_linkedin" value="{{ old('social_linkedin') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" placeholder="https://linkedin.com/in/...">
    </div>
    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
        <input type="hidden" name="is_featured" value="0">
        <input type="checkbox" name="is_featured" value="1" id="is_featured" class="w-4 h-4 text-indigo-600">
        <label for="is_featured" class="text-sm font-medium text-gray-700">Feature on event website</label>
    </div>
</div>
<div class="flex gap-3 mt-6 justify-end">
    <a href="{{ route('admin.speakers.index', $event->id) }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</a>
    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Add Speaker</button>
</div>
</form>
</div>
</div>
@endsection