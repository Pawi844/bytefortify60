@extends('layouts.admin')
@section('page-title','All Events')
@section('page-subtitle','Manage all your events')
@section('header-actions')
<a href="{{ route('admin.events.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 flex items-center gap-2">
    <i class="fas fa-plus"></i> Create Event
</a>
@endsection
@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($events as $event)
    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition">
        <div class="h-36 bg-gradient-to-br {{ ['from-indigo-500 to-purple-600','from-teal-500 to-cyan-600','from-amber-500 to-orange-600','from-pink-500 to-rose-600','from-blue-500 to-indigo-600'][$loop->index % 5] }} relative flex items-end p-4">
            <div>
                <span class="px-2 py-0.5 text-xs rounded-full {{ $event->status === 'published' ? 'bg-green-400 text-white' : 'bg-white/30 text-white' }}">{{ ucfirst($event->status) }}</span>
                @if($event->category)<span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-white/20 text-white">{{ $event->category }}</span>@endif
            </div>
        </div>
        <div class="p-4">
            <h3 class="font-bold text-lg mb-1">{{ $event->name }}</h3>
            <p class="text-gray-400 text-sm mb-2"><i class="far fa-calendar mr-1"></i>{{ $event->start_date->format('M d') }} – {{ $event->end_date->format('M d, Y') }}</p>
            <p class="text-gray-400 text-sm mb-3"><i class="fas fa-map-marker-alt mr-1"></i>{{ $event->location ?? 'TBD' }}</p>
            <div class="grid grid-cols-3 gap-2 text-center mb-4 bg-gray-50 rounded-lg p-2">
                <div><p class="font-bold text-sm">{{ $event->attendees_count }}</p><p class="text-gray-400 text-xs">Attendees</p></div>
                <div><p class="font-bold text-sm">{{ $event->orders_count }}</p><p class="text-gray-400 text-xs">Orders</p></div>
                <div><p class="font-bold text-sm">{{ $event->speakers_count }}</p><p class="text-gray-400 text-xs">Speakers</p></div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.events.show', $event->id) }}" class="flex-1 text-center bg-indigo-600 text-white py-2 rounded-lg text-sm hover:bg-indigo-700">Manage</a>
                <a href="{{ route('admin.events.edit', $event->id) }}" class="px-3 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200"><i class="fas fa-edit"></i></a>
                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this event?')" class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-sm hover:bg-red-100"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-20 text-gray-400">
        <i class="fas fa-calendar-times text-6xl mb-4"></i>
        <p class="text-xl font-semibold">No events yet</p>
        <a href="{{ route('admin.events.create') }}" class="mt-4 inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">Create Your First Event</a>
    </div>
    @endforelse
</div>
<div class="mt-6">{{ $events->links() }}</div>
@endsection
