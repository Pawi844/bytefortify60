@extends('layouts.admin')
@section('page-title','Add Sponsor')
@section('page-subtitle', $event->name)
@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl shadow-sm p-8">
<form action="{{ route('admin.sponsors.store', $event->id) }}" method="POST">
@csrf
<div class="grid md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Company Name *</label>
        <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Sponsorship Tier *</label>
        <select name="tier" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
            @foreach(['platinum','gold','silver','bronze','partner'] as $t)
            <option value="{{ $t }}" {{ old('tier') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Website</label>
        <input type="url" name="website" value="{{ old('website') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" placeholder="https://...">
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
        <textarea name="description" rows="3" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Contact Name</label>
        <input type="text" name="contact_name" value="{{ old('contact_name') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Contact Email</label>
        <input type="email" name="contact_email" value="{{ old('contact_email') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Logo URL</label>
        <input type="text" name="logo" value="{{ old('logo') }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" placeholder="https://...">
    </div>
</div>
<div class="flex gap-3 mt-6 justify-end">
    <a href="{{ route('admin.sponsors.index', $event->id) }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</a>
    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Add Sponsor</button>
</div>
</form>
</div>
</div>
@endsection