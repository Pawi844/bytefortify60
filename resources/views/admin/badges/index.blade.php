@extends('layouts.admin')
@section('page-title','Badge Designer')
@section('page-subtitle', $event->name)
@section('header-actions')
<a href="{{ route('admin.badges.print-all', $event->id) }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700">
    <i class="fas fa-print mr-1"></i>Print All Badges
</a>
@endsection
@section('content')
<div class="grid md:grid-cols-2 gap-6">
    <div>
        <div class="bg-white rounded-xl shadow-sm p-6 mb-4">
            <h3 class="font-bold mb-4">Badge Settings</h3>
            <form action="{{ route('admin.badges.update', $event->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Badge Background Color</label>
                    <input type="color" name="badge_color" value="{{ $event->website_primary_color ?? '#6366f1' }}" class="w-12 h-10 border rounded cursor-pointer">
                </div>
                <div class="space-y-2">
                    @foreach(['show_name'=>'Show Full Name','show_job_title'=>'Show Job Title','show_organization'=>'Show Organization','show_ticket_type'=>'Show Ticket Type'] as $k=>$l)
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="{{ $k }}" value="1" checked class="w-4 h-4 text-indigo-600">
                        <span class="text-sm text-gray-700">{{ $l }}</span>
                    </label>
                    @endforeach
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 text-sm font-semibold">Save Badge Template</button>
            </div>
            </form>
        </div>
    </div>
    <div>
        <h3 class="font-bold mb-4">Badge Preview</h3>
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden" style="width:280px">
            <div class="h-16 flex items-center justify-center" style="background: {{ $event->website_primary_color ?? '#6366f1' }}">
                <p class="text-white font-bold text-sm">{{ $event->name }}</p>
            </div>
            <div class="p-5 text-center">
                <div class="w-16 h-16 rounded-full flex items-center justify-center text-white text-2xl font-black mx-auto mb-3" style="background: {{ $event->website_primary_color ?? '#6366f1' }}">JD</div>
                <p class="text-2xl font-black">John</p>
                <p class="text-2xl font-black">Doe</p>
                <p class="text-gray-500 text-sm mt-1">Software Engineer</p>
                <p class="text-gray-400 text-xs">Acme Corporation</p>
                <div class="mt-3 px-3 py-1 rounded-full text-xs text-white font-bold inline-block" style="background: {{ $event->website_primary_color ?? '#6366f1' }}">General Admission</div>
            </div>
        </div>
        <p class="text-gray-400 text-xs mt-3">This is a preview. Actual badges use real attendee data.</p>
    </div>
</div>
@endsection
