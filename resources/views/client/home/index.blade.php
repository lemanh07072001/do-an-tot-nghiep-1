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

        <!-- Banner Footer -->
        <section class="relative overflow-hidden w-full z-20
            before:content-[''] before:absolute before:h-[200px] before:w-[200px] before:bg-[#ff5b26] before:bottom-[60px] before:left-[-50px] before:rounded-full lg:z-10 before:opacity-65 lg:before:opacity-1
            after:content-[''] after:absolute after:h-[500px] after:w-[500px] after:bg-[#ff5b26] after:bottom-[-250px] after:right-[-250px] after:rounded-full after:opacity-65 lg:after:opacity-1">
          <div class="z-30">
            <div class="container max-w-[1170px] mx-auto   items-center h-full px-2.5 pb-6 ">
              <div class="grid grid-cols-2 md:grid-cols-5 lg:grid-cols-5 items-center">
                <div class="col-span-3  z-30">
                  <div class="h-full">
                    <div class=" bg-custom-radial">
                      <div class="text-[25px] text-center lg:text-left lg:text-[32px] text-[#1c1c1c] uppercase">
                        <span>Ưu đãi</span>
                        <span class="text-[#ff5b26]"> giảm đến 50%</span>
                      </div>
                      <h2 class="text-[32px] text-center lg:text-left lg:ext-[70px] text-[#4b4b4b] uppercase font-bold">Tài khoản mới</h2>
                    </div>

                    <p class="w-full mt-3 flex justify-center lg:justify-start">
                      <a href="" class="w-[13rem] flex  items-center relative">
                        <span class="w-[3rem] h-[3rem] bg-[#ff5b26] flex justify-center items-center rounded-full ">
                          <ion-icon name="chevron-forward-outline" class="text-lg text-white"></ion-icon>
                        </span>
                        <span
                          class="bg-[#ff5b262e] absolute inset-0 py-[0.75rem] text-center ml-[1.85rem] rounded-r-[50px] font-semibold uppercase text-[#ff5b26]">Đăng ký ngay</span>
                      </a>
                    </p>

                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 mt-6">
                      <div class="col-span-1">
                        <div class="flex items-center justify-center ">
                          <div class="w-2/5">
                            <img src="{{ asset('images/client/icons8-like-100.png') }}" alt="" class="w-full h-full">
                          </div>
                        </div>

                        <div class="px-3 pb-5 text-center font-bold text-[14px] text-[#1c1c1c]">
                          <h4>Sản phẩm chính hãng</h4>
                        </div>
                      </div>

                      <div class="col-span-1">
                        <div class="flex items-center justify-center ">
                          <div class="w-2/5">
                            <img src="{{ asset('images/client/icons8-box-60.png') }}" alt="" class="w-full h-full">
                          </div>
                        </div>

                        <div class="px-3 pb-5 text-center font-bold text-[14px] text-[#1c1c1c]">
                          <h4>Dễ dàng đổi trả</h4>
                        </div>
                      </div>

                      <div class="col-span-1">
                        <div class="flex items-center justify-center ">
                          <div class="w-2/5">
                            <img src="{{ asset('images/client/icons8-delivery-64.png') }}" alt="" class="w-full h-full">
                          </div>
                        </div>

                        <div class="px-3 pb-5 text-center font-bold text-[14px] text-[#1c1c1c]">
                          <h4>Giao hàng siêu tốc</h4>
                        </div>
                      </div>

                      <div class="col-span-1">
                        <div class="flex items-center justify-center ">
                          <div class="w-2/5">
                            <img src="{{ asset('images/client/icons8-money-100.png') }}" alt="" class="w-full h-full">
                          </div>
                        </div>

                        <div class="px-3 pb-5 text-center font-bold text-[14px] text-[#1c1c1c]">
                          <h4>Thanh toán dễ dàng</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-span-2 z-30 relative">
                  <div class="z-10">
                    <img src="{{ asset('images/client/img-footer-6.png') }}"/>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- End Banner Footer -->
      </div>
    </main>
    <!-- End Main -->

@endsection

