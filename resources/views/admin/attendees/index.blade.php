@extends('layouts.admin')
@section('page-title','Attendees')
@section('page-subtitle', $event->name)
@section('header-actions')
<a href="{{ route('admin.attendees.export', $event->id) }}" class="bg-white border text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-50"><i class="fas fa-download mr-1"></i>Export CSV</a>
@endsection
@section('content')
<form method="GET" class="mb-4">
    <div class="flex gap-3">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search by name or email..." class="flex-1 border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 outline-none">
        <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700"><i class="fas fa-search"></i></button>
    </div>
</form>
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Organization</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Ticket</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Check-In</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
        @forelse($attendees as $a)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-xs font-bold">{{ strtoupper(substr($a->first_name,0,1)) }}</div>
                        <span class="font-medium text-sm">{{ $a->first_name }} {{ $a->last_name }}</span>
                    </div>
                </td>
                <td class="px-4 py-3 text-sm text-gray-500">{{ $a->email }}</td>
                <td class="px-4 py-3 text-sm text-gray-500">{{ $a->organization ?? '—' }}</td>
                <td class="px-4 py-3 text-sm">{{ $a->orders->first()?->ticket?->name ?? '—' }}</td>
                <td class="px-4 py-3">
                    @if($a->checked_in)
                    <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs"><i class="fas fa-check mr-1"></i>Checked In</span>
                    @else
                    <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full text-xs">Not Yet</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-right">
                    <a href="{{ route('admin.attendees.show', [$event->id, $a->id]) }}" class="text-indigo-600 hover:text-indigo-800 text-sm mr-2"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('admin.attendees.badge', [$event->id, $a->id]) }}" class="text-purple-600 hover:text-purple-800 text-sm mr-2"><i class="fas fa-id-badge"></i></a>
                    <a href="{{ route('admin.attendees.edit', [$event->id, $a->id]) }}" class="text-gray-600 hover:text-gray-800 text-sm"><i class="fas fa-edit"></i></a>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center py-10 text-gray-400">No attendees found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $attendees->withQueryString()->links() }}</div>
@endsection
