@extends('layouts.app')
@section('title', 'Sponsors — '.$event->name)
@section('content')
<div class="py-12" style="background: linear-gradient(135deg, {{ $event->website_primary_color ?? '#6366f1' }} 0%, #1e1b4b 100%)">
    <div class="max-w-5xl mx-auto px-4 text-center text-white">
        <a href="{{ route('event.show', $event->slug) }}" class="text-white/70 text-sm hover:text-white"><i class="fas fa-arrow-left mr-1"></i>{{ $event->name }}</a>
        <h1 class="text-4xl font-extrabold mt-2">Our Sponsors</h1>
        <p class="text-white/70 mt-2">Proud supporters of {{ $event->name }}</p>
    </div>
</div>
<section class="py-16 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4">
        @foreach(['platinum','gold','silver','bronze','partner'] as $tier)
            @php $tierSponsors = $sponsors->where('tier',$tier) @endphp
            @if($tierSponsors->count())
            <div class="mb-12">
                <h2 class="text-center text-lg font-bold uppercase tracking-widest mb-6
                    {{ $tier==='platinum'?'text-slate-600':($tier==='gold'?'text-yellow-600':($tier==='silver'?'text-gray-500':($tier==='bronze'?'text-orange-600':'text-blue-600'))) }}">{{ ucfirst($tier) }} Sponsors</h2>
                <div class="flex flex-wrap justify-center gap-6">
                    @foreach($tierSponsors as $s)
                    <div class="bg-white rounded-2xl shadow p-8 text-center {{ $tier==='platinum'?'min-w-64':($tier==='gold'?'min-w-48':'min-w-36') }} hover:shadow-lg transition">
                        <p class="font-bold text-xl">{{ $s->name }}</p>
                        @if($s->description)<p class="text-gray-400 text-sm mt-2">{{ $s->description }}</p>@endif
                        @if($s->website)<a href="{{ $s->website }}" target="_blank" class="text-indigo-600 text-sm hover:underline mt-2 inline-block">Visit website →</a>@endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach
        @if($sponsors->isEmpty())<div class="text-center py-20 text-gray-400"><i class="fas fa-handshake text-5xl mb-4 block"></i><p class="text-xl">Sponsor information coming soon.</p></div>@endif
    </div>
</section>
@endsection
