<x-app-layout>
    @section('title', config('apps.properties.titleCreate'))
    <div class="p-4 max-h-full block sm:flex items-center justify-between   dark:bg-gray-800 ">
        <div class="w-full mb-1">
            <div class="mb-4">
                {{ Breadcrumbs::render('propertiesCreate') }}
                <div class="flex items-center content-center">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white mr-2 ">@yield('title')
                    </h1>
                    <x-badges label="Hướng dẫn" type="primary" icon="{{ @svg('css-info', 'w-4 h-4') }}" />
                </div>
            </div>
        </div>


    </div>
    <x-card>
        <form method="POST" action="{{ route('ecommerce_module.properties.store') }}">
            @csrf
            <div class="grid grid-cols-6 gap-4 gap-y-4 ">

                <div class="col-span-6 sm:col-span-3 ">
                    <x-input-label for="name" required>Tên thuộc tính</x-input-label>
                    <x-text-input name="name" :value="old('name')" id="name" placeholder="Tên thuộc tính" />
                    <x-input-error error="name" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-input-label for="slug" required>Slug</x-input-label>
                    <x-text-input name="slug" :value="old('slug')" id="slug" />
                    <x-input-error error="slug" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-6">
                    <x-input-label for="value" >Thuộc tính</x-input-label>
                    <x-text-input name="value" :value="old('value') " id="value" placeholder="Thuộc tính"  />
                    <x-input-error error="value" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3 ">
                    <x-input-label required>Thuộc tính cha</x-input-label>
                    <x-select data-search="search-status" name="parent_id">
                        @if (\App\Enums\Status::getValues())
                            <option value="">--Root--</option>
                            {{\App\Helpers\GetData::showPropertiesSelect($getPropertiesSelect,old('parent_id'))}}
                        @endif
                    </x-select>
                    <x-input-error error="parent_id" class="mt-2" />
                </div>


                <div class="col-span-6 sm:col-span-3 ">
                    <x-input-label required>Trạng thái</x-input-label>
                    <x-select data-search="search-status" name="status">
                        @if (\App\Enums\Status::getValues())
                            <option disabled>--Chọn trạng thái--</option>
                            @foreach (\App\Enums\Status::getValues() as $status)
                                <option value="{{ $status }}">
                                    {{ \App\Enums\Status::getKey($status) }}</option>
                            @endforeach
                        @endif
                    </x-select>
                    <x-input-error error="status" class="mt-2" />
                </div>


                <div class="col-span-6 sm:col-span-6">
                    <div class="flex justify-end mt-3">
                        <button type="submit"
                            class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            Xác nhận
                        </button>
                        <a href="{{ route('ecommerce_module.properties.index') }}"
                            class="text-white bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            Quay lại
                        </a>
                    </div>
                </div>

            </div>


        </form>
    </x-card>

    @push('js')


        <script>
            $('#name').on('change', function() {
                let _this = $(this)

                ChangeToSlug(_this.val());
            })
        </script>

    @endpush
</x-app-layout>
