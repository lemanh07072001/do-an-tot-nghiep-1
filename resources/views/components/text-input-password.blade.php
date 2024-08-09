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
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg {{ $classPadding }} focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error($attributes->get('name')) border-red-500 @enderror"
        {{ $attributes->merge(['class' => $classPadding, 'type' => 'text']) }} {{ $disabled ? 'disabled' : '' }} />
    <button tabindex="-1" type="button"
        data-hs-toggle-password='{
        "target": "#{{ $attributes->get('id') }}"
      }'
        class="absolute top-0 end-0 p-3.5 rounded-e-md">
        <svg class="flex-shrink-0 size-3.5 text-gray-400 dark:text-neutral-600" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <path class="hs-password-active:hidden" d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
            <path class="hs-password-active:hidden"
                d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
            <path class="hs-password-active:hidden"
                d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
            <line class="hs-password-active:hidden" x1="2" x2="22" y1="2" y2="22"></line>
            <path class="hidden hs-password-active:block" d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
            <circle class="hidden hs-password-active:block" cx="12" cy="12" r="3"></circle>
        </svg>
    </button>
</div>
