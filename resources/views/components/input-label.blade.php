<label
    {{ $attributes->merge(['class' => 'block mb-2 text-sm font-medium text-gray-900' . ($attributes['class'] ? $attributes['class'] : '')])->merge(['for' => 'small']) }}>
    {{ $slot }}
    @if ($attributes['required'] == true)
        <span class="text-red-600">
            (*)
        </span>
    @endif
</label>
