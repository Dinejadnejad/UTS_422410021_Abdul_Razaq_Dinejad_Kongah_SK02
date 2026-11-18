@props([
    'label',
    'name',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'step' => null,
])

<div>
    <label for="{{ $name }}" class="block text-xs font-medium text-slate-300 mb-1.5">
        {{ $label }} @if($required)<span class="text-rose-400">*</span>@endif
    </label>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        @if($step) step="{{ $step }}" @endif
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full rounded-lg bg-slate-950 border border-slate-700 px-3.5 py-2 text-sm text-slate-100 placeholder-slate-500 focus:border-indigo-500 focus:outline-none']) }}
    >
    @error($name)
        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
    @enderror
</div>