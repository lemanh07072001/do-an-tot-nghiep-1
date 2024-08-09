<select
    {{ $attributes->class([
            'select2 block w-full ',
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
