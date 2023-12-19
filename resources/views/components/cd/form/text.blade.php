<x-cd.form.form-item field="{{ $name ?? $attributes->whereStartsWith('wire:model')->first() }}" 
        classes="{{ $classes ?? '' }}" 
        required="{{ $required ?? 0 }}"
>
    <x-slot name="field_title">{{ $label }}</x-slot>
    <input  type="{{$type??'text'}}" 
            id="{{ $id ?? $name ?? $attributes->whereStartsWith('wire:model')->first() }}" 
            name="{{ $name ?? $attributes->whereStartsWith('wire:model')->first() }}"
        {{-- type: can be text, number, date, datetime, datetime-local, month, week, time, range, color --}}
        class="{{$classes??''}}"   
        {{$attributes->only("min")}}
        {{$attributes->only("max")}}
        {{$attributes->only("step")}}
        {{$attributes->only("size")}}
        {{$attributes->whereStartsWIth('wire:model')}}
    />
</x-cd.form.form-item>
