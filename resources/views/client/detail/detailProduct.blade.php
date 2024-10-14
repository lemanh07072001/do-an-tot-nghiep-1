@extends('client.layout.layoutMatter')

@section('content')
    <div class="mt-10">
          <div class="container max-w-[1170px] mx-auto   items-center h-full px-2.5 pb-6 ">
            <div class="grid grid-cols-1 lg:grid-cols-8">
              <div class="col-span-1 lg:col-span-4">
                <div class="p-3 ">
                  <!-- Swiper 1 -->
                  <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                    class="swiper mySwiper2 rounded-[15px] border-[1px] border-solid border-[#d1d5db] h-[400px] ">
                    <div class="swiper-wrapper">
                      <div class="swiper-slide flex justify-center items-center">
                        <img
                          src="/src/images/products/akst283-3l__2__50dc065939824d86a11c9139f5f21b70_master-300x300.jpg" />
                      </div>

                      <div class="swiper-slide flex justify-center items-center">
                        <img class="bg-transparent"
                          src="/src/images/products/S73d069b2083d41dfb3af752095b00a97V-300x300.jpg" />
                      </div>

                      <div class="swiper-slide flex justify-center items-center">
                        <img class="bg-transparent" src="/src/images/products/Untitled-design-13.png" />
                      </div>

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
                      <div
                        class="swiper-slide rounded-[15px] border-[1px] border-solid border-[#d1d5db] overflow-hidden">
                        <img
                          src="/src/images/products/akst283-3l__2__50dc065939824d86a11c9139f5f21b70_master-300x300.jpg" />
                      </div>
                      <div
                        class="swiper-slide rounded-[15px] border-[1px] border-solid border-[#d1d5db] overflow-hidden">
                        <img
                          src="/src/images/products/akst283-3l__2__50dc065939824d86a11c9139f5f21b70_master-300x300.jpg" />
                      </div>

                      <div
                        class="swiper-slide rounded-[15px] border-[1px] border-solid border-[#d1d5db] overflow-hidden">
                        <img class="bg-transparent"
                          src="/src/images/products/S73d069b2083d41dfb3af752095b00a97V-300x300.jpg" />
                      </div>
                    </div>
                  </div>
                  <!-- End Swiper 2 -->
                </div>
              </div>

              <div class="col-span-1 lg:col-span-4">
                <div class="p-3">
                  <h1 class="text-[25px] font-bold">Quần ngắn Li-Ning Sport</h1>
                  <!-- Raating -->
                  <div class="flex items-center">
                    <svg class="w-4 h-4 text-yellow-300 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                      fill="currentColor" viewBox="0 0 22 20">
                      <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="w-4 h-4 text-yellow-300 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                      fill="currentColor" viewBox="0 0 22 20">
                      <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="w-4 h-4 text-yellow-300 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                      fill="currentColor" viewBox="0 0 22 20">
                      <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="w-4 h-4 text-yellow-300 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                      fill="currentColor" viewBox="0 0 22 20">
                      <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    <svg class="w-4 h-4  text-yellow-300 ms-1 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                      fill="currentColor" viewBox="0 0 22 20">
                      <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>

                    <span class="ml-3 text-sm text-[#212529]">(<span>70</span> Đánh giá )</span>
                  </div>
                  <!-- End Rating -->

                  <!-- Price -->
                  <div class="bg-[#f2f2f2] mt-3 rounded-md">
                    <div class="p-3">
                      <span class="flex items-center">
                        <span class="font-bold text-[24px] text-[#d00] mr-4">199.000 ₫</span>
                        <span class="text-[16px] text-[#939393]">490.000 ₫</span>

                        <span id="sale" class="text-[#fff] text-center text-sm bg-[#d40f0f] ml-2 p-1 rounded-md">
                          -59%
                        </span>
                      </span>
                    </div>
                  </div>
                  <!-- End Price -->

                  <!-- Color -->
                  <div class="mt-3">
                    <h2 class="font-bold text-md">Màu sắc:</h2>
                    <div class="flex flex-wrap mt-2">
                      <a href="#" class="block">
                        <div
                          class="border-solid w-10 h-10 border-[1px] mr-2 border-[#b7b7b7] bg-[#b7b7b7] rounded-lg shadow-[0_2px_3px_0_rgba(0,0,0,.15)]">
                        </div>
                      </a>

                      <a href="#" class="block">
                        <div
                          class="border-solid w-10 h-10 border-[1px] mr-2 border-[#3FEEBB] bg-[#3FEEBB] rounded-lg shadow-[0_2px_3px_0_rgba(0,0,0,.15)]">
                        </div>
                      </a>

                      <a href="#" class="block">
                        <div
                          class="border-solid w-10 h-10 border-[1px] mr-2 last:mr-0 border-[#EDFF59] bg-[#EDFF59] rounded-lg shadow-[0_2px_3px_0_rgba(0,0,0,.15)]">
                        </div>
                      </a>
                    </div>
                  </div>
                  <!-- End Color -->

                  <!-- Size -->
                  <div class="mt-3">
                    <h2 class="font-bold text-md">Kích cỡ:</h2>
                    <div class="flex flex-wrap mt-2">
                      <div
                        class="border-solid w-10 h-10 border-[1px] mr-2 border-[#b7b7b7] cursor-pointer rounded-lg shadow-[0_2px_3px_0_rgba(0,0,0,.15)] ">
                        <span class="flex items-center justify-center w-full h-full uppercase">
                          X
                        </span>
                      </div>

                      <div
                        class="border-solid w-10 h-10 border-[1px] mr-2 border-[#b7b7b7] cursor-pointer rounded-lg shadow-[0_2px_3px_0_rgba(0,0,0,.15)]">
                        <span class="flex items-center justify-center w-full h-full uppercase">
                          XL
                        </span>
                      </div>

                      <div
                        class="border-solid w-10 h-10 border-[1px] mr-2 last:mr-0 border-[#b7b7b7] cursor-pointer rounded-lg shadow-[0_2px_3px_0_rgba(0,0,0,.15)]">
                        <span class="flex items-center justify-center w-full h-full uppercase">
                          L
                        </span>
                      </div>
                    </div>
                  </div>
                  <!-- End Size -->

                  <!-- Quantity -->
                  <div class="mt-3">
                    <h2 class="font-bold text-md">Chọn số lượng: <span class="ml-3">1</span></h2>
                    <div class="flex items-center mt-3">
                      <div class="relative flex items-center ">
                        <button type="button" id="decrement-button" data-input-counter-decrement="counter-input"
                          class="flex-shrink-0   hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-10 w-10 focus:ring-gray-100  focus:ring-2 focus:outline-none">
                          <svg class="w-2.5 h-2.5 text-gray-900 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 18 2">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M1 1h16" />
                          </svg>
                        </button>
                        <input type="text" id="counter-input" data-input-counter
                          class="flex-shrink-0 text-gray-900  border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center"
                          placeholder="" value="12" required />
                        <button type="button" id="increment-button" data-input-counter-increment="counter-input"
                          class="flex-shrink-0  hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-10 w-10 focus:ring-gray-100  focus:ring-2 focus:outline-none">
                          <svg class="w-2.5 h-2.5 text-gray-900 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 18 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 1v16M1 9h16" />
                          </svg>
                        </button>
                      </div>

                      <div class="flex-1  mx-10">
                        <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 rounded-lg text-sm px-5 py-2.5 w-full font-bold  ">
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
@endpush
