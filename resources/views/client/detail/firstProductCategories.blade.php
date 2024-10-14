@extends('client.layout.layoutMatter')

@section('content')
    <!-- Break -->
    <section class="box-product" data-id-product="{{ !empty($firstCategories->id) ? $firstCategories->id : '' }}">
        <div class="container max-w-[1170px] mx-auto items-center h-full px-2.5 pt-6 ">
            <div class="grid md:grid-cols-1 lg:grid-cols-5 grid-cols-1">
                <div class="col-span-1 md:col-span-1 lg:col-span-3 mx-auto lg:m-0">
                    <nav class="flex items-center h-full w-full" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                            <li class="inline-flex items-center">
                                <a href="{{ route('index') }}"
                                    class="inline-flex items-center text-md font-medium text-gray-700 hover:text-[#ff5b26] ">
                                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                    </svg>
                                    Trang chủ
                                </a>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <span class="ms-1 text-md font-medium text-gray-500 md:ms-2">Danh mục :
                                        {{ !empty($firstCategories->name) ? $firstCategories->name : $title }}</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="col-span-1 mt-3 md:mt-3 lg:mt-0 md:col-span-1 lg:col-span-2 mx-auto lg:m-0">
                    <div class="flex items-center">
                        <p class="mr-3 text-gray-700 text-md hidden md:hidden lg:block">Hiển thị kết quả duy nhất</p>
                        <div>
                            <select id="sort-select"
                                class="block w-full p-2  text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-[#ff5b26] focus:border-[#ff5b26] ">
                                <option value="">Thứ tự mặc định</option>
                                <option value="0">Mới nhất</option>
                                <option value="1">Thấp đến cao</option>
                                <option value="2">Cao đến thấp</option>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End -->
    <!-- Box 1 -->
    <section class="py-5 ">
        <div class="container max-w-[1170px] mx-auto   items-center h-full px-2.5 pb-6">
            <div class="mt-3" data-aos="fade-right" data-aos-offset="10" data-aos-easing="ease-in-sine">
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 " id="product-list">

                </div>

            </div>

            <!-- Button See More -->
            <div class="w-full mt-6 flex justify-center hidden" id="load-more">
                <button type="button"
                    class="text-white bg-[#ff5b26] hover:bg-[#ff5b26] focus:ring-4 focus:outline-none focus:ring-[#ff5c2688] font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center ">
                    Xem thêm
                    <ion-icon class="ml-2" name="arrow-forward-outline"></ion-icon>
                </button>
            </div>
            <!-- End Button See More -->

    </section>
    <!-- End Box 1 -->
@endsection


@push('js')
    <script>
        var urlGetProduct = "{{ route('getProducts') }}"
    </script>
    <script src="{{ asset('assets/client/js/sortProductAjaxRender.js') }}"></script>
    <script src="{{ asset('assets/client/js/effect.js') }}"></script>
@endpush
