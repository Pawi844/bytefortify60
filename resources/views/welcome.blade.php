@extends('layouts.app')
@section('title','EventPro — Professional Event Management Platform')
@section('content')
<section class="gradient-hero text-white py-24">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <div class="inline-flex items-center gap-2 bg-white/20 rounded-full px-4 py-1.5 text-sm mb-6">
            <i class="fas fa-sparkles"></i> Professional Multi-Event Management
        </div>
        <h1 class="text-5xl md:text-6xl font-extrabold mb-6 leading-tight">Manage Events That<br><span class="text-yellow-300">Inspire & Connect</span></h1>
        <p class="text-xl text-white/80 mb-10 max-w-2xl mx-auto">Create stunning event experiences, manage tickets, speakers, papers and attendees — all from one powerful platform.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('admin.dashboard') }}" class="bg-white text-indigo-700 font-bold px-8 py-3 rounded-xl hover:bg-yellow-300 transition-all shadow-lg"><i class="fas fa-rocket mr-2"></i>Launch Admin Panel</a>
            <a href="{{ route('portal.login') }}" class="border-2 border-white text-white font-bold px-8 py-3 rounded-xl hover:bg-white/10 transition-all"><i class="fas fa-user mr-2"></i>Attendee Portal</a>
        </div>
        <div class="mt-12 grid grid-cols-3 gap-8 max-w-md mx-auto">
            <div class="text-center"><p class="text-3xl font-bold">3</p><p class="text-white/70 text-sm">Sample Events</p></div>
            <div class="text-center"><p class="text-3xl font-bold">10+</p><p class="text-white/70 text-sm">Features</p></div>
            <div class="text-center"><p class="text-3xl font-bold">∞</p><p class="text-white/70 text-sm">Possibilities</p></div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-3">Everything You Need to Run World-Class Events</h2>
            <p class="text-gray-500">From CFP to check-in, manage every aspect of your event.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @php $features = [
                ['icon'=>'fa-ticket-alt','color'=>'text-indigo-600','bg'=>'bg-indigo-50','title'=>'Ticket Management','desc'=>'Create multiple ticket tiers, access codes, free and paid tickets with capacity control.'],
                ['icon'=>'fa-users','color'=>'text-green-600','bg'=>'bg-green-50','title'=>'Attendee Management','desc'=>'Full attendee lifecycle — registration, check-in, badges, invoices and portal access.'],
                ['icon'=>'fa-file-alt','color'=>'text-blue-600','bg'=>'bg-blue-50','title'=>'CFP & Peer Review','desc'=>'Call for papers with custom fields, blind peer review, author notifications, and decision workflow.'],
                ['icon'=>'fa-id-badge','color'=>'text-purple-600','bg'=>'bg-purple-50','title'=>'Badge Generation','desc'=>'Printable attendee badges with QR codes, customizable templates per event.'],
                ['icon'=>'fa-calendar-alt','color'=>'text-orange-600','bg'=>'bg-orange-50','title'=>'Schedule Builder','desc'=>'Multi-track agenda with rooms, speakers, session types. Attendees pick their sessions.'],
                ['icon'=>'fa-envelope','color'=>'text-red-600','bg'=>'bg-red-50','title'=>'Email Communications','desc'=>'Targeted email blasts to all attendees, paid, pending or checked-in subsets.'],
                ['icon'=>'fa-poll','color'=>'text-teal-600','bg'=>'bg-teal-50','title'=>'Surveys','desc'=>'Post-event feedback surveys with custom questions and response analytics.'],
                ['icon'=>'fa-globe','color'=>'text-yellow-600','bg'=>'bg-yellow-50','title'=>'Event Websites','desc'=>'Custom public-facing event pages with speaker showcase, sponsor logos and registration.'],
            ] @endphp
            @foreach($features as $f)
            <div class="bg-white border border-gray-100 rounded-xl p-6 hover:shadow-lg transition-all">
                <div class="{{ $f['bg'] }} w-12 h-12 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas {{ $f['icon'] }} {{ $f['color'] }} text-xl"></i>
                </div>
                <h3 class="font-bold mb-2">{{ $f['title'] }}</h3>
                <p class="text-gray-500 text-sm">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-8 text-center">Quick Access — Demo Events</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @php
            $demoEvents = [
                ['name'=>'TechSummit 2025','slug'=>'techsummit-2025','category'=>'Technology','date'=>'Sep 15–17, 2025','color'=>'from-indigo-500 to-purple-600'],
                ['name'=>'Digital Marketing Summit','slug'=>'digital-marketing-summit-2025','category'=>'Marketing','date'=>'Oct 20–21, 2025','color'=>'from-amber-500 to-orange-600'],
                ['name'=>'HealthTech Forum','slug'=>'healthtech-innovation-forum-2025','category'=>'Healthcare','date'=>'Nov 8–9, 2025','color'=>'from-teal-500 to-cyan-600'],
            ];
            @endphp
            @foreach($demoEvents as $e)
            <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-lg transition">
                <div class="h-32 bg-gradient-to-br {{ $e['color'] }} flex items-end p-4">
                    <span class="bg-white/20 text-white text-xs px-2 py-1 rounded-full">{{ $e['category'] }}</span>
                </div>
                <div class="p-4">
                    <h3 class="font-bold mb-1">{{ $e['name'] }}</h3>
                    <p class="text-gray-400 text-sm mb-3"><i class="far fa-calendar mr-1"></i>{{ $e['date'] }}</p>
                    <div class="flex gap-2">
                        <a href="/events/{{ $e['slug'] }}" class="flex-1 text-center bg-indigo-50 text-indigo-700 py-1.5 rounded-lg text-sm hover:bg-indigo-100">View Site</a>
                        <a href="{{ route('admin.events.index') }}" class="flex-1 text-center bg-gray-50 text-gray-700 py-1.5 rounded-lg text-sm hover:bg-gray-100">Manage</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
