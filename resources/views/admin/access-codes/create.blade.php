@extends('layouts.admin')
@section('page-title','Create Access Code')
@section('page-subtitle', $event->name)
@section('content')
<div class="max-w-xl">
<div class="bg-white rounded-xl shadow-sm p-8">
<form action="{{ route('admin.access-codes.store', $event->id) }}" method="POST">
@csrf
<div class="space-y-4">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Code <span class="text-gray-400 font-normal">(leave blank to auto-generate)</span></label>
        <input type="text" name="code" value="{{ old('code') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 font-mono uppercase focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="e.g. EARLY50">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Discount Type *</label>
        <select name="discount_type" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
            <option value="percentage" {{ old('discount_type')==='percentage'?'selected':'' }}>Percentage (%)</option>
            <option value="fixed" {{ old('discount_type')==='fixed'?'selected':'' }}>Fixed Amount ($)</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Discount Amount *</label>
        <input type="number" name="discount" value="{{ old('discount') }}" required step="0.01" min="0" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="e.g. 50">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Max Uses <span class="text-gray-400 font-normal">(leave blank for unlimited)</span></label>
        <input type="number" name="max_uses" value="{{ old('max_uses') }}" min="1" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="e.g. 100">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Expiry Date</label>
        <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
        <input type="text" name="description" value="{{ old('description') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="e.g. Early bird discount">
    </div>
</div>
<div class="flex gap-3 mt-6 justify-end">
    <a href="{{ route('admin.access-codes.index', $event->id) }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</a>
    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium"><i class="fas fa-key mr-2"></i>Create Code</button>
</div>
</form>
</div>
</div>
@endsection
