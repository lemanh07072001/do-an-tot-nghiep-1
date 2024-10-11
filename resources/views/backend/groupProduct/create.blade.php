<x-app-layout>
    @section('title', config('apps.groupProduct.titleCreate'))
    <div class="p-4 max-h-full block sm:flex items-center justify-between   dark:bg-gray-800 ">
        <div class="w-full mb-1">
            <div class="mb-4">
                {{ Breadcrumbs::render('groupProductCreate') }}
                <div class="flex items-center content-center">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white mr-2 ">@yield('title')
                    </h1>
                    <x-badges label="Hướng dẫn" type="primary" icon="{{ @svg('css-info', 'w-4 h-4') }}" />
                </div>
            </div>
        </div>


    </div>
    <div>
        <form method="POST" action="{{ route('ecommerce_module.groupProduct.store') }}">
            @csrf
            <div class="grid grid-cols-12 ">
                <div class="col-span-4 ">
                    <div class="my-0 m-4">
                        <h5 class="mb-1 text-lg font-bold tracking-tight text-green-900 dark:text-white">Thông tin cơ
                            bản
                        </h5>
                        <p class="mb-3 text-xs text-green-700">Dưới đây là các thông tin chi tiết về tên nhóm sản phẩm.
                        </p>
                    </div>
                </div>

                <div class="col-span-8 ">
                    <x-card class="my-0">

                        <div class="col-span-6 sm:col-span-3 ">
                            <x-input-label for="name" required>Tên nhóm sản phẩm</x-input-label>
                            <x-text-input name="name" :value="old('name')" id="name"
                                placeholder="Tên nhóm sản phẩm" />
                            <x-input-error error="name" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <x-input-label for="slug" required>Slug</x-input-label>
                            <x-text-input name="slug" :value="old('slug')" id="slug" />
                            <x-input-error error="slug" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-3 ">
                            <x-input-label required>Trạng thái</x-input-label>
                            <x-select data-search="search-status" name="status">
                                @if (\App\Enums\Status::getValues())
                                    <option disabled>--Chọn trạng thái--</option>
                                    @foreach (\App\Enums\Status::getValues() as $status)
                                    <option value="{{ $status }}" @selected(old('status') == $status)>
                                            {{ \App\Enums\Status::getKey($status) }}</option>
                                    @endforeach
                                @endif
                            </x-select>
                        </div>
                    </x-card>
                </div>
            </div>

            <div class="grid grid-cols-12 mt-4">
                <div class="col-span-4 ">
                    <div class="my-0 m-4">
                        <h5 class="mb-1 text-lg font-bold tracking-tight text-green-900 dark:text-white">Sản phẩm
                        </h5>
                        <p class="mb-3 text-xs text-green-700">Chọn sản phẩm mà muốn áp dụng</p>
                    </div>



                </div>

                <div class="col-span-8 ">
                    <x-card class="my-0">

                        <div class="relative w-full">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                                </svg>
                            </div>
                            <input type="text" id="simple-search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  block w-full ps-10 p-2.5  "
                                placeholder="Tìm kiếm theo tên, mã SKU,.."  />
                        </div>

                        <div id="main">
                            <div class="flow-root">
                                <ul role="list" id="listTable" class="divide-y divide-gray-200 dark:divide-gray-700">


                                </ul>
                            </div>
                        </div>
                    </x-card>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <div class="flex justify-end mt-3">
                        <button type="submit"
                            class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            <span class="saveBtn">Xác nhận</span>
                            <span class="loadingBtn" style="display: none">
                                <svg aria-hidden="true" role="status"
                                    class="inline w-4 h-4 me-3 text-gray-200 animate-spin dark:text-gray-600"
                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="#1C64F2" />
                                </svg>
                                Loading...
                            </span>
                        </button>
                        <a href="{{ route('ecommerce_module.groupProduct.index') }}"
                            class="text-white bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </form>
        <div id="modalEl" tabindex="-1" aria-hidden="true"
            class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
            <div class="relative max-h-full w-full max-w-2xl">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between rounded-t border-b p-5 dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white ">
                            Chọn sản phẩm
                        </h3>

                    </div>
                    <!-- Modal body -->
                    <div class="space-y-6 p-6">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                                </svg>
                            </div>
                            <input type="text" id="search-modal"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  block w-full ps-10 p-2.5  "
                                placeholder="Tìm kiếm theo tên, mã SKU,.."  />
                        </div>

                        <div class="flow-root h-96">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700" id="listModalProduct">


                            </ul>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div
                        class="flex justify-end space-x-2 rtl:space-x-reverse rounded-b border-t border-gray-200 p-6 dark:border-gray-600">
                        <button type="button" id="selectAllCheckBox"
                            class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Áp dụng
                        </button>

                    </div>

                    <div class="absolute inset-x-0 inset-y-0 bg-gray-400 opacity-80" id="loadingIndicator">
                        <div class="fixed top-0 left-0 z-50 w-screen h-screen flex items-center justify-center" style="background: rgba(0, 0, 0, 0.3);">
                            <div class="bg-white border py-2 px-5 rounded-lg flex items-center flex-col">
                              <div class="loader-dots block relative w-20 h-5 mt-2">
                                <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-green-500"></div>
                                <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-green-500"></div>
                                <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-green-500"></div>
                                <div class="absolute top-0 mt-1 w-3 h-3 rounded-full bg-green-500"></div>
                              </div>
                              <div class="text-gray-500 text-xs font-medium mt-2 text-center">
                                Loading...
                              </div>
                            </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
    <script>
          var routeGetAllProduct = {{ Js::from(route('ecommerce_module.groupProduct.getAllProducts')) }};
          var routeSearchProduct = {{ Js::from(route('ecommerce_module.groupProduct.searchProduct')) }};
          var hostUrl = "{{ env('APP_URL') }}";
    </script>
    <script src="{{ asset('assets/apps/groupProduct/customGroupProduct.js') }}"></script>
        <script>
            $('#name').on('change', function() {
                let _this = $(this)

                ChangeToSlug(_this.val());
            })
        </script>
    @endpush
</x-app-layout>
