@extends('client.layout.layoutMatter')

@section('content')
   <!-- Main -->
    <main id="main">
      <div id="content">
        <!-- Banner -->
        @include('client.home.banner')
        <!-- End Banner -->

        <!-- Menu Hot -->
       @include('client.home.categorieHot')
        <!-- End Menu Hot -->

        <!-- Text -->
        <section class="py-[40px] w-full overflow-hidden lg:py-[80px]"> <!-- Thêm overflow-hidden -->
          <div
            class='marquee overflow-hidden mx-[-10px] py-2 text-white font-medium rotate-[-5deg] text-[20px] bg-[#ff5b26] lg:text-[40px] lg:py-4'
            data-duration='10000' data-gap='10' data-duplicated='true'>
            Fashion Fashion Fashion Fashion Fashion Fashion Fashion
          </div>

          <div
            class='marquee overflow-hidden py-2 top-[-10px] text-white font-medium rotate-[0deg] text-[20px] bg-[#1f1f1f] lg:text-[40px] lg:py-4'
            data-duration='10000' data-gap='10' data-duplicated='true'>
            Fashion Fashion Fashion Fashion Fashion Fashion Fashion
          </div>
        </section>
        <!-- End Text -->

        @include('client.home.main')

        <!-- Info -->
        <section class="py-5">
          <div class="container max-w-[1170px] mx-auto   items-center h-full px-2.5 pb-6">
            <div class="mb-6">
              <div class="uppercase text-center font-bold text-[30px] mb-2">Về Mona Fashion</div>
              <p class="text-center">Phong cách thời trang độc đáo. Tự tin và nổi bật.</p>
            </div>

            <div class="grid-cols-1 grid md:grid-cols-2 lg:grid-cols-4">
              <!-- Col -->
              <div class="col-span-1">
                <div class="px-[15px] pb-8">
                  <div class="flex justify-center flex-col">
                    <div class="icon flex justify-center mb-2">
                      <img src="{{ asset('images/client/icons/icons8-heart-100.png') }}" class="w-[70px] h-[70px]" alt="">
                    </div>
                    <div class="box">
                      <h3 class="uppercase text-center text-[20px] font-bold mb-2">Sản phẩm chất lượng</h3>
                      <p class="text-center text-[16px]">
                        Khám phá bộ sưu tập đa dạng tại Monafashion. Chúng tôi tự hào cung cấp những sản phẩm chất lượng
                        đáng tin cậy.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Col -->

              <!-- Col -->
              <div class="col-span-1">
                <div class="px-[15px] pb-8">
                  <div class="flex justify-center flex-col">
                    <div class="icon flex justify-center mb-2">
                      <img src="{{ asset('images/client/icons/icons8-rhombus-100-123.png') }}" class="w-[70px] h-[70px]" alt="">
                    </div>
                    <div class="box">
                      <h3 class="uppercase text-center text-[20px] font-bold mb-2">Giá cả hợp lý</h3>
                      <p class="text-center text-[16px]">
                        Mỗi món đồ tại Monafashion được định giá với sự công bằng và hợp lý, mang đến cho bạn sự trải
                        nghiệm mua sắm thú vị và tiết kiệm.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Col -->

              <!-- Col -->
              <div class="col-span-1">
                <div class="px-[15px] pb-8">
                  <div class="flex justify-center flex-col">
                    <div class="icon flex justify-center mb-2">
                      <img src="{{ asset('images/client/icons/icons8-rotate-100.png') }}" class="w-[70px] h-[70px]" alt="">
                    </div>
                    <div class="box">
                      <h3 class="uppercase text-center text-[20px] font-bold mb-2">Vận chuyển miễn phí</h3>
                      <p class="text-center text-[16px]">
                        Mua sắm sẽ dễ dàng hơn với vận chuyển trên toàn quốc để đảm bảo bạn nhận được sản phẩm một cách
                        nhanh chóng và thuận tiện.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Col -->

              <!-- Col -->
              <div class="col-span-1">
                <div class="px-[15px] pb-8">
                  <div class="flex justify-center flex-col">
                    <div class="icon flex justify-center mb-2">
                      <img src="{{ asset('images/client/icons/icons8-star-100.png') }}" class="w-[70px] h-[70px]" alt="">
                    </div>
                    <div class="box">
                      <h3 class="uppercase text-center text-[20px] font-bold mb-2">Hỗ trợ online</h3>
                      <p class="text-center text-[16px]">
                        Dội ngũ hỗ trợ khách hàng của chúng tôi luôn sẵn sàng 24/7 để giải đáp mọi thắc mắc và hỗ trợ
                        bạn trong quá trình mua sắm.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Col -->
            </div>

          </div>

        </section>
        <!-- End Info -->

        <!-- Hotline -->
        @include('client.home.hotline')
        <!-- End Hotline -->


      </div>
    </main>
    <!-- End Main -->

@endsection

