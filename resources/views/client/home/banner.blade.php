 @php
     $getBanners = App\Models\Banner::where('status', 0)->get();


 @endphp

 <section>
     <!--HTML CODE-->
     <div class="w-full relative group">
         <div class="swiper slideBanner swiper-container">
             <div class="swiper-wrapper">
                 @if (count($getBanners) > 0)
                     @foreach ($getBanners as $banner)
                         <div class="swiper-slide">
                             <div
                                 class="bg-indigo-50 rounded-2xl h-[180px] sm:h-[300px] flex justify-center items-center  md:h-[360px] lg:h-[500px] xl:h-[600px]">
                                 <img src="{{ asset($banner->image) }}"
                                     class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                     alt="...">
                             </div>
                         </div>

                     @endforeach
                 @endif

             </div>
             <div
                 class="swiper-button-next h-9 w-9 sm:right-7 lg:group-hover:right-7 lg:duration-500 border-2 rounded-full opacity-[0.7] lg:right-[-40px] border-black after:content-['next'] after:text-[15px] after:font-bold after:text-black  ">
             </div>
             <div
                 class="swiper-button-prev h-9 w-9 sm:left-7 lg:group-hover:left-7 lg:duration-500 border-2 rounded-full opacity-[0.7] lg:left-[-40px] border-black after:content-['prev'] after:text-[15px] after:font-bold after:text-black  ">
             </div>

         </div>
     </div>

 </section>
