@extends('client.layout.layoutMatter')

@php

@endphp


@section('content')
    <div class="mt-10" id="main-product-id" data-id="{{ $getFirstProduct->id }}">
        <div class="container max-w-[1170px] mx-auto   items-center h-full px-2.5 pb-6 ">
            <div class="grid grid-cols-1 lg:grid-cols-8">
                <div class="col-span-1 lg:col-span-4">
                    <div class="p-3 ">
                        <!-- Swiper 1 -->
                        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                            class="swiper mySwiper2 rounded-[15px] border-[1px] border-solid border-[#d1d5db] h-[400px] ">
                            <div class="swiper-wrapper">
                                @if (count($imageArray))
                                    @foreach ($imageArray as $image)
                                        <div class="swiper-slide flex justify-center items-center">
                                            <img src="{{ asset($image) }}" />
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div
                                class="swiper-button-next  bg-[#0000003d] right-0 rounded-s-full h-14 w-10 after:content-['next'] after:text-[20px]">
                            </div>
                            <div
                                class="swiper-button-prev  bg-[#0000003d] left-0 rounded-e-full h-14 w-10 after:content-['prev'] after:text-[20px]">
                            </div>
                        </div>
                        <!-- End Swiper 1 -->

                        <!-- Swiper 2 -->
                        <div thumbsSlider="" class="swiper mySwiper mt-3">
                            <div class="swiper-wrapper">
                                @if (count($imageArray))
                                    @foreach ($imageArray as $image)
                                        <div
                                            class="swiper-slide rounded-[15px] border-[1px] border-solid border-[#d1d5db] overflow-hidden">
                                            <img src="{{ asset($image) }}" />
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                        <!-- End Swiper 2 -->
                    </div>
                </div>

                <div class="col-span-1 lg:col-span-4">
                    <div class="p-3">
                        <h1 class="text-[25px] font-bold " id="title-product">{{ $getFirstProduct->name }}</h1>

                        <div class="flex items-center justify-between">
                            <span >Số lượng: ( <span id="quantity-title">0</span> )</span>
                            <span >SKU: <span id="sku-title">0</span></span>
                        </div> <!-- End Rating -->

                        <div class="bg-[#f2f2f2] mt-3 rounded-md">
                            <div class="p-3">
                                <span class="flex items-center">
                                    <span class="font-bold text-[24px] text-[#d00] mr-4">199.000 ₫</span>
                                    <span class="text-[16px] text-[#939393]">490.000 ₫</span>
                                    <span id="sale"
                                        class="text-[#fff] text-center text-sm bg-[#d40f0f] ml-2 p-1 rounded-md">-59%</span>
                                </span>
                            </div>
                        </div> <!-- End Price -->
                        @if (count($dataAttribute) > 0)
                            @foreach ($dataAttribute as $attr)
                                <div class="mt-3 attribute">
                                    <h2 class="font-bold text-md">{{ $attr['parent']['name'] }}:</h2>
                                    <div class="flex flex-wrap mt-2">
                                        @if (isset($attr['children']))
                                            @foreach ($attr['children'] as $element)
                                                @if (str_starts_with($element['value'], '#'))
                                                    <div class="block">
                                                        <div data-id="{{ $element['id'] }}"
                                                            class="attribute-style cursor-pointer border-solid w-10 h-10 border-[1px] mr-2 border-[{{ $element['value'] }}] bg-[{{ $element['value'] }}] rounded-lg shadow-[0_2px_3px_0_rgba(0,0,0,.15)]">
                                                        </div>
                                                    </div>
                                                @else
                                                    <span data-id="{{ $element['id'] }}"
                                                        class="attribute-style flex items-center justify-center uppercase border-solid w-10 h-10 border-[1px] mr-2 border-[#b7b7b7] cursor-pointer rounded-lg shadow-[0_2px_3px_0_rgba(0,0,0,.15)]">{{ $element['name'] }}</span>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif


                        <!-- Quantity -->
                        <div class="mt-3">
                            <h2 class="font-bold text-md">Chọn số lượng: <span class="ml-3">1</span></h2>
                            <div class="flex items-center mt-3">
                                <div class="relative flex items-center ">
                                    <button type="button" id="decrement-button"
                                        data-input-counter-decrement="counter-input"
                                        class="flex-shrink-0   hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-10 w-10 focus:ring-gray-100  focus:ring-2 focus:outline-none">
                                        <svg class="w-2.5 h-2.5 text-gray-900 " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M1 1h16" />
                                        </svg>
                                    </button>
                                    <input type="text" id="counter-input" data-input-counter
                                        class="flex-shrink-0 text-gray-900  border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center"
                                        placeholder="" value="12" required />
                                    <button type="button" id="increment-button"
                                        data-input-counter-increment="counter-input"
                                        class="flex-shrink-0  hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-10 w-10 focus:ring-gray-100  focus:ring-2 focus:outline-none">
                                        <svg class="w-2.5 h-2.5 text-gray-900 " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M9 1v16M1 9h16" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="flex-1  mx-10">
                                    <button type="button"
                                        class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 rounded-lg text-sm px-5 py-2.5 w-full font-bold  ">
                                        Thêm vào giỏ hàng
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- End Quantity -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        swiper('.slideBanner')
    </script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 10,
            slidesPerView: 6,
            freeMode: true,

            watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".mySwiper2", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            slideThumbActiveClass: 'active',
            thumbs: {
                swiper: swiper,
            },
        });
    </script>
    <script src="{{ asset('assets/client/js/effect.js') }}"></script>
    <script src="{{ asset('assets/client/js/detailProduct.js') }}"></script>
    <script src="{{ asset('assets/client/js/renderHTMLDetailProduct.js') }}"></script>




    <script>
        var getAttributeAjax = '{{ route('getAttributeAjax') }}'
    </script>
@endpush
