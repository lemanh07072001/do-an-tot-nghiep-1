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

<body class="font-sans antialiased">
    <div class="absolute inset-x-0 inset-y-0 bg-gray-400 opacity-80">
        <div class="flex items-center justify-center w-full h-full ">
            ds
            <div role="status">
                <svg aria-hidden="true" class="w-10 h-10 text-gray-200 animate-spin fill-blue-600"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    @include('layouts.header.header')
    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
        @include('layouts.sidebar.sidebar')


        <div id="main-content" class="relative w-full h-svh  overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
            <main class="max-h-screen w-full h-svh">
                {{ $slot }}
            </main>

        </div>

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
