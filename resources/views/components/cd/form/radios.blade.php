<x-cd.form.form-item field="{{ $name ?? $attributes->whereStartsWith('wire:model')->first() }}" 
        classes="{{ $classes ?? '' }}" 
        required="{{ $required ?? 0 }}"
>
    <x-slot name="field_title">{{ $label }}</x-slot>
    <div class="flex-grid compact-rows">
    @foreach ($radiobuttons as $rad) 
        <div class="form-item">
            <input type="radio" id="{{$field}}-{{$loop->index}}" name="{{ $field }}" value="{{ $rad["value"]}}" {{ $attributes->whereStartsWith('wire:model') }}>
            <label class="option-label" for="{{$field}}-{{$loop->index}}">{{$rad["label"]}}</label>
        </div>
    @endforeach
    </div>
</x-cd.form.form-item>