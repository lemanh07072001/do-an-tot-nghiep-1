@props(['messages'])

@if ($attributes->has('error'))
    @error($attributes->get('error'))
        <span {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}> {{ $message }}</span>
    @enderror
@endif
