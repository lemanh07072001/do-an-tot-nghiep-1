<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- DataTables -->
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.tailwindcss.css">

    <!-- Toastr -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Toastr JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Dropzone -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.css">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- TinyMCE 5.0 -->
    <script src="https://cdn.tiny.cloud/1/sef0o4o8tkn89txt0y6uqc0osfrtxwvytzkbkhds6lotq5dd/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>


    <link rel="stylesheet" href="{{ asset('assets/css/customCss.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">

    @stack('css')

</head>
{{-- id="spingLoad" --}}
<body class="font-sans antialiased ">
    <div class="absolute inset-x-0 inset-y-0 bg-gray-400 opacity-80 z-50 overflow-hidden  " id="spingLoad">
        <div class="flex items-center justify-center w-full max-h-max h-full overflow-hidden">

            <div role="status">
                <img src="{{asset('/images/logo.svg')}}" class="h-12 mr-3" alt="FlowBite Logo" />
            </div>
        </div>
    </div>
    @include('layouts.header.header')
    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
        @include('layouts.sidebar.sidebar')


        <div id="main-content" class="relative w-full h-full bg-gray-50 lg:ml-64  dark:bg-gray-900">
            <main class=" w-full">
                {{ $slot }}
            </main>

        </div>

        @include('backend.speedDial.speedDialButton')
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DataTables -->
    <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="{{ asset('assets/js/customCssDatatables.js?ver=321') }}"></script>
    {{-- <script src="{{ asset('assets/js/datatable.js?ver=324') }}"></script> --}}

    <script src="{{ asset('assets/js/action.js') }}"></script>

    <!-- Toastr -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

     <!-- Toastr JS -->
     <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- Dropzone  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



    <!-- TinyMCE 5.0 -->
    <script src="{{asset('assets/js/keyTinyEMD.js')}}"></script>
    {{-- <script>
        const key = keyTinyEMD().key; // Lấy khóa API từ hàm keyTinyEMD()
        const tinyMCEUrl = `https://cdn.tiny.cloud/1/${key}/tinymce/5/tinymce.min.js`;
    </script> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tinyMCEUrl = document.querySelector('meta[name="tiny-mce-url"]').getAttribute('content');
            const scriptElement = document.createElement('script');
            scriptElement.src = tinyMCEUrl;
            scriptElement.referrerPolicy = "origin";
            document.head.appendChild(scriptElement);
        });
    </script> --}}

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>

    <script src="{{ asset('assets/js/swal.js') }}"></script>
    <script src="https://example.com/fontawesome/v6.5.2/js/all.js" data-auto-replace-svg="nest"></script>
    @stack('js')
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <script>
        var hostUrl = "{{ env('APP_URL') }}";


    </script>


</body>

</html>
