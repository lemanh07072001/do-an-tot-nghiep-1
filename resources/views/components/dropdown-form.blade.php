@props(['button', 'subDropdown'])



<div {{ $attributes->merge(['class' => 'relative']) }}>

    @if ($button->attributes->has('icon'))
        <button data-dropdown-toggle="{{ $button->attributes->get('id') }}"
            class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center ">
            @svg($button->attributes->get('icon'), 'w-4 h-4 me-2')
            {{ $button }}
        </button>
    @endif


    <!-- Dropdown menu -->

    <div id="{{ $button->attributes->get('id') }}"
        {{ $subDropdown->attributes->class(['z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow  dark:bg-white-700 absolute p-4 ' . ($attributes['class'] ? $attributes['class'] : '')]) }}>
        {{ $subDropdown }}
    </div>
</div>
