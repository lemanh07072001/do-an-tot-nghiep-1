<!-- Header -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'No title' }}</title>

    @php
        $logo = asset(App\Models\Setting::where('setting_key', 'setting_logo')->value('setting_value')) ?? '/images/logo.png';

    @endphp

    <link rel="icon" type="image/x-icon" href="{{asset($logo)}}">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>

    <!-- Flowbite -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Style -->
    <link href="{{ asset('assets/client/css/main.css') }}" rel="stylesheet" />



    <!-- AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        #loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 1);
            z-index: 9999;
        }

        .rl-loading-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            height: 100%;
        }

        .rl-loading-thumb {
            width: 10px;
            height: 40px;
            background-color: #41f3fd;
            margin: 4px;
            box-shadow: 0 0 12px 3px #0882ff;
            animation: rl-loading 1.5s ease-in-out infinite;
        }

        .rl-loading-thumb-1 {
            animation-delay: 0s;
        }

        .rl-loading-thumb-2 {
            animation-delay: 0.5s;
        }

        .rl-loading-thumb-3 {
            animation-delay: 1s;
        }

        @keyframes rl-loading {
            0% {}

            20% {
                background: white;
                transform: scale(1.5);
            }

            40% {
                background: #41f3fd;
                transform: scale(1);
            }
        }
    </style>
</head>

<body>
    <div id="loading">
        <div class="rl-loading-container">
            <div class="rl-loading-thumb rl-loading-thumb-1"></div>
            <div class="rl-loading-thumb rl-loading-thumb-2"></div>
            <div class="rl-loading-thumb rl-loading-thumb-3"></div>
        </div>
    </div>

    <div id="wrapper">
        <!-- Header -->
        @include('client.layout.header')
        <!-- End Header -->

        @yield('content')

        <!-- Banner Footer -->
        <section
            class="relative overflow-hidden w-full z-20
            before:content-[''] before:absolute before:h-[200px] before:w-[200px] before:bg-[#ff5b26] before:bottom-[60px] before:left-[-50px] before:rounded-full lg:z-10 before:opacity-65 lg:before:opacity-1
            after:content-[''] after:absolute after:h-[500px] after:w-[500px] after:bg-[#ff5b26] after:bottom-[-250px] after:right-[-250px] after:rounded-full after:opacity-65 lg:after:opacity-1">
            <div class="z-30">
                <div class="container max-w-[1170px] mx-auto   items-center h-full px-2.5 pb-6 ">
                    <div class="grid grid-cols-2 md:grid-cols-5 lg:grid-cols-5 items-center">
                        <div class="col-span-3  z-30">
                            <div class="h-full">
                                <div class=" bg-custom-radial">
                                    <div
                                        class="text-[25px] text-center lg:text-left lg:text-[32px] text-[#1c1c1c] uppercase">
                                        <span>Ưu đãi</span>
                                        <span class="text-[#ff5b26]"> giảm đến 50%</span>
                                    </div>
                                    <h2
                                        class="text-[32px] text-center lg:text-left lg:ext-[70px] text-[#4b4b4b] uppercase font-bold">
                                        Tài khoản mới</h2>
                                </div>

                                <p class="w-full mt-3 flex justify-center lg:justify-start">
                                    <a href="" class="w-[13rem] flex  items-center relative">
                                        <span
                                            class="w-[3rem] h-[3rem] bg-[#ff5b26] flex justify-center items-center rounded-full ">
                                            <ion-icon name="chevron-forward-outline"
                                                class="text-lg text-white"></ion-icon>
                                        </span>
                                        <span
                                            class="bg-[#ff5b262e] absolute inset-0 py-[0.75rem] text-center ml-[1.85rem] rounded-r-[50px] font-semibold uppercase text-[#ff5b26]">Đăng
                                            ký ngay</span>
                                    </a>
                                </p>

                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 mt-6">
                                    <div class="col-span-1">
                                        <div class="flex items-center justify-center ">
                                            <div class="w-2/5">
                                                <img src="{{ asset('images/client/icons8-like-100.png') }}"
                                                    alt="" class="w-full h-full">
                                            </div>
                                        </div>

                                        <div class="px-3 pb-5 text-center font-bold text-[14px] text-[#1c1c1c]">
                                            <h4>Sản phẩm chính hãng</h4>
                                        </div>
                                    </div>

                                    <div class="col-span-1">
                                        <div class="flex items-center justify-center ">
                                            <div class="w-2/5">
                                                <img src="{{ asset('images/client/icons8-box-60.png') }}" alt=""
                                                    class="w-full h-full">
                                            </div>
                                        </div>

                                        <div class="px-3 pb-5 text-center font-bold text-[14px] text-[#1c1c1c]">
                                            <h4>Dễ dàng đổi trả</h4>
                                        </div>
                                    </div>

                                    <div class="col-span-1">
                                        <div class="flex items-center justify-center ">
                                            <div class="w-2/5">
                                                <img src="{{ asset('images/client/icons8-delivery-64.png') }}"
                                                    alt="" class="w-full h-full">
                                            </div>
                                        </div>

                                        <div class="px-3 pb-5 text-center font-bold text-[14px] text-[#1c1c1c]">
                                            <h4>Giao hàng siêu tốc</h4>
                                        </div>
                                    </div>

                                    <div class="col-span-1">
                                        <div class="flex items-center justify-center ">
                                            <div class="w-2/5">
                                                <img src="{{ asset('images/client/icons8-money-100.png') }}"
                                                    alt="" class="w-full h-full">
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
                                <img src="{{ asset('images/client/img-footer-6.png') }}" />
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Banner Footer -->

        <!-- Footer -->
        @include('client.layout.footer')
        <!-- End Footer -->

        <!-- Jquery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <!-- Style -->
        <script src="{{ asset('assets/client/js/main.js') }}"></script>
        <script src="{{ asset('assets/js/action.js') }}"></script>
        <script src="{{ asset('assets/client/js/renderHtml.js') }}"></script>
        <script src="{{ asset('assets/client/js/ajax.js') }}"></script>

        {{-- Alert Box --}}
        <script src="https://cdn.jsdelivr.net/gh/noumanqamar450/alertbox@main/version/1.0.2/alertbox.min.js"></script>

        <!-- Font Awesome -->
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>

        <!-- Flowbite -->
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

        <!-- Swiper -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <!-- AOS -->
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>



        <script src="//cdn.jsdelivr.net/npm/jquery.marquee@1.6.0/jquery.marquee.min.js" type="text/javascript"></script>
        <script>
            $('.marquee').marquee({
                //duration in milliseconds of the marquee
                duration: 15000,
                //time in milliseconds before the marquee will start animating
                delayBeforeStart: 0,
                //'left' or 'right'
                direction: 'left',
                //true or false - should the marquee be duplicated to show an effect of continues flow
                duplicated: true
            });
        </script>

        <script>
            addLoading()

            $(document).on("DOMContentLoaded", function() {
                setTimeout(() => {
                    hideLoading();
                }, 500);
            });
        </script>

        <script>
            var searchAjax = '{{ route('searchAjax') }}'
        </script>

        @stack('js')

</body>

</html>
