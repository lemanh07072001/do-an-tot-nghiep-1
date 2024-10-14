 @php
     $parentCategories = App\Models\Categories::whereNull('parent_id')->where('status', 0)->get();

    $children = collect();

    // Lặp qua từng danh mục cha và lấy danh mục con
    foreach ($parentCategories as $parent) {
        $children = $children->merge($parent->children()->where('hot', 0)->get());
    }


 @endphp

 <section class="pt-8 " data-aos="fade-right" data-aos-offset="10" data-aos-easing="ease-in-sine">
     <div class="container max-w-[1170px]  mx-auto  flex items-center h-full px-2.5">
         <div class="grid grid-cols-2 md:grid-cols-4 gap-1 lg:grid-cols-6 w-full">
            @if(count($children) > 0)
                @foreach ($children as $item)
                      <!-- Col  -->
             <div class="col-span-1 group ">
                 <div class="px-2 pb-2 ">
                     <div
                         class="border-[1px] group-hover:border-[#ff5b26] duration-300 group-hover:shadow-[1px_5px_5px_1px_#ccc] border-solid border-gray-500 rounded-[100px] group-hover:bg-[#ff5b26]">
                         <a href="{{ route('getFirstCategories',['slug'=>$item->slug]) }}" class="block">
                             <div class="flex items-center p-2 h-full lg:p-1">
                                 <div class="relative hidden overflow-hidden  lg:rounded-full lg:block">
                                     <div class="h-[70px] w-[70px]">
                                         <img src="{{(!empty($item->image))? asset($item->image):asset('images/noimage.png') }}"
                                             class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                             alt="...">
                                     </div>
                                 </div>
                                 <div class="px-2 mx-auto">
                                     <div
                                         class="uppercase  text-[13px] font-bold duration-300 group-hover:text-[#fff] lg:text-left">
                                         Áo khoác</div>
                                 </div>
                             </div>
                         </a>
                     </div>
                 </div>
             </div>
             <!-- End Col  -->
                @endforeach
            @endif







         </div>
     </div>
 </section>
