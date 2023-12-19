<x-cd.form.form-item field="{{ $name ?? $attributes->whereStartsWith('wire:model')->first() }}" 
        classes="{{ $classes ?? '' }}" 
        required="{{ $required ?? 0 }}"
>
@php 
  $field=$name ?? $attributes->whereStartsWith('wire:model')->first();
@endphp
    <x-slot name="field_title">{{ $label }}</x-slot>
    <div class="flex-grid compact-rows">
    @foreach ($checkboxes as $cb) 
        <div class="form-item">
            <input type="checkbox" id="{{$field}}-{{$loop->index}}" name="{{ $field }}" value="{{ $cb['value']}}" {{ $attributes->whereStartsWith('wire:model') }}>
            <label class="option-label" for="{{$field}}-{{$loop->index}}">{{$cb["label"]}}</label>
        </div>
    @endforeach
    </div>
</x-cd.form.form-item>