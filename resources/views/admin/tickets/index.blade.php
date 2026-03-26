@extends('layouts.admin')
@section('page-title','Tickets')
@section('page-subtitle', $event->name)
@section('header-actions')
<a href="{{ route('admin.tickets.create', $event->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 flex items-center gap-2">
    <i class="fas fa-plus"></i> Add Ticket
</a>
@endsection
@section('content')
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($tickets as $ticket)
    <div class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition">
        <div class="flex justify-between items-start mb-3">
            <div>
                <h3 class="font-bold text-gray-800">{{ $ticket->name }}</h3>
                <span class="text-xs px-2 py-0.5 rounded-full {{ $ticket->ticket_type === 'free' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ ucfirst($ticket->ticket_type) }}
                </span>
            </div>
            <p class="text-2xl font-black text-indigo-700">
                {{ $ticket->price > 0 ? 'KES '.number_format($ticket->price,2) : 'FREE' }}
            </p>
        </div>
        @if($ticket->description)<p class="text-gray-400 text-sm mb-3">{{ $ticket->description }}</p>@endif
        <div class="grid grid-cols-3 gap-2 text-center bg-gray-50 rounded-lg p-2 mb-4">
            <div><p class="font-bold text-sm">{{ $ticket->quantity }}</p><p class="text-gray-400 text-xs">Total</p></div>
            <div><p class="font-bold text-sm text-green-600">{{ $ticket->orders_count }}</p><p class="text-gray-400 text-xs">Sold</p></div>
            <div><p class="font-bold text-sm">{{ max(0, $ticket->quantity - $ticket->orders_count) }}</p><p class="text-gray-400 text-xs">Left</p></div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.tickets.edit', [$event->id, $ticket->id]) }}" class="flex-1 text-center bg-indigo-50 text-indigo-700 py-1.5 rounded-lg text-sm hover:bg-indigo-100">
                <i class="fas fa-edit mr-1"></i>Edit
            </a>
            <form action="{{ route('admin.tickets.destroy', [$event->id, $ticket->id]) }}" method="POST" class="flex-1">
                @csrf @method('DELETE')
                <button onclick="return confirm('Delete ticket?')" class="w-full bg-red-50 text-red-600 py-1.5 rounded-lg text-sm hover:bg-red-100">
                    <i class="fas fa-trash mr-1"></i>Delete
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-16 text-gray-400">
        <i class="fas fa-ticket-alt text-5xl mb-3"></i>
        <p class="text-lg font-semibold">No tickets yet</p>
        <a href="{{ route('admin.tickets.create', $event->id) }}" class="mt-3 inline-block bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">Create First Ticket</a>
    </div>
    @endforelse
</div>
@endsection