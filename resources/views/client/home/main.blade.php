      @php
          $groupProduct = App\Models\GroupProduct::with('products')->where('status', 0)->get();
          $hasShownSaleBox = false;
      @endphp

      <!-- Box 1 -->
      @if (count($groupProduct) > 0)
          @foreach ($groupProduct as $group)
              <section class="py-5 ">
                  <div class="container max-w-[1170px] mx-auto   items-center h-full px-2.5 pb-6">
                      <div
                          class="flex flex-col justify-center w-full md:justify-center md:flex-row lg:justify-between lg:flex-row">
                          <div class="w-full">
                              <h1
                                  class="text-[30px] mb-6 text-[#ff5b26] text-center font-semibold md:text-[30px] md:mb-0 md:text-left lg:text-left lg:text-[40px] lg:mb-0">
                                  {{ $group->name }}</h1>
                          </div>

                          <div class="flex justify-center lg:inline">
                              <a href="{{ route('allGroupProduct', ['slug' => $group->slug]) }}"
                                  class="w-[12rem] flex  items-center relative">
                                  <span
                                      class="w-[3rem] h-[3rem] bg-[#ff5b26] flex justify-center items-center rounded-full ">
                                      <ion-icon name="chevron-forward-outline" class="text-lg text-white"></ion-icon>
                                  </span>
                                  <span
                                      class="bg-[#ff5b262e] absolute inset-0 py-[0.75rem] text-center ml-[1.85rem] rounded-r-[50px] font-semibold uppercase text-[#ff5b26]">Xem
                                      tất cả</span>
                              </a>
                          </div>
                      </div>

                      <div class="mt-3" data-aos="fade-right" data-aos-offset="10" data-aos-easing="ease-in-sine">
                          <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 ">
                              @if (count($group->products) > 0)
                                  @foreach ($group->products as $product)
                                      @php
                                          $priceArray = json_decode($product->variants); // Chuyển đổi JSON thành đối tượng

                                          // Chuyển đổi các giá trị trong price thành số thực
                                          $prices = array_map(function ($price) {
                                              return (float) str_replace('.', '', $price); // Loại bỏ dấu chấm
                                          }, $priceArray->price); // Sử dụng -> để truy cập thuộc tính của đối tượng

                                          // Lấy giá lớn nhất và nhỏ nhất
                                          $maxPrice = max($prices);
                                          $minPrice = min($prices);

                                          $formattedMaxPrice = number_format($maxPrice, 0, ',', '.') . '₫';
                                          $formattedMinPrice = number_format($minPrice, 0, ',', '.') . '₫';
                                      @endphp

                                      <!-- Col -->
                                      <div class="col-span-1 ">
                                          <div class="px-2 pb-3 group ">
                                              <div
                                                  class="border-[#e0e0e0]  border-[1px] relative pt-1 rounded-[20px] overflow-hidden shadow-[0_1px_3px_-2px_rgba(0,0,0,0.12),0_1px_2px_rgba(0,0,0,0.24)] group-hover:shadow-[0_3px_6px_-4px_rgba(0,0,0,0.16),0_3px_6px_rgba(0,0,0,0.23)] duration-300">
                                                  <a href="{{ route('firstProduct', ['slug' => $product->slug]) }}">
                                                      @switch($product->label)
                                                          @case(1)
                                                              <div
                                                                  class="absolute bg-transparent top-3 left-3 z-40 h-[2.8em] w-[5em]  rounded-full">
                                                                  <img class="bg-transparent"
                                                                      src="{{ asset('images/client/label/hot.png') }}" />
                                                              </div>
                                                          @break

                                                          @case(2)
                                                              <div
                                                                  class="absolute bg-transparent top-3 left-3 z-40 h-[2.8em] w-[5em]  rounded-full">
                                                                  <img class="bg-transparent"
                                                                      src="{{ asset('images/client/label/new.png') }}" />
                                                              </div>
                                                          @break

                                                          @case(3)
                                                              <div
                                                                  class="absolute bg-transparent top-3 left-3 z-40 h-[2.8em] w-[5em]  rounded-full">
                                                                  <img class="bg-transparent"
                                                                      src="{{ asset('images/client/label/sale.png') }}" />
                                                              </div>
                                                          @break

                                                          @default
                                                      @endswitch


                                                      <div class="relative min-h-[210px]">
                                                          <img src="{{ asset($product->avatar) }}"
                                                              class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                                              alt="...">
                                                      </div>

                                                      <div class="px-4 pb-5 pt-2 text-[.9em]">
                                                          <p class="truncate">{{ $product->name }}</p>
                                                          <p class="my-[6px]">
                                                          <div class="flex font-bold text-[#111]">
                                                              <span>{{ $formattedMinPrice }}</span>
                                                              &nbsp;- &nbsp;
                                                              <span> {{ $formattedMaxPrice }}</span>
                                                          </div>
                                                          </p>
                                                      </div>
                                                  </a>
                                              </div>
                                          </div>
                                      </div>
                                      <!-- End Col -->
                                  @endforeach
                              @endif



                          </div>
                      </div>

              </section>

              @if (!$hasShownSaleBox)
                  <!-- Sale -->
                  <section class="py-8 my-5 bg-black text-white">
                      <div class="container max-w-[1170px] mx-auto   items-center h-full px-2.5">
                          <div class="grid grid-cols-6">
                              <div class="col-span-6 lg:col-span-2">
                                  <img src="{{ asset('/images/client/Untitled-design-14.png') }}" />
                              </div>
                              <div class="col-span-6 lg:col-span-4 py-3">
                                  <div class="flex items-start flex-col justify-evenly h-full">
                                      <div class="flex justify-center flex-col w-full">
                                          <h2
                                              class="uppercase text-center text-[30px] font-bold mb-2 md:text-center lg:text-left">
                                              Ưu đãi lên tới 35%</h2>
                                          <p class="text-[16px] text-center md:text-center lg:text-left">Thời trang đẳng
                                              cấp với giá
                                              cả phải chăng. Mua sắm
                                              ngay để nhận ưu đãi giảm giá tốt…</p>
                                      </div>

                                      <div class="my-6 flex justify-center w-full">
                                          <span
                                              class="w-[120px] mr-3 h-[120px] flex justify-center items-center flex-col border-4 border-solid border-[#fff] rounded-full bg-[rgba(255,255,255,.85)]">
                                              <span class="text-black text-[40px] font-bold" id="hours">0</span>
                                              <span class="text-black">Giờ</span>
                                          </span>

                                          <span
                                              class="w-[120px] mr-3 h-[120px] flex justify-center items-center flex-col border-4 border-solid border-[#fff] rounded-full bg-[rgba(255,255,255,.85)]">
                                              <span class="text-black text-[40px] font-bold" id="minutes">0</span>
                                              <span class="text-black">Phút</span>
                                          </span>

                                          <span
                                              class="w-[120px] h-[120px] flex justify-center items-center flex-col border-4 border-solid border-[#fff] rounded-full bg-[rgba(255,255,255,.85)]">
                                              <span class="text-black text-[40px] font-bold" id="seconds">0</span>
                                              <span class="text-black">Giây</span>
                                          </span>
                                      </div>


                                      <div class="w-full flex justify-center">
                                          <a href="{{ route('login') }}"
                                              class="bg-[#ff5b26] inline-block relative px-[1.5em] py-[0.5em] text-[16px] font-bold rounded-[15px] cursor-pointer ">
                                              <span class="flex items-center">
                                                  Mua ngay
                                                  <ion-icon name="chevron-forward-outline"></ion-icon></span>
                                          </a>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </section>
                  @php $hasShownSaleBox = true; @endphp
                  <!-- End Sale -->
              @endif
          @endforeach
      @endif



      <!-- End Box 1 -->
