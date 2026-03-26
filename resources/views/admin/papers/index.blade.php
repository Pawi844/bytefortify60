@extends('layouts.admin')
@section('page-title','Papers (CFP)')
@section('page-subtitle', $event->name)
@section('content')
<div class="flex gap-2 mb-4 flex-wrap">
    @foreach([''=>'All','submitted'=>'Submitted','under_review'=>'Under Review','accepted'=>'Accepted','rejected'=>'Rejected','revision_requested'=>'Needs Revision'] as $val => $label)
    <a href="{{ request()->fullUrlWithQuery(['status'=>$val]) }}" class="px-3 py-1.5 rounded-lg text-sm {{ $status === $val ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50 border' }}">{{ $label }}</a>
    @endforeach
</div>
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Title</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Author</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Reviews</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Submitted</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
        @forelse($papers as $paper)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3">
                <p class="font-medium text-sm">{{ Str::limit($paper->title, 60) }}</p>
                @if($paper->keywords)<p class="text-gray-400 text-xs">{{ $paper->keywords }}</p>@endif
            </td>
            <td class="px-4 py-3 text-sm">{{ $paper->author?->first_name }} {{ $paper->author?->last_name }}</td>
            <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $paper->status_badge }}">{{ ucfirst(str_replace('_',' ',$paper->status)) }}</span></td>
            <td class="px-4 py-3 text-sm text-center">
                <span class="inline-flex items-center gap-1">
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    {{ $paper->reviews->count() }}
                </span>
            </td>
            <td class="px-4 py-3 text-sm text-gray-400">{{ $paper->created_at->format('M d, Y') }}</td>
            <td class="px-4 py-3 text-right">
                <a href="{{ route('admin.papers.show', [$event->id, $paper->id]) }}" class="text-indigo-600 text-sm hover:underline mr-2"><i class="fas fa-eye mr-1"></i>Review</a>
                <form action="{{ route('admin.papers.destroy', [$event->id, $paper->id]) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Delete this paper?')" class="text-red-500 text-sm hover:underline"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center py-16 text-gray-400">
            <i class="fas fa-file-alt text-5xl mb-3 block"></i>
            <p class="text-lg font-semibold">No papers submitted yet</p>
            <p class="text-sm">Papers submitted via the public CFP form will appear here.</p>
        </td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $papers->links() }}</div>
@endsection