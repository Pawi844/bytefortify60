@extends('layouts.admin')
@section('page-title','Exhibitors')
@section('page-subtitle', $event->name)
@section('header-actions')
<a href="{{ route('admin.exhibitors.create', $event->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 flex items-center gap-2">
    <i class="fas fa-plus"></i> Add Exhibitor
</a>
@endsection
@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Company</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Booth</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Size</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Contact</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
        @forelse($exhibitors as $exhibitor)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3">
                <p class="font-medium">{{ $exhibitor->company_name }}</p>
                @if($exhibitor->description)<p class="text-gray-400 text-xs">{{ Str::limit($exhibitor->description, 60) }}</p>@endif
                @if($exhibitor->website)<a href="{{ $exhibitor->website }}" target="_blank" class="text-indigo-600 text-xs"><i class="fas fa-external-link-alt mr-1"></i>Website</a>@endif
            </td>
            <td class="px-4 py-3 text-sm font-mono">{{ $exhibitor->booth_number ?? '—' }}</td>
            <td class="px-4 py-3"><span class="text-xs px-2 py-0.5 bg-blue-50 text-blue-700 rounded-full">{{ ucfirst(str_replace('_',' ',$exhibitor->booth_size)) }}</span></td>
            <td class="px-4 py-3 text-sm">
                @if($exhibitor->contact_name)<p>{{ $exhibitor->contact_name }}</p>@endif
                @if($exhibitor->contact_email)<p class="text-gray-400 text-xs">{{ $exhibitor->contact_email }}</p>@endif
            </td>
            <td class="px-4 py-3 text-right">
                <a href="{{ route('admin.exhibitors.edit', [$event->id, $exhibitor->id]) }}" class="text-indigo-600 text-sm hover:underline mr-2"><i class="fas fa-edit mr-1"></i>Edit</a>
                <form action="{{ route('admin.exhibitors.destroy', [$event->id, $exhibitor->id]) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Remove exhibitor?')" class="text-red-500 text-sm hover:underline"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center py-16 text-gray-400">
            <i class="fas fa-store text-5xl mb-3 block"></i>
            <p class="text-lg font-semibold">No exhibitors yet</p>
            <a href="{{ route('admin.exhibitors.create', $event->id) }}" class="mt-3 inline-block bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">Add First Exhibitor</a>
        </td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection