@extends('layouts.admin')
@section('page-title','Edit Exhibitor')
@section('page-subtitle', $exhibitor->company_name)
@section('content')
<div class="max-w-2xl"><div class="bg-white rounded-xl shadow-sm p-8">
<form action="{{ route('admin.exhibitors.update', [$event->id, $exhibitor->id]) }}" method="POST">
@csrf @method('PUT')
<div class="grid md:grid-cols-2 gap-4">
    <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1">Company Name *</label><input type="text" name="company_name" value="{{ old('company_name', $exhibitor->company_name) }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required></div>
    <div><label class="block text-sm font-semibold text-gray-700 mb-1">Booth Number</label><input type="text" name="booth_number" value="{{ old('booth_number', $exhibitor->booth_number) }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500"></div>
    <div><label class="block text-sm font-semibold text-gray-700 mb-1">Booth Size</label>
        <select name="booth_size" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
            @foreach(['small','medium','large','extra_large'] as $s)<option value="{{ $s }}" {{ old('booth_size',$exhibitor->booth_size) === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach
        </select></div>
    <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1">Description</label><textarea name="description" rows="3" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description', $exhibitor->description) }}</textarea></div>
    <div><label class="block text-sm font-semibold text-gray-700 mb-1">Website</label><input type="url" name="website" value="{{ old('website', $exhibitor->website) }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500"></div>
    <div><label class="block text-sm font-semibold text-gray-700 mb-1">Logo URL</label><input type="text" name="logo" value="{{ old('logo', $exhibitor->logo) }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500"></div>
    <div><label class="block text-sm font-semibold text-gray-700 mb-1">Contact Name</label><input type="text" name="contact_name" value="{{ old('contact_name', $exhibitor->contact_name) }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500"></div>
    <div><label class="block text-sm font-semibold text-gray-700 mb-1">Contact Email</label><input type="email" name="contact_email" value="{{ old('contact_email', $exhibitor->contact_email) }}" class="w-full border rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500"></div>
</div>
<div class="flex gap-3 mt-6 justify-end">
    <a href="{{ route('admin.exhibitors.index', $event->id) }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</a>
    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Save Changes</button>
</div>
</form>
</div></div>
@endsection