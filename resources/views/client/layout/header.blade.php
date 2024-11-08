@php
    $logo =
        asset(App\Models\Setting::where('setting_key', 'setting_logo')->value('setting_value')) ?? '/images/logo.png';

    $parentCategories = App\Models\Categories::whereNull('parent_id')->where('status', 0)->get();

    $categoriesArray = [];

    foreach ($parentCategories as $parentCategory) {
        // Chuyển đối tượng danh mục cha thành mảng
        $parentArray = $parentCategory->toArray();

        // Lấy tất cả danh mục con của danh mục cha
        $children = $parentCategory->children()->where('status', 0)->get();

        // Gán danh mục con vào mảng cha dưới dạng một phần tử 'children'
        $parentArray['children'] = $children->toArray();

        // Gán mảng danh mục cha và con vào mảng chính
        $categoriesArray[] = $parentArray;
    }

@endphp

<header id="header" class="header">
    <div class="header-wraper shadow">
        <div id="masthead" class="h-[70px] z-10 lg:h-[100px] ">
            <div class="container max-w-[1170px] mx-auto  flex items-center h-full px-2.5">
                <div class="flex  items-center w-full">
                    <!-- Logo -->
                    <div class="logo order-2 lg:mr-[30px] lg:order-none">
                        <a href="{{ route('index') }}" class="block w-full max-w-[200px] min-w-[100px] h-auto">
                            <img src="{{ asset($logo) ?? asset('images/client/MONA-e1702621831263.png') }}"
                                alt="MONA" class="w-full h-auto max-h-[100px] object-contain" />
                        </a>
                    </div>
                    <!-- End Logo -->

                    <!-- Button Menu Mobile -->
                    <div class="order-1 z-0 flex-1 lg:order-none lg:flex-initial">
                        <ion-icon id="buttonOpenMenuMobile" class="text-[24px] lg:hidden"
                            name="menu-outline"></ion-icon>
                    </div>
                    <!-- End Button Menu Mobile -->

                    <!-- Menu Desktop -->
                    <div id="menu"
                        class="absolute hidden flex-1 z-20 inset-0  w-full bg-slate-200 justify-center max-h-full lg:bg-transparent lg:block lg:relative">
                        <ion-icon id="buttonCloseMenuMobile"
                            class="absolute top-3 right-3 z-20 text-[30px] text-[#666666] lg:hidden"
                            name="close-outline"></ion-icon>

                        <div class="h-full bg-white w-1/2 z-30 lg:w-full overflow-x-auto lg:overflow-x-visible">
                            <ul class="flex flex-col py-[30px]  lg:justify-center lg:flex-row lg:py-0 lg:flex-1">
                                <li class="border-solid lg:px-2.5 lg:mx-[7px] first:ml-0  menu-list">
                                    <a href="{{ route('index') }}"
                                        class="leading-4 px-5 py-[15px] inline-flex w-full text-[#666666] text-[.8em]  font-bold tracking-wider uppercase lg:hover:text-[#ff5b26] lg:text-[.9em] lg:hover:ease-in lg:p-0 lg:py-2.5">Trang
                                        chủ</a>
                                </li>

                                <li class="border-solid lg:px-2.5 lg:mx-[7px]   menu-list">
                                    <a href="{{ route('aboutPage') }}"
                                        class="leading-4 px-5 py-[15px] inline-flex w-full text-[#666666] text-[.8em]  font-bold tracking-wider uppercase lg:hover:text-[#ff5b26] lg:text-[.9em] lg:hover:ease-in lg:p-0 lg:py-2.5">Giới
                                        thiệu</a>
                                </li>
                                <li class="border-solid lg:px-2.5 lg:mx-[7px] menu-list lg:relative group">
                                    <a href="{{ route('allProductCategories') }}"
                                        class="leading-4 px-5 py-[15px] inline-flex w-full justify-between text-[#666666] text-[.8em] font-bold tracking-wider uppercase lg:group-hover:text-[#ff5b26] lg:hover:text-[#ff5b26] lg:text-[.9em] lg:hover:ease-in lg:p-0 lg:py-2.5">
                                        Sản phẩm
                                        <ion-icon name="chevron-down-outline" class="text-sm"
                                            id="openSupMenuMobile"></ion-icon>
                                    </a>
                                    <div id="supMenuMobile"
                                        class=" relative hidden shadow-neutral-300   text-[#777] bg-[#fff] lg:py-5 lg:left-0 lg:shadow-lg lg:group-hover:block lg:rounded-xl lg:border-1 lg:border-[#ddd] lg:min-w-[240px] lg:top-9 lg:absolute">
                                        <ul class="flex flex-col lg:flex-row">
                                            @if (count($categoriesArray))
                                                @foreach ($categoriesArray as $itemParent)
                                                    <li
                                                        class=" mb-3 pl-[.5em] text-[1em] lg:first:border-[#f1f1f1] lg:first:border-l-2 lg:min-w-[160px]">
                                                        <div
                                                            class="pl-5 py-2 text-[.8em] uppercase font-bold text-[#000] block lg:rounded-lg lg:hover:bg-[#ff5b26]  lg:py-2 lg:px-5 lg:pr-1 lg:pl-2 lg:mx-2 lg:hover:text-[#fff]">
                                                            {{ $itemParent['name'] }}
                                                        </div>

                                                        <ul class="">
                                                            @if (count($itemParent['children']) > 0)
                                                                @foreach ($itemParent['children'] as $item)
                                                                    <li class="pl-[.5em]">
                                                                        <a href="{{ route('detail', ['slug' => $item['slug'], 'id' => $item['id']]) }}"
                                                                            class="pl-5 py-2 text-[.9em] text-[rgba(102,102,102,0.85)] block lg:hover:bg-[#ff5b26] lg:rounded-lg lg:py-2 lg:px-5 lg:pr-1 lg:pl-2 lg:mx-2 lg:hover:text-[#fff]">
                                                                            {{ $item['name'] }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            @endif



                                                        </ul>
                                                    </li>
                                                @endforeach
                                            @endif


                                        </ul>
                                    </div>
                                </li>
                                <li class="border-solid lg:px-2.5 lg:mx-[7px]  last:ml-0 menu-list">
                                    <a href="{{ route('index') }}"
                                        class="leading-4 px-5 py-[15px] inline-flex w-full text-[#666666] text-[.8em]  font-bold tracking-wider uppercase lg:hover:text-[#ff5b26] lg:text-[.9em] lg:hover:ease-in lg:p-0 lg:py-2.5">Liên
                                        hệ</a>
                                </li>
                                <li class="border-solid last:ml-0 menu-list lg:px-2.5 lg:mx-[7px]  lg:hidden">
                                    <a href="#"
                                        class="leading-4 px-5 py-[15px] inline-flex w-full text-[#666666] text-[.8em]  font-bold tracking-wider uppercase lg:hover:text-[#ff5b26] lg:text-[.9em] lg:hover:ease-in lg:p-0 lg:py-2.5">Đăng
                                        nhập</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Menu Desktop -->

                    <!-- Right Box -->
                    <div class="flex flex-1 justify-end order-3 lg:order-none lg:flex-initial">
                        <!-- Search Bar -->
                        <div class="search-header pr-2 lg:mx-[7px] border-solid relative first:ml-0 lg:py-3 group">
                            <a href="{{ route('search') }}">
                                <ion-icon class=" cursor-pointer text-[#666666] text-[20px] lg:text-[20px]"
                                    name="search-outline"></ion-icon>
                            </a>


                        </div>
                        <!-- End Search Bar -->

                        <!-- User -->
                        @if (Auth::check())
                            <div class="search-header pr-2 hidden lg:mx-[7px] border-solid first:ml-0 lg:block lg:py-3">
                                <a href="{{ route('showTabs') }}">
                                    <ion-icon class="cursor-pointer text-[#666666] text-[20px] lg:text-[20px]"
                                        name="person"></ion-icon>
                                </a>
                            </div>
                        @else
                            <div class="search-header pr-2 hidden lg:mx-[7px] border-solid first:ml-0 lg:block lg:py-3">
                                <a href="{{ route('login') }}">
                                    <ion-icon class="cursor-pointer text-[#666666] text-[20px] lg:text-[20px]"
                                        name="person"></ion-icon>
                                </a>
                            </div>
                        @endif
                        <!-- End User -->

                        @if (Auth::check())
                            <!-- Cart -->
                            <div class="cart search-header lg:mx-[7px] border-solid  first:ml-0 relative group lg:py-3">
                                <a href="{{ route('cart.index') }}">
                                    <ion-icon class=" cursor-pointer text-[#666666] text-[20px] lg:text-[21px]"
                                        name="cart"></ion-icon>

                                </a>

                                {{-- <div
                                class=" group-hover:block hidden absolute z-30 shadow-lg shadow-neutral-300 px-3 py-5 border-2 rounded-2xl text-[#777] bg-[#fff] border-[#ddd] min-w-[240px]  top-11 right-0">
                                <div class="px-[10px]">
                                    Chưa có sản phẩm trong giỏ hàng
                                </div>
                            </div> --}}
                            </div>
                            <!-- End Cart -->
                        @endif
                        <!-- End Right Box -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


@push('js')
    <script></script>
@endpush
