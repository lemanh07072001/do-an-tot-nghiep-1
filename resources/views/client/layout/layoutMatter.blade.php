<!-- Header -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mona Fashion</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>
    <script src="./src/js/tailwind.js"></script>
    <link href="./output.css" rel="stylesheet" />

    <!-- Flowbite -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Style -->
    <link href="/src/css/main.css" rel="stylesheet" />

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
            background-color: rgba(255, 255, 255, 0.8);
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
    <div  id="loading">
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

        <!-- Footer -->
        @include('client.layout.footer')
        <!-- End Footer -->

        <!-- Jquery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <!-- Style -->
        <script src="{{ asset('assets/client/js/main.js') }}"></script>
        <script src="{{ asset('assets/client/js/ajax.js') }}"></script>

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

        {{-- <script>
            swiper('.slideBanner')
        </script> --}}

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
            $(document).ready(function() {
                $("#loading").show();

                $(window).on("load", function() {
                    $("#loading").fadeOut(); // Ẩn loading với hiệu ứng fade out
                });
            });
        </script>

        @stack('js')

</body>

</html>
