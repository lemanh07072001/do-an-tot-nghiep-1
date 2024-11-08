<div
    class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:border-gray-700 sm:p-6 dark:bg-gray-800">
{{-- id="new-products-chart" --}}
    <div class="w-full items-center" >
        {!! $getUserData->container() !!}
    </div>

</div>

@push('js')
     <script src="{{ $getUserData->cdn() }}"></script>

     {{ $getUserData->script() }}
@endpush
