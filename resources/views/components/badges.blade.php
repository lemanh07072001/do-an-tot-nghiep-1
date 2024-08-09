@switch($attributes['type'])
    @case('error')
        <div>
            <span
                class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs fset ring-ront-medium text-red-700 ring-1 ring-ined-600/10">
                @if ($attributes->has('icon'))
                    {!! $attributes['icon'] !!}
                @endif
                <span class="ml-1">{{ $attributes['label'] }}</span>
            </span>
        </div>
    @break

    @case('warning')
        <div>
            <span
                class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-700 ring-1 ring-inset ring-yellow-700/10">
                @if ($attributes->has('icon'))
                    {!! $attributes['icon'] !!}
                @endif
                <span class="ml-1">{{ $attributes['label'] }}</span>
            </span>
        </div>
    @break

    @case('primary')
        <div>
            <span
                class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-pink-700/10">
                @if ($attributes->has('icon'))
                    {!! $attributes['icon'] !!}
                @endif
                <span class="ml-1">{{ $attributes['label'] }}</span>
            </span>
        </div>
    @break

    @case('pink')
        <div>
            <span
                class="inline-flex items-center rounded-md bg-pink-50 px-2 py-1 text-xs font-medium text-pink-700 ring-1 ring-inset ring-blue-700/10">
                @if ($attributes->has('icon'))
                    {!! $attributes['icon'] !!}
                @endif
                <span class="ml-1">{{ $attributes['label'] }}</span>
            </span>
        </div>
    @break

    {{--  Success  --}}

    @default
        <div class="flex">
            <span
                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-700/10">
                @if ($attributes->has('icon'))
                    {!! $attributes['icon'] !!}
                @endif
                <span class="ml-1">{{ $attributes['label'] }}</span>
            </span>
        </div>
@endswitch
