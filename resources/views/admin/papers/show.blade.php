@extends('layouts.admin')
@section('page-title', Str::limit($paper->title, 50))
@section('page-subtitle', 'Paper Details & Peer Review')
@section('header-actions')
<a href="{{ route('admin.papers.reviews.create', [$event->id, $paper->id]) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700"><i class="fas fa-plus mr-1"></i>Add Review</a>
@endsection
@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-xl font-bold text-gray-800">{{ $paper->title }}</h2>
                <span class="px-2 py-0.5 rounded-full text-sm {{ $paper->status_badge }}">{{ ucfirst(str_replace('_',' ',$paper->status)) }}</span>
            </div>
            @if($paper->keywords)<p class="text-xs text-indigo-600 mb-3"><i class="fas fa-tags mr-1"></i>{{ $paper->keywords }}</p>@endif
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm font-semibold text-gray-500 mb-2">Abstract</p>
                <p class="text-gray-700 text-sm leading-relaxed">{{ $paper->abstract }}</p>
            </div>
            @if($paper->decision_comment)
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mt-4">
                <p class="text-sm font-semibold text-orange-700 mb-1"><i class="fas fa-comment mr-1"></i>Decision Comment (sent to author)</p>
                <p class="text-orange-700 text-sm">{{ $paper->decision_comment }}</p>
                @if($paper->decided_at)<p class="text-orange-400 text-xs mt-1">Decided {{ $paper->decided_at->format('M d, Y') }}</p>@endif
            </div>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-bold text-gray-700 mb-4">Peer Reviews ({{ $paper->reviews->count() }})</h3>
            @forelse($paper->reviews as $review)
            <div class="border border-gray-100 rounded-lg p-4 mb-3">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <p class="font-medium text-sm">{{ $review->reviewer?->first_name ?? 'Anonymous' }} {{ $review->reviewer?->last_name }}</p>
                        <p class="text-gray-400 text-xs">{{ $review->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="text-right">
                        <div class="flex items-center gap-1">
                            @for($i=1;$i<=10;$i++)
                            <div class="w-3 h-3 rounded-sm {{ $i <= $review->score ? 'bg-indigo-500' : 'bg-gray-200' }}"></div>
                            @endfor
                            <span class="text-xs font-bold ml-1">{{ $review->score }}/10</span>
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded-full mt-1 inline-block {{ $review->recommendation === 'accept' ? 'bg-green-100 text-green-700' : ($review->recommendation === 'reject' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst(str_replace('_',' ',$review->recommendation)) }}
                        </span>
                    </div>
                </div>
                <p class="text-gray-600 text-sm">{{ $review->comments }}</p>
            </div>
            @empty
            <p class="text-gray-400 text-sm">No reviews submitted yet. <a href="{{ route('admin.papers.reviews.create', [$event->id, $paper->id]) }}" class="text-indigo-600 hover:underline">Add the first review →</a></p>
            @endforelse
        </div>
    </div>

    <div class="space-y-4">
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="font-bold text-gray-700 mb-3">Author</h3>
            @if($paper->author)
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                    {{ strtoupper(substr($paper->author->first_name,0,1)) }}
                </div>
                <div>
                    <p class="font-medium text-sm">{{ $paper->author->first_name }} {{ $paper->author->last_name }}</p>
                    <p class="text-gray-400 text-xs">{{ $paper->author->email }}</p>
                </div>
            </div>
            @if($paper->author->organization)<p class="text-gray-500 text-xs"><i class="fas fa-building mr-1"></i>{{ $paper->author->organization }}</p>@endif
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="font-bold text-gray-700 mb-3">Assign Reviewer</h3>
            <form action="{{ route('admin.papers.assign-reviewer', [$event->id, $paper->id]) }}" method="POST">
                @csrf
                <select name="reviewer_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mb-2 outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Select reviewer...</option>
                    @foreach($reviewers as $r)
                    <option value="{{ $r->id }}">{{ $r->first_name }} {{ $r->last_name }}</option>
                    @endforeach
                </select>
                <button class="w-full bg-indigo-600 text-white py-2 rounded-lg text-sm hover:bg-indigo-700">Assign Reviewer</button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="font-bold text-gray-700 mb-3">Editorial Decision</h3>
            <form action="{{ route('admin.papers.decision', [$event->id, $paper->id]) }}" method="POST">
                @csrf
                <select name="status" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mb-2 outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <option value="">Choose decision...</option>
                    <option value="accepted">✅ Accept</option>
                    <option value="rejected">❌ Reject</option>
                    <option value="revision_requested">🔄 Request Revision</option>
                    <option value="under_review">🔍 Mark Under Review</option>
                </select>
                <textarea name="decision_comment" placeholder="Comment to send to author..." rows="3" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm mb-2 outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                <button class="w-full bg-emerald-600 text-white py-2 rounded-lg text-sm hover:bg-emerald-700">Submit Decision</button>
            </form>
        </div>
    </div>
</div>
@endsection