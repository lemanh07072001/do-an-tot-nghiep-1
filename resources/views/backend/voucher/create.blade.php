<x-app-layout>
    @section('title', config('apps.voucher.titleCreate'))
    <div class="p-4 max-h-full block sm:flex items-center justify-between   dark:bg-green-800 ">
        <div class="w-full mb-1">
            <div class="mb-4">
                {{ Breadcrumbs::render('voucherCreate') }}
                <div class="flex items-center content-center">
                    <h1 class="text-xl font-semibold text-green-900 sm:text-2xl dark:text-white mr-2 ">@yield('title')
                    </h1>
                    <x-badges label="Hướng dẫn" type="primary" icon="{{ @svg('css-info', 'w-4 h-4') }}" />
                </div>
            </div>
        </div>


    </div>
    <div>
        <form method="POST" action="{{ route('ecommerce_module.voucher.store') }}">
            @csrf
            <div class="grid grid-cols-12 ">
                <div class="col-span-4 ">
                    <div class="my-0 m-4">
                        <h5 class="mb-1 text-lg font-bold tracking-tight text-green-900 dark:text-white">Thông tin cơ
                            bản
                        </h5>
                        <p class="mb-3 text-xs text-green-700">Dưới đây là các thông tin chi tiết về voucher, bao gồm mã
                            voucher, loại giảm giá, giá trị giảm giá, thời gian hiệu lực, và điều kiện áp dụng.</p>
                    </div>
                </div>

                <div class="col-span-8 ">
                    <x-card class="my-0">

                        <div class="col-span-12 sm:col-span-3 ">
                            <div class="flex justify-between items-center">
                                <x-input-label for="name" class="items-center" required>
                                    <span>Tạo mã</span>
                                </x-input-label>
                                <span id="codeRandom" class="text-xs mb-2 cursor-pointer text-blue-400">Tạo mã tự
                                    động</span>
                            </div>
                            <x-text-input name="name" :value="old('name')" id="name" placeholder="Nhập mã" />
                            <x-input-error error="name" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-12 ">
                            <div class="col-span-2 pr-2">
                                <x-input-label for="discount_type" required>Loại giảm</x-input-label>
                                <x-select name="discount_type">
                                    <option value="vnd" @selected(old('discount_type') == 'vnd')>Vnd</option>
                                    <option value="%" @selected(old('discount_type') == '%')>%</option>
                                </x-select>
                            </div>
                            <div class="col-span-10 pl-2">
                                <x-input-label for="value_reduction" required>Giá trị giảm</x-input-label>
                                <x-text-input name="value_reduction" class="int" :value="old('value_reduction')"
                                    id="value_reduction" placeholder="Nhập giá trị" />
                                <x-input-error error="value_reduction" class="mt-2" />
                            </div>
                        </div>

                        <div class="col-span-6 sm:col-span-3 ">
                            <x-input-label for="limit">Lược sử dụng</x-input-label>
                            <x-text-input class="{{ old('limit') != '' ? '' : 'cursor-not-allowed disabled' }}"
                                type="number" name="limit" :value="old('limit')" id="limit" placeholder="---" />

                            <label class="inline-flex items-center  cursor-pointer mt-2">
                                <input type="checkbox" class="sr-only peer unlimited" @checked(old('limit') != '')>
                                <div
                                    class="relative w-9 h-5 bg-green-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-green-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600">
                                </div>
                                <span class="ms-3 text-sm font-medium text-green-900 dark:text-green-300">Đặt giới
                                    hạn</span>
                            </label>
                            <x-input-error error="limit" class="mt-2" />
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
                        <h5 class="mb-1 text-lg font-bold tracking-tight text-green-900 dark:text-white">Thời gian
                        </h5>
                        <p class="mb-3 text-xs text-green-700">Chọn thời gian áp dụng voucher</p>
                    </div>



                </div>


                <div class="col-span-8 ">
                    <x-card class="my-0">
                        <label class="inline-flex items-center  cursor-pointer">
                            <input id="time" name="time" type="checkbox" class="sr-only peer"
                                @checked(old('time') == 'on')>
                            <div
                                class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Không giới hạn thời
                                gian</span>
                        </label>

                        <div id="timeMain" class="{{ old('time') == 'on' ? 'hidden' : '' }}">
                            <div class="col-span-6 sm:col-span-3">
                                <x-input-label for="date_start">Ngày bắt đầu</x-input-label>
                                <div class="relative ">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input id="date_start" type="text" name="date_start" autocomplete="off"
                                        value="{{ old('date_start') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Chọn ngày">
                                </div>
                                <x-input-error error="date_start" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-3 mt-3">
                                <x-input-label for="date_end">Ngày kết thúc</x-input-label>
                                <div class="relative ">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input id="date_end" type="text" name="date_end" autocomplete="off"
                                        value="{{ old('date_end') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Chọn ngày">
                                </div>
                                <x-input-error error="date_end" class="mt-2" />
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
                        <a href="{{ route('ecommerce_module.voucher.index') }}"
                            class="text-white bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>



    @push('js')
        <script src="{{ asset('assets/apps/voucher/customVoucher.js') }}"></script>
        <script src="{{ asset('assets/apps/voucher/ajax.voucher.js') }}"></script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const $dateStartEl = document.getElementById('date_start');
                const $dateEndEl = document.getElementById('date_end');

                const options = {
                    defaultDatepickerId: null,
                    autohide: true,
                    format: 'dd/mm/yyyy',
                    maxDate: null,
                    minDate: null,
                    orientation: 'bottom',
                    buttons: true,
                    autoSelectToday: false,
                    title: "Flowbite datepicker",
                    rangePicker: false,
                    language: 'vi'

                };

                const dateStartEl = new Datepicker($dateStartEl, options);
                const dateEndEl = new Datepicker($dateEndEl, options);

            });
        </script>
        <script>
            $('#name').on('change', function() {
                let _this = $(this)

                ChangeToSlug(_this.val());
            })
        </script>
    @endpush
</x-app-layout>
