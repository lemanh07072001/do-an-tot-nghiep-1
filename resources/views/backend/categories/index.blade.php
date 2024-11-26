<x-app-layout>
    @section('title', config('apps.categories.titleIndex'))
    <div class="p-4 max-h-full bg-white block sm:flex items-center justify-between   dark:bg-gray-800 ">

        <div class="w-full mb-1">
            <div class="mb-4">
                {{ Breadcrumbs::render('categories') }}
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
                    {{--  <div>
                        <div>
                            <input placeholder="Excel Only" type="file" id="fileElem"
                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                style="display:none" />
                            <button id="fileSelect" type="button"
                                class="px-4 py-2 bg-lime-500 text-white font-semibold rounded-md hover:bg-lime-700 flex items-center">
                                @svg('fwb-o-file-import', 'w-4 h-4 me-2')
                                Import
                            </button>
                        </div>
                    </div>  --}}
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
                        @can('Thêm mới danh mục')
                            <a href={{ route('ecommerce_module.categories.create') }}
                                class="text-white bg-gradient-to-r focus:ring-blue-300 dark:focus:ring-blue-800 from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br  focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center ">
                                @svg('heroicon-o-plus', 'w-4 h-4 me-2')
                                Thêm mới dữ liệu
                            </a>
                        @endcan

                    </div>
                </div>

                <div class="flex items-center hidden" id="handleDelete">
                    <span class="me-2">Tổng: <span id="countUpdate">0</span></span>
                    @can('Xoá danh mục')
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

                            <x-table-col
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Tên danh mục
                            </x-table-col>

                            <x-table-col width="10%"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Danh mục
                            </x-table-col>

                            <x-table-col width="10%"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Sản phẩm
                            </x-table-col>

                            <x-table-col width="10%"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Người tạo
                            </x-table-col>

                            <x-table-col width="10%"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Trạng thái
                            </x-table-col>

                            <x-table-col width="15%"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Ngày tháng
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

        <div id="detaiProductCategories" tabindex="-1" aria-hidden="true"
            class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
            <div class="relative max-h-full w-full max-w-4xl">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between rounded-t border-b p-5 dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white lg:text-2xl">
                            Chi tiết sản phẩm
                        </h3>

                    </div>
                    <!-- Modal body -->
                    <div class="space-y-6 p-6">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700" id="listProduct">

                        </ul>

                        <input type="hidden" name="id" />

                    </div>

                    <div class="absolute inset-x-0 inset-y-0 bg-gray-400 opacity-80" id="loadingIndicator">
                        <div class="flex items-center justify-center w-full h-full ">
                            <div role="status">
                                <svg aria-hidden="true" class="w-10 h-10 text-gray-200 animate-spin fill-blue-600"
                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill" />
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('assets/apps/categories/datatables.js') }}"></script>
        <script src="{{ asset('assets/apps/categories/customCategories.js') }}"></script>

        <script>
            var detaiProductCategories = {{ Js::from(route('ecommerce_module.categories.detaiProductCategories')) }};
        </script>

        <script>
            var url = '{!! route('ecommerce_module.categories.getData') !!}'
            const columns = [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'detaiProductCategories'
                },
                {
                    data: 'count_product'
                },
                {
                    data: 'categories_id'
                },
                {
                    data: 'status'
                },
                {
                    data: 'datetime'
                },
                {
                    data: 'action'
                },
            ];

            const _CUSTOM_DATATABLES = {
                CLASS_ROW: '',
                PAGE: '8',
                TARGETS: [0, 1, 2, 3, 4, 5, 6, 7]

            };
            var dataTableIndex = initializeDataTable(url, columns, _CUSTOM_DATATABLES);

            //NOTE - Toggle Status
            var urlToggleStatus = '{!! route('ecommerce_module.categories.toggleStatus') !!}'
            toggleStatus(urlToggleStatus, dataTableIndex)

            //NOTE - Delete All
            var urlToggleStatus = '{!! route('ecommerce_module.categories.deleteAll') !!}'
            deleteAll(urlToggleStatus, dataTableIndex)

            //NOTE - Delete Row
            var urlToggleStatus = '{!! route('ecommerce_module.categories.deleteRow') !!}'
            deleteRow(urlToggleStatus, dataTableIndex)

            //NOTE - Export Table
            var urlExport = '{!! route('account_module.user.export') !!}'
            exportData(urlExport, dataTableIndex)

            //NOTE - Import Table
            var urlImport = '{!! route('account_module.user.import') !!}'
            importData(urlImport, dataTableIndex)
        </script>
    @endpush
</x-app-layout>
