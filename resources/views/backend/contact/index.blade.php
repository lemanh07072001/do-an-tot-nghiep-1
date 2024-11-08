<x-app-layout>
    @section('title', config('apps.contact.titleIndex'))
    <div class="p-4 max-h-full bg-white block sm:flex items-center justify-between   dark:bg-gray-800 ">

        <div class="w-full mb-1">
            <div class="mb-4">

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
                    <button type="button" id="data-delete"
                        class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                        Xóa tất cả
                    </button>
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
                                Thông tin
                            </x-table-col>

                            <x-table-col width="45%"
                                class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                Tin nhắn
                            </x-table-col>

                            <x-table-col width="15%"
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
        @include('backend.contact.modalMessage')
    </div>



    @push('js')
        <script src="{{ asset('assets/apps/contact/datatables.js') }}"></script>
        <script src="{{ asset('assets/apps/contact/customContact.js') }}"></script>

        <script>
            let routeGetMessage =  {{ Js::from(route('setting_module.contact.getMessage')) }};
            let routeSendMessage =  {{ Js::from(route('setting_module.contact.sendMessage')) }};
        </script>

        <script>
            var url = '{!! route('setting_module.contact.getData') !!}'
            const columns = [{
                    data: 'id'
                },
                {
                    data: 'info'
                },
                {
                    data: 'message'
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
                TARGETS: [0, 1, 2]

            };
            var dataTableIndex = initializeDataTable(url, columns, _CUSTOM_DATATABLES);


            //NOTE - Delete All
            var urlToggleStatus = '{!! route('setting_module.contact.deleteAll') !!}'
            deleteAll(urlToggleStatus, dataTableIndex)

            //NOTE - Delete Row
            var urlToggleStatus = '{!! route('setting_module.contact.deleteRow') !!}'
            deleteRow(urlToggleStatus, dataTableIndex)
        </script>
    @endpush
</x-app-layout>
