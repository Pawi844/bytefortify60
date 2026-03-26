@extends('layouts.admin')
@section('page-title','Edit Paper Field')
@section('page-subtitle', $event->name)
@section('content')
<div class="max-w-xl">
<div class="bg-white rounded-xl shadow-sm p-8">
<form action="{{ route('admin.paper-fields.update', [$event->id, $field->id]) }}" method="POST">
@csrf @method('PUT')
<div class="space-y-4">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Field Label *</label>
        <input type="text" name="label" value="{{ old('label', $field->label) }}" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Field Type *</label>
        <select name="field_type" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
            @foreach(['text'=>'Text Input','textarea'=>'Textarea','select'=>'Dropdown Select','checkbox'=>'Checkbox','radio'=>'Radio Buttons','file'=>'File Upload'] as $v=>$l)
            <option value="{{ $v }}" {{ old('field_type',$field->field_type)===$v?'selected':'' }}>{{ $l }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Options</label>
        <textarea name="options" rows="4" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">{{ old('options', $field->options) }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Help Text</label>
        <input type="text" name="help_text" value="{{ old('help_text', $field->help_text) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $field->sort_order) }}" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 outline-none">
    </div>
    <div class="flex items-center gap-2">
        <input type="hidden" name="is_required" value="0">
        <input type="checkbox" name="is_required" value="1" id="is_req" {{ $field->is_required?'checked':'' }} class="w-4 h-4 text-indigo-600">
        <label for="is_req" class="text-sm font-medium text-gray-700">Required field</label>
    </div>
</div>
<div class="flex gap-3 mt-6 justify-end">
    <a href="{{ route('admin.paper-fields.index', $event->id) }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</a>
    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium">Save Changes</button>
</div>
</form>
</div>
</div>
@endsection
