<x-app-layout>
    @section('title', config('apps.banner.titleIndex'))
    <div class="p-4 max-h-full bg-white block sm:flex items-center justify-between   dark:bg-gray-800 ">

        <div class="w-full mb-1">
            <div class="mb-4">
                {{ Breadcrumbs::render('banner') }}
                <div class="flex items-center content-center">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white mr-2 ">@yield('title')
                    </h1>
                    <x-badges label="Hướng dẫn" type="primary" icon="{{ @svg('css-info', 'w-4 h-4') }}" />
                </div>
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <form class="sm:pr-3" action="#" method="GET">
                        <label for="products-search" class="sr-only">Search</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <input type="text" name="email" data-search="search-input"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Nhập từ khóa tìm kiếm">
                        </div>
                    </form>

                </div>

                <div class="flex items-center" id="handleAdd">

                    <div class="flex pl-2 space-x-1 mr-2">
                        <x-dropdown-form>
                            <x-slot:button id="dropdownFind" icon="iconoir-filter-solid">
                                Tìm kiếm
                            </x-slot:button>

                            <x-slot:subDropdown class="w-60">
                                <div class="p-1">
                                    <x-input-label required>Trạng thái</x-input-label>
                                    <x-select data-search="search-status">
                                        @if (\App\Enums\Status::getValues())
                                            <option value="">--Chọn trạng thái--</option>
                                            @foreach (\App\Enums\Status::getValues() as $status)
                                                <option value="{{ $status }}">
                                                    {{ \App\Enums\Status::getKey($status) }}</option>
                                            @endforeach
                                        @endif
                                    </x-select>
                                </div>

                                <div class="p-1 mt-2">
                                    <x-input-label required>Người tạo</x-input-label>
                                    <x-select data-search="search-user">
                                        @if (\App\Enums\Status::getValues())
                                            <option value="">--Chọn người tạo--</option>
                                            @foreach ($getAllUsersSelect as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </x-select>
                                </div>
                            </x-slot:subDropdown>
                        </x-dropdown-form>
                    </div>
                    <div>
                        @can('Thêm mới banner')
                            <a href={{ route('ecommerce_module.banner.create') }}
                            class="text-white bg-gradient-to-r focus:ring-blue-300 dark:focus:ring-blue-800 from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br  focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center ">
                            @svg('heroicon-o-plus', 'w-4 h-4 me-2')
                            Thêm mới dữ liệu
                        </a>
                        @endcan

                    </div>
                </div>

                <div class="flex items-center hidden" id="handleDelete">
                    <span class="me-2">Tổng: <span id="countUpdate">0</span></span>
                    @can('Xoá banner')
                        <button type="button" id="data-delete"
                        class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                        Xóa tất cả
                    </button>
                    @endcan
                </div>
            </div>
        </div>


    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">

                <x-table id="dataTables">
                    <x-slot:thead>
                        <x-table-row>
                            <x-table-col width="5%" class="p-4">
                                <div class="flex items-center">
                                    <input aria-describedby="checkbox-1" type="checkbox" id="selectAll"
                                        class="checkbox w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all" class="sr-only">checkbox</label>
                                </div>
                            </x-table-col>

                            <x-table-col width="15%"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Hình ảnh
                            </x-table-col>

                            <x-table-col width="15%"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Tiêu đề
                            </x-table-col>

                            <x-table-col width="20%"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Link
                            </x-table-col>

                            <x-table-col scope="col"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Thời gian giảm giá
                            </x-table-col>

                            <x-table-col width="10%"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Người tạo
                            </x-table-col>

                            <x-table-col width="10%"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Trạng thái
                            </x-table-col>

                            <x-table-col width="10%"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Hoạt động
                            </x-table-col>
                        </x-table-row>
                    </x-slot:thead>

                    <x-slot:tbody>

                    </x-slot:tbody>
                </x-table>


            </div>
        </div>
    </div>

    @push('js')
        <script src="{{asset('assets/apps/banners/datatables.js')}}"></script>

        <script>

            var url = '{!! route('ecommerce_module.banner.getData') !!}'
            const columns = [{
                    data: 'id'
                },
                {
                    data: 'image'
                },
                {
                    data: 'name'
                },
                {
                    data: 'link'
                },
                {
                    data: 'discount_period'
                },
                {
                    data: 'user_id'
                },
                {
                    data: 'status'
                },
                {
                    data: 'action'
                },
            ];

            const _CUSTOM_DATATABLES = {
                CLASS_ROW: '',
                PAGE: '8',
                TARGETS: [0, 1, 2, 3, 4, 5, 6]

            };
            var dataTableIndex = initializeDataTable(url, columns, _CUSTOM_DATATABLES);

            //NOTE - Toggle Status
            var urlToggleStatus = '{!! route('ecommerce_module.banner.toggleStatus') !!}'
            toggleStatus(urlToggleStatus, dataTableIndex)

            //NOTE - Delete All
            var urlToggleStatus = '{!! route('ecommerce_module.banner.deleteAll') !!}'
            deleteAll(urlToggleStatus, dataTableIndex)

            //NOTE - Delete Row
            var urlToggleStatus = '{!! route('ecommerce_module.banner.deleteRow') !!}'
            deleteRow(urlToggleStatus, dataTableIndex)
        </script>
    @endpush
</x-app-layout>
