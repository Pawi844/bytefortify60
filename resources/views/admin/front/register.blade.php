@extends('layouts.app')
@section('title', 'Register — '.$event->name)
@section('content')

<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-2xl mx-auto px-4">
        <div class="text-center mb-8">
            <a href="{{ route('event.show', $event->slug) }}" class="text-indigo-600 text-sm hover:underline"><i class="fas fa-arrow-left mr-1"></i>Back to {{ $event->name }}</a>
            <h1 class="text-3xl font-extrabold mt-3 mb-1">Register for {{ $event->name }}</h1>
            <p class="text-gray-500"><i class="far fa-calendar mr-1"></i>{{ $event->start_date->format('M d, Y') }} · {{ $event->venue }}</p>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 mb-6 text-center">
            <i class="fas fa-check-circle text-2xl mb-2 block text-green-500"></i>
            <p class="font-bold">{{ session('success') }}</p>
            <a href="{{ route('portal.login') }}" class="mt-3 inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">Access Attendee Portal →</a>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            {{-- Ticket Select --}}
            <div class="p-6 border-b border-gray-100">
                <h2 class="font-bold text-lg mb-4"><span class="text-indigo-600 mr-2">①</span>Choose Your Ticket</h2>
                <div class="grid gap-3" id="ticket-options">
                    @forelse($tickets as $i => $ticket)
                    <label class="flex items-center gap-4 p-4 border-2 rounded-xl cursor-pointer transition hover:border-indigo-300 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50">
                        <input type="radio" name="ticket_select" value="{{ $ticket->id }}" class="ticket-radio w-4 h-4 text-indigo-600" {{ $i===0?'checked':'' }}>
                        <div class="flex-1">
                            <p class="font-semibold">{{ $ticket->name }}</p>
                            @if($ticket->description)<p class="text-gray-400 text-sm">{{ $ticket->description }}</p>@endif
                        </div>
                        <div class="text-right">
                            <p class="font-black text-xl {{ $ticket->price > 0 ? 'text-indigo-700' : 'text-green-600' }}">{{ $ticket->price > 0 ? '$'.number_format($ticket->price,2) : 'Free' }}</p>
                            @if($ticket->quantity)<p class="text-gray-400 text-xs">{{ $ticket->remaining }} remaining</p>@endif
                        </div>
                    </label>
                    @empty
                    <p class="text-gray-400 text-center py-4">No tickets available for this event yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Registration Form --}}
            <form action="{{ route('event.register.store', $event->slug) }}" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="ticket_id" id="ticket_id" value="{{ $tickets->first()?->id }}">

                <h2 class="font-bold text-lg mb-4"><span class="text-indigo-600 mr-2">②</span>Your Details</h2>

                @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4">
                    @foreach($errors->all() as $error)
                    <p class="text-red-700 text-sm"><i class="fas fa-exclamation-circle mr-1"></i>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">First Name *</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Jane">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Last Name *</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Smith">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="jane@company.com">
                        <p class="text-gray-400 text-xs mt-1">Your portal login will use this email address.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="+1 555 000 0000">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Organization</label>
                        <input type="text" name="organization" value="{{ old('organization') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Acme Inc.">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Job Title</label>
                        <input type="text" name="job_title" value="{{ old('job_title') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Software Engineer">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Dietary Requirements</label>
                        <input type="text" name="dietary" value="{{ old('dietary') }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="e.g. Vegetarian, Gluten-free, None">
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-100">
                    <div id="price-summary" class="flex justify-between items-center mb-4">
                        <span class="font-semibold text-gray-700">Total</span>
                        <span class="text-2xl font-black text-indigo-700" id="price-display">{{ $tickets->first() ? ($tickets->first()->price > 0 ? '$'.number_format($tickets->first()->price,2) : 'Free') : '$0.00' }}</span>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl hover:bg-indigo-700 transition text-lg shadow-lg">
                        <i class="fas fa-lock mr-2"></i>Complete Registration
                    </button>
                    <p class="text-center text-gray-400 text-xs mt-3">By registering you agree to the event terms and conditions.</p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const tickets = @json($tickets->keyBy('id'));
document.querySelectorAll('.ticket-radio').forEach(radio => {
    radio.addEventListener('change', () => {
        document.getElementById('ticket_id').value = radio.value;
        const t = tickets[radio.value];
        document.getElementById('price-display').textContent = t.price > 0 ? '$' + parseFloat(t.price).toFixed(2) : 'Free';
    });
});
</script>
@endsection