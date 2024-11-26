<select
    {{ $attributes->class([
            ' bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ',
            'border-red-500' => $errors->has($attributes->get('name')),
        ])->merge() }} data="{{$attributes->get('name')}}">
    {{ $slot }}
</select>

<style>
    .nice-select,
    .nice-select .list {
        width: 100% !important;
    }
</style>
