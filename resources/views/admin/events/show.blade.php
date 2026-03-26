@extends('layouts.admin')
@section('page-title', $event->name)
@section('page-subtitle', $event->venue . ' · ' . $event->start_date->format('M d, Y'))
@section('header-actions')
@if($event->status === 'draft')
<form action="{{ route('admin.events.publish', $event->id) }}" method="POST" class="inline">
    @csrf
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700"><i class="fas fa-globe mr-1"></i>Publish</button>
</form>
@else
<form action="{{ route('admin.events.unpublish', $event->id) }}" method="POST" class="inline">
    @csrf
    <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-700"><i class="fas fa-eye-slash mr-1"></i>Unpublish</button>
</form>
@endif
<a href="{{ route('admin.events.edit', $event->id) }}" class="bg-white border text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-50"><i class="fas fa-edit mr-1"></i>Edit</a>
<a href="{{ route('event.show', $event->slug) }}" target="_blank" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700"><i class="fas fa-external-link-alt mr-1"></i>Live Site</a>
@endsection
@section('content')
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    @php $stats = [['label'=>'Attendees','val'=>$event->attendees_count,'icon'=>'fa-users','color'=>'text-indigo-600','bg'=>'bg-indigo-50'],['label'=>'Orders','val'=>$event->orders_count,'icon'=>'fa-receipt','color'=>'text-green-600','bg'=>'bg-green-50'],['label'=>'Revenue','val'=>'$'.number_format($revenue),'icon'=>'fa-dollar-sign','color'=>'text-blue-600','bg'=>'bg-blue-50'],['label'=>'Checked In','val'=>$checkedIn,'icon'=>'fa-check-circle','color'=>'text-purple-600','bg'=>'bg-purple-50'],['label'=>'Papers','val'=>$event->papers_count,'icon'=>'fa-file-alt','color'=>'text-orange-600','bg'=>'bg-orange-50']] @endphp
    @foreach($stats as $s)
    <div class="bg-white rounded-xl shadow-sm p-4 text-center">
        <div class="{{ $s['bg'] }} w-10 h-10 rounded-xl flex items-center justify-center mx-auto mb-2">
            <i class="fas {{ $s['icon'] }} {{ $s['color'] }}"></i>
        </div>
        <p class="text-2xl font-bold">{{ $s['val'] }}</p>
        <p class="text-gray-400 text-xs">{{ $s['label'] }}</p>
    </div>
    @endforeach
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
    @php $menus = [
        ['label'=>'Tickets','icon'=>'fa-ticket-alt','color'=>'bg-indigo-600','route'=>route('admin.tickets.index',$event->id)],
        ['label'=>'Orders','icon'=>'fa-receipt','color'=>'bg-green-600','route'=>route('admin.orders.index',$event->id)],
        ['label'=>'Attendees','icon'=>'fa-users','color'=>'bg-blue-600','route'=>route('admin.attendees.index',$event->id)],
        ['label'=>'Check-In','icon'=>'fa-qrcode','color'=>'bg-purple-600','route'=>route('admin.check-in.index',$event->id)],
        ['label'=>'Papers (CFP)','icon'=>'fa-file-alt','color'=>'bg-orange-600','route'=>route('admin.papers.index',$event->id)],
        ['label'=>'Paper Fields','icon'=>'fa-list-ul','color'=>'bg-amber-600','route'=>route('admin.paper-fields.index',$event->id)],
        ['label'=>'Surveys','icon'=>'fa-poll','color'=>'bg-teal-600','route'=>route('admin.surveys.index',$event->id)],
        ['label'=>'Access Codes','icon'=>'fa-key','color'=>'bg-pink-600','route'=>route('admin.access-codes.index',$event->id)],
        ['label'=>'Speakers','icon'=>'fa-microphone','color'=>'bg-cyan-600','route'=>route('admin.speakers.index',$event->id)],
        ['label'=>'Schedule','icon'=>'fa-clock','color'=>'bg-slate-600','route'=>route('admin.schedule.index',$event->id)],
        ['label'=>'Sponsors','icon'=>'fa-handshake','color'=>'bg-yellow-600','route'=>route('admin.sponsors.index',$event->id)],
        ['label'=>'Exhibitors','icon'=>'fa-store','color'=>'bg-rose-600','route'=>route('admin.exhibitors.index',$event->id)],
        ['label'=>'Communications','icon'=>'fa-envelope','color'=>'bg-violet-600','route'=>route('admin.communications.index',$event->id)],
        ['label'=>'Website','icon'=>'fa-globe','color'=>'bg-sky-600','route'=>route('admin.website.index',$event->id)],
        ['label'=>'Badges','icon'=>'fa-id-badge','color'=>'bg-emerald-600','route'=>route('admin.badges.index',$event->id)],
    ] @endphp
    @foreach($menus as $m)
    <a href="{{ $m['route'] }}" class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4 hover:shadow-md transition group">
        <div class="{{ $m['color'] }} w-10 h-10 rounded-xl flex items-center justify-center text-white group-hover:scale-110 transition-transform">
            <i class="fas {{ $m['icon'] }} text-sm"></i>
        </div>
        <span class="font-semibold text-gray-700">{{ $m['label'] }}</span>
        <i class="fas fa-chevron-right text-gray-300 ml-auto text-xs"></i>
    </a>
    @endforeach
</div>
@endsection
