@extends('layouts.admin')
@section('page-title','Email Communications')
@section('page-subtitle', $event->name)
@section('header-actions')
<a href="{{ route('admin.communications.create', $event->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 flex items-center gap-2">
    <i class="fas fa-plus"></i> New Email
</a>
@endsection
@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Subject</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Recipients</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Sent</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
        @forelse($comms as $comm)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3 font-medium text-sm">{{ $comm->subject }}</td>
            <td class="px-4 py-3 text-sm capitalize text-gray-500">{{ str_replace('_',' ',$comm->recipients) }} attendees</td>
            <td class="px-4 py-3">
                <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $comm->status==='sent'?'bg-green-100 text-green-700':'bg-yellow-100 text-yellow-700' }}">{{ ucfirst($comm->status) }}</span>
            </td>
            <td class="px-4 py-3 text-sm text-gray-400">
                {{ $comm->sent_at ? $comm->sent_at->format('M d, Y g:ia').' ('.$comm->sent_count.' sent)' : '—' }}
            </td>
            <td class="px-4 py-3 text-right flex items-center justify-end gap-2">
                <a href="{{ route('admin.communications.show', [$event->id, $comm->id]) }}" class="text-indigo-600 hover:text-indigo-800 text-sm"><i class="fas fa-eye"></i></a>
                @if($comm->status === 'draft')
                <form action="{{ route('admin.communications.send', [$event->id, $comm->id]) }}" method="POST" class="inline">
                    @csrf <button onclick="return confirm('Send this email now?')" class="text-green-600 hover:text-green-800 text-sm"><i class="fas fa-paper-plane"></i></button>
                </form>
                @endif
                <form action="{{ route('admin.communications.destroy', [$event->id, $comm->id]) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Delete?')" class="text-red-500 hover:text-red-700 text-sm"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center py-12 text-gray-400"><i class="fas fa-envelope text-4xl mb-3 block"></i>No emails yet. Create your first communication.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $comms->links() }}</div>
@endsection
