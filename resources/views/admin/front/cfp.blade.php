@extends('layouts.app')
@section('title', 'Submit Paper — '.$event->name)
@section('content')
<div class="py-12" style="background: linear-gradient(135deg, {{ $event->website_primary_color ?? '#6366f1' }} 0%, #1e1b4b 100%)">
    <div class="max-w-3xl mx-auto px-4 text-center text-white">
        <a href="{{ route('event.show', $event->slug) }}" class="text-white/70 text-sm hover:text-white"><i class="fas fa-arrow-left mr-1"></i>{{ $event->name }}</a>
        <h1 class="text-4xl font-extrabold mt-2">Call for Papers</h1>
        <p class="text-white/70 mt-2">Share your research and insights with the community</p>
    </div>
</div>
<div class="max-w-3xl mx-auto px-4 py-12">
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-5 mb-6 text-center">
        <i class="fas fa-check-circle text-3xl text-green-500 mb-2 block"></i>
        <p class="font-bold text-lg">{{ session('success') }}</p>
        <p class="text-gray-500 text-sm mt-1">You can track the status of your paper in the Attendee Portal.</p>
        <a href="{{ route('portal.login') }}" class="mt-3 inline-block bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 transition">Track Your Paper →</a>
    </div>
    @endif

    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-indigo-50 rounded-xl p-4 text-center"><i class="fas fa-edit text-indigo-600 text-2xl mb-2 block"></i><p class="font-semibold text-sm">Submit Paper</p><p class="text-gray-400 text-xs">Submit your abstract and paper details</p></div>
        <div class="bg-purple-50 rounded-xl p-4 text-center"><i class="fas fa-users text-purple-600 text-2xl mb-2 block"></i><p class="font-semibold text-sm">Peer Review</p><p class="text-gray-400 text-xs">Expert reviewers evaluate submissions</p></div>
        <div class="bg-green-50 rounded-xl p-4 text-center"><i class="fas fa-bell text-green-600 text-2xl mb-2 block"></i><p class="font-semibold text-sm">Get Notified</p><p class="text-gray-400 text-xs">Receive decision with reviewer feedback</p></div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-xl font-bold mb-6">Paper Submission Form</h2>
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-5">
            @foreach($errors->all() as $e)<p class="text-red-700 text-sm"><i class="fas fa-exclamation-circle mr-1"></i>{{ $e }}</p>@endforeach
        </div>
        @endif
        <form action="{{ route('event.cfp.submit', $event->slug) }}" method="POST">
            @csrf
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Paper Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Enter the full title of your paper">
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Author Name *</label>
                        <input type="text" name="author_name" value="{{ old('author_name') }}" required class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Full name">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Author Email *</label>
                        <input type="email" name="author_email" value="{{ old('author_email') }}" required class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="you@email.com">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Keywords</label>
                    <input type="text" name="keywords" value="{{ old('keywords') }}" class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="e.g. machine learning, cloud computing, security">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Abstract * <span class="text-gray-400 font-normal">(min. 100 characters)</span></label>
                    <textarea name="abstract" rows="6" required class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Provide a comprehensive abstract of your paper. Include the problem statement, methodology, key findings, and contributions...">{{ old('abstract') }}</textarea>
                </div>
                @foreach($fields as $field)
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">{{ $field->label }}{{ $field->is_required ? ' *' : '' }}</label>
                    @if($field->help_text)<p class="text-gray-400 text-xs mb-1">{{ $field->help_text }}</p>@endif
                    @if($field->field_type === 'textarea')
                    <textarea name="field_{{ $field->id }}" rows="4" {{ $field->is_required?'required':'' }} class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none">{{ old('field_'.$field->id) }}</textarea>
                    @elseif($field->field_type === 'select')
                    <select name="field_{{ $field->id }}" {{ $field->is_required?'required':'' }} class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option value="">Select...</option>
                        @foreach(explode('\n', $field->options ?? '') as $opt)<option value="{{ trim($opt) }}">{{ trim($opt) }}</option>@endforeach
                    </select>
                    @else
                    <input type="text" name="field_{{ $field->id }}" value="{{ old('field_'.$field->id) }}" {{ $field->is_required?'required':'' }} class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none">
                    @endif
                </div>
                @endforeach
            </div>
            <div class="mt-8">
                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl hover:bg-indigo-700 transition text-lg">
                    <i class="fas fa-paper-plane mr-2"></i>Submit Paper
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
