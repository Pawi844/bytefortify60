@extends('layouts.admin')
@section('page-title', $survey->title)
@section('page-subtitle', $event->name . ' · ' . $survey->responses_count . ' responses')
@section('header-actions')
<a href="{{ route('admin.surveys.edit', [$event->id, $survey->id]) }}" class="bg-white border text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-50"><i class="fas fa-edit mr-1"></i>Edit</a>
@endsection
@section('content')
<div class="grid md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5"><p class="text-gray-400 text-sm">Total Responses</p><p class="text-3xl font-bold text-indigo-600">{{ $survey->responses->count() }}</p></div>
    <div class="bg-white rounded-xl shadow-sm p-5"><p class="text-gray-400 text-sm">Status</p><p class="text-xl font-bold {{ $survey->is_active?'text-green-600':'text-gray-400' }}">{{ $survey->is_active?'Active':'Inactive' }}</p></div>
    <div class="bg-white rounded-xl shadow-sm p-5"><p class="text-gray-400 text-sm">Closes</p><p class="text-xl font-bold">{{ $survey->ends_at?$survey->ends_at->format('M d, Y'):'No end date' }}</p></div>
</div>
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b"><h3 class="font-bold">Responses</h3></div>
    <table class="min-w-full divide-y divide-gray-100">
        <thead class="bg-gray-50"><tr>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">Attendee</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">Submitted</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">Answers Preview</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-50">
        @forelse($survey->responses as $r)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3 text-sm font-medium">{{ $r->attendee?->first_name }} {{ $r->attendee?->last_name }}</td>
            <td class="px-4 py-3 text-sm text-gray-400">{{ $r->created_at->format('M d, Y g:ia') }}</td>
            <td class="px-4 py-3 text-sm text-gray-500 max-w-xs truncate">{{ $r->answers }}</td>
        </tr>
        @empty
        <tr><td colspan="3" class="text-center py-10 text-gray-400">No responses yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
