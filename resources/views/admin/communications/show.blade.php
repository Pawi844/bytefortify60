@extends('layouts.admin')
@section('page-title', $comm->subject)
@section('page-subtitle', 'Email Communication — '.ucfirst($comm->status))
@section('header-actions')
@if($comm->status === 'draft')
<form action="{{ route('admin.communications.send', [$event->id, $comm->id]) }}" method="POST" class="inline">
    @csrf
    <button type="submit" onclick="return confirm('Send this email to all matching attendees now?')" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
        <i class="fas fa-paper-plane mr-1"></i>Send Now
    </button>
</form>
@endif
<form action="{{ route('admin.communications.destroy', [$event->id, $comm->id]) }}" method="POST" class="inline">
    @csrf @method('DELETE')
    <button onclick="return confirm('Delete?')" class="bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm hover:bg-red-100"><i class="fas fa-trash mr-1"></i>Delete</button>
</form>
@endsection
@section('content')
<div class="max-w-2xl">
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-4">
        <p class="text-gray-400 text-xs">Status</p>
        <p class="font-bold text-lg {{ $comm->status==='sent'?'text-green-600':'text-yellow-600' }}">{{ ucfirst($comm->status) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4">
        <p class="text-gray-400 text-xs">Recipients</p>
        <p class="font-bold capitalize">{{ str_replace('_',' ',$comm->recipients) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-4">
        <p class="text-gray-400 text-xs">Sent Count</p>
        <p class="font-bold text-lg">{{ $comm->sent_count ?? 0 }}</p>
    </div>
</div>
<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="mb-4 pb-4 border-b">
        <p class="text-xs text-gray-400 uppercase">Subject</p>
        <p class="font-bold text-xl mt-1">{{ $comm->subject }}</p>
    </div>
    <div class="mb-4 pb-4 border-b">
        <p class="text-xs text-gray-400 uppercase mb-2">From</p>
        <p class="text-sm">{{ $event->name }} &lt;{{ config('mail.from.address','noreply@eventpro.com') }}&gt;</p>
    </div>
    <div>
        <p class="text-xs text-gray-400 uppercase mb-2">Body</p>
        <div class="bg-gray-50 rounded-xl p-4 whitespace-pre-wrap text-gray-700">{{ $comm->body }}</div>
    </div>
    @if($comm->sent_at)
    <p class="text-gray-400 text-sm mt-4"><i class="fas fa-clock mr-1"></i>Sent {{ $comm->sent_at->format('M d, Y g:ia') }} to {{ $comm->sent_count }} attendees</p>
    @endif
</div>
</div>
@endsection
