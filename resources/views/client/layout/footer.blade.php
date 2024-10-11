 @php
     $policyAll = App\Models\Policy::all();


     $settingAddress = App\Models\Setting::where('setting_key', 'setting_address')->value('setting_value') ?? '1073/23 Cách Mạng Tháng 8, P.7, Q.Tân Bình, TP.HCM';
     $settingPhone = App\Models\Setting::where('setting_key', 'setting_phone')->value('setting_value') ?? '012345678';
     $settingEmail = App\Models\Setting::where('setting_key', 'setting_email')->value('setting_value') ?? ' info@themona.global';
 @endphp

 <footer class="bg-[#fff8ec] py-6 px-[10px]">
     <div class="container max-w-[1170px] mx-auto   items-center h-full ">
         <div class="grid grid-cols-1  md:grid-cols-4 lg:grid-cols-4">
             <div class="col-span-1">
                 <div class="w-3/4">
                     <img src="{{ asset('images/client/MONA-e1702621831263.png') }}" />
                 </div>
                 <div class="mt-3 w-full">
                     <div class="flex mt-2">
                         <div>
                             <ion-icon class="text-[20px]" name="location"></ion-icon>
                         </div>
                         <div class="ml-2 text-sm text-[#666666]">
                             {{ $settingAddress }}
                         </div>
                     </div>

                     <div class="flex mt-2">
                         <div>
                             <ion-icon class="text-[20px]" name="call"></ion-icon>
                         </div>
                         <div class="ml-2 text-sm text-[#666666]">
                             {{ $settingPhone }}
                         </div>
                     </div>

                     <div class="flex mt-2">
                         <div>
                             <ion-icon class="text-[20px]" name="mail"></ion-icon>
                         </div>
                         <div class="ml-2 text-sm text-[#666666]">
                             {{ $settingEmail}}
                         </div>
                     </div>
                 </div>
             </div>

             <div class="col-span-1 mt-10 md:mt-0 lg:mt-0">
                 <div class="flex justify-items-center w-full">
                     <div class=" md:ml-5  lg:ml-10 w-full">
                         <h3 class="uppercase  font-semibold">dịch vụ</h3>
                         <div class="">
                             <ul>
                                 <li class="mt-1">
                                     <a class="block text-sm text-[#666666]" href="">Chăm sóc khác hàng</a>
                                 </li>
                                 <li class="mt-1">
                                     <a class="block text-sm text-[#666666]" href="">Bảo hiểm điện thoại</a>
                                 </li>
                                 <li class="mt-1">
                                     <a class="block text-sm text-[#666666]" href="">Thanh toán</a>
                                 </li>
                                 <li class="mt-1">
                                     <a class="block text-sm text-[#666666]" href="">Sửa chữa bảo hành</a>
                                 </li>

                             </ul>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="col-span-1 mt-10 md:mt-0 lg:mt-0">
                 <div class="flex justify-items-center">
                     <div class="md:ml-5  lg:ml-10 w-full">
                         <h3 class="uppercase  font-semibold">chính sách & hỗ trợ</h3>
                         <div class="">
                             <ul>
                                 @if (count($policyAll) > 0)
                                     @foreach ($policyAll as $item)
                                         <li class="mt-1">
                                             <a class="block text-sm text-[#666666]"
                                                 href="">{{ $item->name }}</a>
                                         </li>
                                     @endforeach

                                 @endif


                             </ul>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="col-span-1 mt-10 md:mt-0 lg:mt-0 md:ml-5">
                 <div class="rounded-[2.4rem] border-2 border-solid border-[#ff5b26]">
                     <!-- Test -->
                     <div class="h-full">
                         ds
                     </div>

                     <!-- End Test -->
                 </div>
             </div>
         </div>
     </div>
 </footer>
