@extends('layouts.admin')
@section('page-title','Check-In')
@section('page-subtitle', $event->name)
@section('content')
<div class="grid md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
        <p class="text-gray-400 text-sm">Checked In</p>
        <p class="text-3xl font-black text-green-600">{{ $checkedInCount }}</p>
        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalCount > 0 ? round(($checkedInCount/$totalCount)*100) : 0 }}%"></div>
        </div>
        <p class="text-xs text-gray-400 mt-1">{{ $totalCount > 0 ? round(($checkedInCount/$totalCount)*100) : 0 }}% of attendees</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-gray-300">
        <p class="text-gray-400 text-sm">Not Yet</p>
        <p class="text-3xl font-black text-gray-600">{{ $totalCount - $checkedInCount }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-indigo-500">
        <p class="text-gray-400 text-sm">Total Registered</p>
        <p class="text-3xl font-black text-indigo-600">{{ $totalCount }}</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <h3 class="font-bold mb-3">Quick Check-In</h3>
    <form action="{{ route('admin.check-in.store', $event->id) }}" method="POST" class="flex gap-3">
        @csrf
        <select name="attendee_id" class="flex-1 border border-gray-200 rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-green-500" required>
            <option value="">Select attendee to check in...</option>
            @foreach($attendees->where('checked_in', false) as $a)
            <option value="{{ $a->id }}">{{ $a->first_name }} {{ $a->last_name }} — {{ $a->email }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-green-600 text-white px-6 py-2.5 rounded-lg hover:bg-green-700 font-semibold"><i class="fas fa-check mr-2"></i>Check In</button>
    </form>
</div>

<div class="mb-4">
    <form method="GET">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search by name or email..." class="border border-gray-200 rounded-lg px-4 py-2 w-full max-w-md focus:ring-2 focus:ring-indigo-500 outline-none">
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Attendee</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Ticket</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Time</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
        @forelse($attendees as $a)
        <tr class="hover:bg-gray-50 {{ $a->checked_in ? 'bg-green-50/30' : '' }}">
            <td class="px-4 py-3">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full {{ $a->checked_in ? 'bg-green-100' : 'bg-gray-100' }} flex items-center justify-center text-xs font-bold {{ $a->checked_in ? 'text-green-600' : 'text-gray-500' }}">
                        {{ strtoupper(substr($a->first_name,0,1)) }}
                    </div>
                    <div>
                        <p class="font-medium text-sm">{{ $a->first_name }} {{ $a->last_name }}</p>
                        <p class="text-gray-400 text-xs">{{ $a->email }}</p>
                    </div>
                </div>
            </td>
            <td class="px-4 py-3 text-sm text-gray-500">{{ $a->orders->first()?->ticket?->name ?? '—' }}</td>
            <td class="px-4 py-3">
                @if($a->checked_in)
                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold"><i class="fas fa-check mr-1"></i>Checked In</span>
                @else
                <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full text-xs">Pending</span>
                @endif
            </td>
            <td class="px-4 py-3 text-xs text-gray-400">{{ $a->checked_in_at?->format('g:ia') ?? '—' }}</td>
            <td class="px-4 py-3 text-right">
                @if($a->checked_in)
                <form action="{{ route('admin.check-in.undo', [$event->id, $a->id]) }}" method="POST" class="inline">
                    @csrf
                    <button class="text-red-500 text-xs hover:underline"><i class="fas fa-undo mr-1"></i>Undo</button>
                </form>
                @else
                <form action="{{ route('admin.check-in.store', $event->id) }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="attendee_id" value="{{ $a->id }}">
                    <button class="bg-green-600 text-white text-xs px-3 py-1 rounded-lg hover:bg-green-700"><i class="fas fa-check mr-1"></i>Check In</button>
                </form>
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center py-10 text-gray-400">No attendees found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection