@extends('layouts.admin')
@section('page-title','Edit Ticket')
@section('page-subtitle', $event->name . ' — ' . $ticket->name)
@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl shadow-sm p-8">
<form action="{{ route('admin.tickets.update', [$event->id, $ticket->id]) }}" method="POST">
@csrf @method('PUT')
<div class="grid md:grid-cols-2 gap-5">
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Ticket Name *</label>
        <input type="text" name="name" value="{{ old('name', $ticket->name) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
        <textarea name="description" rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $ticket->description) }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Ticket Type *</label>
        <select name="ticket_type" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
            @foreach(['paid','free','donation'] as $t)
            <option value="{{ $t }}" {{ old('ticket_type',$ticket->ticket_type)==$t?'selected':'' }}>{{ ucfirst($t) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Price (KES) *</label>
        <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $ticket->price) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Quantity Available *</label>
        <input type="number" min="1" name="quantity" value="{{ old('quantity', $ticket->quantity) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Max Per Order</label>
        <input type="number" min="1" name="max_per_order" value="{{ old('max_per_order', $ticket->max_per_order) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg md:col-span-2">
        <input type="hidden" name="is_visible" value="0">
        <input type="checkbox" name="is_visible" value="1" id="is_visible" {{ old('is_visible',$ticket->is_visible) ? 'checked' : '' }} class="w-4 h-4 text-indigo-600">
        <label for="is_visible" class="text-sm font-medium text-gray-700">Visible to public</label>
    </div>
</div>
<div class="flex gap-3 mt-6 justify-end">
    <a href="{{ route('admin.tickets.index', $event->id) }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</a>
    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Save Changes</button>
</div>
</form>
</div>
</div>
@endsection