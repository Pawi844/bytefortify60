@extends('layouts.admin')
@section('page-title','Paper Fields')
@section('page-subtitle', 'Custom CFP submission fields for '.$event->name)
@section('header-actions')
<a href="{{ route('admin.paper-fields.create', $event->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 flex items-center gap-2">
    <i class="fas fa-plus"></i> Add Field
</a>
@endsection
@section('content')
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Order</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Label</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Required</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
        @forelse($fields as $field)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-3 text-sm text-gray-400">{{ $field->sort_order }}</td>
            <td class="px-4 py-3 font-medium text-sm">{{ $field->label }}
                @if($field->help_text)<p class="text-gray-400 text-xs">{{ $field->help_text }}</p>@endif
            </td>
            <td class="px-4 py-3"><span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-xs capitalize">{{ $field->field_type }}</span></td>
            <td class="px-4 py-3">@if($field->is_required)<span class="text-green-600 text-xs font-semibold">Yes</span>@else<span class="text-gray-300 text-xs">No</span>@endif</td>
            <td class="px-4 py-3 text-right">
                <a href="{{ route('admin.paper-fields.edit', [$event->id, $field->id]) }}" class="text-indigo-600 text-sm mr-2"><i class="fas fa-edit"></i></a>
                <form action="{{ route('admin.paper-fields.destroy', [$event->id, $field->id]) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Delete?')" class="text-red-500 text-sm"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center py-12 text-gray-400"><i class="fas fa-list-ul text-4xl mb-3 block"></i>No custom fields. Add fields to collect extra data on paper submissions.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
