@props(['name', 'label', 'type' => 'text', 'required' => false, 'placeholder' => '', 'value' => ''])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-semibold text-slate-700 mb-2">
        {{ $label }}
        @if ($required)
            <span class="text-red-600">*</span>
        @endif
    </label>
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        @if ($required) required @endif
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge(['class' => 'w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500']) }}
    />
    @error($name)
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
