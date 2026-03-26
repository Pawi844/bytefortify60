@extends('layouts.admin')
@section('page-title','Website Settings')
@section('page-subtitle', $event->name)
@section('header-actions')
<a href="{{ route('event.show', $event->slug) }}" target="_blank" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">
    <i class="fas fa-external-link-alt mr-1"></i>View Live Site
</a>
@endsection
@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl shadow-sm p-8">
<form action="{{ route('admin.website.update', $event->id) }}" method="POST">
@csrf @method('PUT')
<div class="space-y-5">
    <h3 class="font-bold text-gray-700 text-lg border-b pb-2">Hero Section</h3>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Hero Title</label>
        <input type="text" name="website_hero_title" value="{{ old('website_hero_title', $event->website_hero_title) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="{{ $event->name }}">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Hero Subtitle</label>
        <input type="text" name="website_hero_subtitle" value="{{ old('website_hero_subtitle', $event->website_hero_subtitle) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Short tagline">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Primary Brand Color</label>
        <div class="flex gap-3 items-center">
            <input type="color" name="website_primary_color" value="{{ old('website_primary_color', $event->website_primary_color ?? '#6366f1') }}" class="w-12 h-10 border rounded cursor-pointer">
            <input type="text" value="{{ $event->website_primary_color ?? '#6366f1' }}" class="flex-1 border border-gray-200 rounded-lg px-4 py-2.5 font-mono text-sm outline-none" readonly id="color_text">
        </div>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">About Section</label>
        <textarea name="website_about" rows="4" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">{{ old('website_about', $event->website_about) }}</textarea>
    </div>
    <h3 class="font-bold text-gray-700 text-lg border-b pb-2 pt-2">Sections to Show</h3>
    <div class="space-y-2">
        @foreach(['website_show_speakers'=>'Show Speakers Section','website_show_schedule'=>'Show Schedule Section','website_show_sponsors'=>'Show Sponsors Section'] as $key => $label)
        <div class="flex items-center gap-2">
            <input type="hidden" name="{{ $key }}" value="0">
            <input type="checkbox" name="{{ $key }}" value="1" id="{{ $key }}" {{ $event->$key ? 'checked':'' }} class="w-4 h-4 text-indigo-600">
            <label for="{{ $key }}" class="text-sm font-medium text-gray-700">{{ $label }}</label>
        </div>
        @endforeach
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Custom Domain <span class="text-gray-400 font-normal">(optional)</span></label>
        <input type="text" name="custom_domain" value="{{ old('custom_domain', $event->custom_domain) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="e.g. techsummit2025.com">
    </div>
</div>
<div class="flex gap-3 mt-6 justify-end">
    <a href="{{ route('admin.events.show', $event->id) }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</a>
    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium">Save Website Settings</button>
</div>
</form>
</div>
</div>
@endsection
