@extends('layouts.admin')
@section('page-title','Access Codes')
@section('page-subtitle', $event->name)
@section('header-actions')
<a href="{{ route('admin.access-codes.create', $event->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 flex items-center gap-2">
    <i class="fas fa-plus"></i> Create Code
</a>
@endsection
@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Code</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Discount</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Max Uses</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Uses</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Expires</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Description</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
        @forelse($codes as $code)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3"><span class="font-mono font-bold text-indigo-700 bg-indigo-50 px-3 py-1 rounded-lg">{{ $code->code }}</span></td>
            <td class="px-4 py-3 font-semibold text-green-600">
                @if($code->discount_type === 'percentage'){{ $code->discount }}%@else${{ number_format($code->discount,2) }}@endif off
            </td>
            <td class="px-4 py-3 text-sm text-gray-500">{{ $code->max_uses ?? '∞' }}</td>
            <td class="px-4 py-3 text-sm text-gray-500">{{ $code->usages_count ?? 0 }}</td>
            <td class="px-4 py-3 text-sm text-gray-500">{{ $code->expires_at ? $code->expires_at->format('M d, Y') : 'Never' }}</td>
            <td class="px-4 py-3 text-sm text-gray-500">{{ $code->description ?? '—' }}</td>
            <td class="px-4 py-3 text-right">
                <form action="{{ route('admin.access-codes.destroy', [$event->id, $code->id]) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this code?')" class="text-red-500 hover:text-red-700 text-sm"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center py-12 text-gray-400"><i class="fas fa-key text-4xl mb-3 block"></i>No access codes yet. Create your first discount code.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection