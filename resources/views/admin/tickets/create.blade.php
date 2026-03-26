@extends('layouts.admin')
@section('page-title','Create Ticket')
@section('page-subtitle', $event->name)
@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl shadow-sm p-8">
<form action="{{ route('admin.tickets.store', $event->id) }}" method="POST">
@csrf
<div class="grid md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Ticket Name *</label>
        <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" placeholder="e.g. Early Bird, VIP, Student" required>
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
        <textarea name="description" rows="2" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" placeholder="What's included with this ticket?">{{ old('description') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Ticket Type *</label>
        <select name="ticket_type" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
            <option value="paid" {{ old('ticket_type') === 'paid' ? 'selected' : '' }}>Paid</option>
            <option value="free" {{ old('ticket_type') === 'free' ? 'selected' : '' }}>Free</option>
            <option value="donation" {{ old('ticket_type') === 'donation' ? 'selected' : '' }}>Donation</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Price ($) *</label>
        <input type="number" step="0.01" min="0" name="price" value="{{ old('price', 0) }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Total Quantity *</label>
        <input type="number" min="1" name="quantity" value="{{ old('quantity', 100) }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Max Per Order</label>
        <input type="number" min="1" name="max_per_order" value="{{ old('max_per_order', 10) }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Sale Start</label>
        <input type="datetime-local" name="sale_start" value="{{ old('sale_start') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Sale End</label>
        <input type="datetime-local" name="sale_end" value="{{ old('sale_end') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div class="md:col-span-2 flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
        <input type="hidden" name="is_visible" value="0">
        <input type="checkbox" name="is_visible" value="1" id="is_visible" checked class="w-4 h-4 text-indigo-600">
        <label for="is_visible" class="text-sm font-medium text-gray-700">Visible on registration form</label>
    </div>
</div>
<div class="flex gap-3 mt-6 justify-end">
    <a href="{{ route('admin.tickets.index', $event->id) }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</a>
    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700"><i class="fas fa-plus mr-2"></i>Create Ticket</button>
</div>
</form>
</div>
</div>
@endsection