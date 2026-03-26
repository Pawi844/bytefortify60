@extends('layouts.admin')
@section('page-title','New Email Communication')
@section('page-subtitle', $event->name)
@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl shadow-sm p-8">
<form action="{{ route('admin.communications.store', $event->id) }}" method="POST">
@csrf
<div class="space-y-4">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Subject *</label>
        <input type="text" name="subject" value="{{ old('subject') }}" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="e.g. Important event update — {{ $event->name }}">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Send To *</label>
        <select name="recipients" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
            <option value="all">All Attendees</option>
            <option value="paid">Paid Attendees Only</option>
            <option value="pending">Pending Payment Attendees</option>
            <option value="checked_in">Checked-In Attendees</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Email Body *</label>
        <textarea name="body" rows="12" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Write your email content here...">{{ old('body') }}</textarea>
        <p class="text-gray-400 text-xs mt-1">Plain text email. You can include links.</p>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Schedule Send (optional)</label>
        <input type="datetime-local" name="send_at" value="{{ old('send_at') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
        <p class="text-gray-400 text-xs mt-1">Leave blank to send manually from the preview page.</p>
    </div>
</div>
<div class="flex gap-3 mt-6 justify-end">
    <a href="{{ route('admin.communications.index', $event->id) }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</a>
    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium"><i class="fas fa-save mr-2"></i>Save as Draft</button>
</div>
</form>
</div>
</div>
@endsection
