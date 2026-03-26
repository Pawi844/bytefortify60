@extends('layouts.admin')
@section('page-title','Sponsors')
@section('page-subtitle', $event->name)
@section('header-actions')
<a href="{{ route('admin.sponsors.create', $event->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 flex items-center gap-2">
    <i class="fas fa-plus"></i> Add Sponsor
</a>
@endsection
@section('content')
@php $tiers = ['platinum'=>['bg-gray-100 border-2 border-gray-400','text-gray-600'],'gold'=>['bg-yellow-50 border-2 border-yellow-400','text-yellow-700'],'silver'=>['bg-slate-50 border-2 border-slate-300','text-slate-600'],'bronze'=>['bg-orange-50 border-2 border-orange-300','text-orange-700'],'partner'=>['bg-blue-50 border-2 border-blue-200','text-blue-600']]; @endphp
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($sponsors as $sponsor)
    @php $tierStyle = $tiers[$sponsor->tier] ?? ['bg-white border','text-gray-600'] @endphp
    <div class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition">
        <div class="flex justify-between items-start mb-3">
            <h3 class="font-bold text-gray-800">{{ $sponsor->name }}</h3>
            <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ $tierStyle[0] }} {{ $tierStyle[1] }}">{{ ucfirst($sponsor->tier) }}</span>
        </div>
        @if($sponsor->description)<p class="text-gray-400 text-sm mb-2">{{ Str::limit($sponsor->description, 80) }}</p>@endif
        @if($sponsor->website)<a href="{{ $sponsor->website }}" target="_blank" class="text-indigo-600 text-xs hover:underline"><i class="fas fa-external-link-alt mr-1"></i>Website</a>@endif
        @if($sponsor->contact_email)<p class="text-gray-400 text-xs mt-1"><i class="fas fa-envelope mr-1"></i>{{ $sponsor->contact_email }}</p>@endif
        <div class="flex gap-2 mt-4">
            <a href="{{ route('admin.sponsors.edit', [$event->id, $sponsor->id]) }}" class="flex-1 text-center bg-indigo-50 text-indigo-700 py-1.5 rounded-lg text-sm hover:bg-indigo-100">Edit</a>
            <form action="{{ route('admin.sponsors.destroy', [$event->id, $sponsor->id]) }}" method="POST" class="flex-1">
                @csrf @method('DELETE')
                <button onclick="return confirm('Remove sponsor?')" class="w-full bg-red-50 text-red-600 py-1.5 rounded-lg text-sm hover:bg-red-100">Remove</button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-16 text-gray-400">
        <i class="fas fa-handshake text-5xl mb-3 block"></i>
        <p class="text-lg font-semibold">No sponsors yet</p>
        <a href="{{ route('admin.sponsors.create', $event->id) }}" class="mt-3 inline-block bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">Add First Sponsor</a>
    </div>
    @endforelse
</div>
@endsection