@props(['disabled' => false])



@php
    $iconClass = $attributes->has('icon') ? 'relative' : '';
    $classPadding = $attributes->has('icon') ? 'ps-10' : 'p-2.5';
@endphp

<div class="{{ $iconClass }}">
    @if ($attributes->has('icon'))
        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
            @svg($attributes->get('icon'), 'w-4 h-4')

        </div>
    @endif
    <input
        class="{{ $attributes->get('class') }} bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg {{ $classPadding }}  focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error($attributes->get('name')) border-red-500 @enderror"
        {{ $attributes->merge(['class' => $classPadding, 'type' => 'text']) }} {{ $disabled ? 'disabled' : '' }} />



</div>
