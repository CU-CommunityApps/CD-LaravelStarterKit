<x-cd.form.form-item field="{{ $name ?? $attributes->whereStartsWith('wire:model')->first() }}" 
        classes="{{ $classes ?? '' }}" 
        required="{{ $required ?? 0 }}"
        description="{{ $description ?? ''}}"

>
    <x-slot name="field_title">{{ $label }}</x-slot>
    <div class="form-item">
        <input type="checkbox" id="{{ $id ?? $name ?? $attributes->whereStartsWith('wire:model')->first() }}" 
            name="{{ $name ?? $attributes->whereStartsWith('wire:model')->first() }}"
            value="{{ $value }}" 
            {{ $attributes->whereStartsWith('wire:model') }}
            {{ $attributes->whereStartsWIth('aria')  }}
        />
        <label class="option-label" for="{{$field}}">{{$label}}</label>
    </div>
</x-cd.form.form-item>