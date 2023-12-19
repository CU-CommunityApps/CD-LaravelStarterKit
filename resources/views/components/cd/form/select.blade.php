<x-cd.form.form-item field="{{ $name ?? $attributes->whereStartsWith('wire:model')->first() }}" 
        classes="{{ $classes ?? '' }}" 
        required="{{ $required ?? 0 }}"
>
    <x-slot name="field_title">{{ $label }}</x-slot>
    <select id="{{ $id ?? $name ?? $attributes->whereStartsWith('wire:model')->first() }}" 
            name="{{ $name ?? $attributes->whereStartsWith('wire:model')->first() }}"
        @if ($disabled??false)
            disabled
        @endif
        {{$attributes->whereStartsWith("wire:model")}}

    />
    @foreach ($options as $opt)
        <option value="{{$opt['value']}}" @if ($opt['disabled']??false) disabled="disabled" @endif >{{$opt['option']}}</option>
    @endforeach
    </select>
</x-cd.form.form-item>
