@props(['name', 'label', 'required' => false, 'value' => '', 'type' => 'text', 'placeholder' => ''])
<div>
<label for="{{ $name }}" class="mb-2 block text-sm font-bold text-slate-700">
{{ $label }}
@if($required)<span class="text-red-600">*</span>@endif
</label>
<input
type="{{ $type }}"
id="{{ $name }}"
name="{{ $name }}"
value="{{ $value }}"
placeholder="{{ $placeholder }}"
{{ $attributes->merge(['class' => 'w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm shadow-sm outline-none transition focus:border-orange-600 focus:ring-2 focus:ring-orange-200']) }}
>
</div>
