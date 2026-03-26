@extends('layouts.portal')
@section('page-title','My Profile')
@section('page-subtitle','Update your personal information')
@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-8">
        <div class="flex items-center gap-4 mb-6 pb-6 border-b">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-2xl font-bold">{{ strtoupper(substr($attendee->first_name,0,1)) }}</div>
            <div>
                <h2 class="text-xl font-bold">{{ $attendee->first_name }} {{ $attendee->last_name }}</h2>
                <p class="text-gray-400">{{ $attendee->email }}</p>
            </div>
        </div>
        <form action="{{ route('portal.profile.update') }}" method="POST">
            @csrf @method('PUT')
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">First Name *</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $attendee->first_name) }}" required class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Last Name *</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $attendee->last_name) }}" required class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $attendee->phone) }}" class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Organization</label>
                    <input type="text" name="organization" value="{{ old('organization', $attendee->organization) }}" class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Job Title</label>
                    <input type="text" name="job_title" value="{{ old('job_title', $attendee->job_title) }}" class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Dietary Requirements</label>
                    <input type="text" name="dietary" value="{{ old('dietary', $attendee->dietary) }}" class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Bio</label>
                    <textarea name="bio" rows="3" class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">{{ old('bio', $attendee->bio) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">LinkedIn URL</label>
                    <input type="url" name="linkedin" value="{{ old('linkedin', $attendee->linkedin) }}" class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="https://linkedin.com/in/">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Twitter / X URL</label>
                    <input type="url" name="twitter" value="{{ old('twitter', $attendee->twitter) }}" class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="https://twitter.com/">
                </div>
            </div>
            <div class="flex gap-3 mt-6 justify-end">
                <a href="{{ route('portal.dashboard') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Save Profile</button>
            </div>
        </form>
    </div>
</div>
@endsection
