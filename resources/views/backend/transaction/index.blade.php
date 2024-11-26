<x-app-layout>
    @section('title', config('apps.transaction.titleIndex'))
    <div class="p-4 max-h-full bg-white block sm:flex items-center justify-between   dark:bg-gray-800 ">

        <div class="w-full mb-1">
            <div class="mb-4">
                {{ Breadcrumbs::render('products') }}
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


                <div class="flex items-center hidden" id="handleDelete">
                    <span class="me-2">Tổng: <span id="countUpdate">0</span></span>
                    @can('Xuất kho')
                        <button type="button" id="exportData"
                            class="px-4 py-2 me-2 mb-2 bg-lime-500 text-white font-semibold rounded-md hover:bg-lime-700 flex items-center">
                            @svg('fwb-o-file-export', 'w-4 h-4 me-2')
                            Export
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
                                SKU
                            </x-table-col>

                            <x-table-col
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Tên sản phẩm
                            </x-table-col>

                            <x-table-col width="10%"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Số lượng
                            </x-table-col>

                            <x-table-col width="15%"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Số lượng đã bán
                            </x-table-col>

                            <x-table-col width="10%"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Giá bán
                            </x-table-col>

                            <x-table-col width="10%"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Giá khuyến mãi
                            </x-table-col>

                        </x-table-row>
                    </x-slot:thead>

                    <x-slot:tbody>

                    </x-slot:tbody>
                </x-table>


            </div>
        </div>

        <div id="editModal" tabindex="-1" aria-hidden="true"
            class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
            <div class="relative max-h-full w-full max-w-2xl">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between rounded-t border-b p-5 dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white lg:text-2xl">
                            Chi tiết số lượng sản phẩm
                        </h3>

                    </div>
                    <!-- Modal body -->
                    <div class="space-y-6 p-6">
                        <div class="col-span-6 sm:col-span-6 ">
                            <x-input-label for="name" required>Tên sản phẩm</x-input-label>
                            <x-text-input name="name" :value="old('name')" id="name" placeholder="Tên sản phẩm" />
                            <x-input-error error="name" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-6 ">
                            <x-input-label for="quantity" required>Số lượng</x-input-label>
                            <x-text-input name="quantity" :value="old('quantity')" id="quantity"
                                placeholder="Nhập số lượng" />
                            <div class="text-sm text-red-600 space-y-1 error"></div>
                        </div>

                        <div class="col-span-6 sm:col-span-6 ">
                            <x-input-label for="price_sale" required>Giá khuyến mãi</x-input-label>
                            <x-text-input class="int" name="price_sale" :value="old('price_sale')" id="price_sale"
                                placeholder="Nhập giá tiền" />
                            <div class="text-sm text-red-600 space-y-1 error"></div>
                        </div>

                        <input type="hidden" name="id" />

                    </div>
                    <!-- Modal footer -->
                    <div
                        class="flex items-center space-x-2 rtl:space-x-reverse rounded-b border-t border-gray-200 p-6 dark:border-gray-600">
                        <button type="button" id="btnSave"
                            class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Xác nhận
                        </button>

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
        <script src="{{ asset('assets/apps/transaction/datatables.js') }}"></script>
        <script src="{{ asset('assets/apps/transaction/customTransaction.js') }}"></script>

        <script>
            var getFindData = {{ Js::from(route('ecommerce_module.transaction.getTransactionById')) }};

            var exportTransaction = {{ Js::from(route('ecommerce_module.transaction.exportTransaction')) }};
        </script>
        <script>
            var url = '{!! route('ecommerce_module.transaction.getData') !!}'
            const columns = [{
                    data: 'id'
                },
                {
                    data: 'sku'
                },
                {
                    data: 'name'
                },
                {
                    data: 'quantity'
                },
                {
                    data: 'product_variants'
                },
                {
                    data: 'price'
                },
                {
                    data: 'price_sale'
                },

            ];

            const _CUSTOM_DATATABLES = {
                CLASS_ROW: '',
                PAGE: '15',
                TARGETS: [0, 1, 2, 3, 4, 5, 7, 8]

            };
            var dataTableIndex = initializeDataTable(url, columns, _CUSTOM_DATATABLES);

            //NOTE - Export Table
            var urlExport = '{!! route('ecommerce_module.transaction.exportTransaction') !!}'
            exportData(urlExport, dataTableIndex)
        </script>
    @endpush
</x-app-layout>
