@php
    $logo = asset(App\Models\Setting::where('setting_key', 'setting_logo')->value('setting_value')) ?? '/images/logo.png';

    $title = App\Models\Setting::where('setting_key', 'setting_name')->value('setting_value') ?? 'Laravel';
@endphp


<nav class="fixed z-30 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar"
                    class="p-2 text-gray-600 rounded cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <svg id="toggleSidebarMobileClose" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <a href="" class="flex ml-2 md:mr-24">
                    <img src="{{$logo}}" class="h-8 mr-3 bg-transparent" alt="{{$title}}" />
                    <span
                        class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">{{$title}}</span>
                </a>
                <!-- Search  -->
                @include('layouts.header.search')
            </div>
            <div class="flex items-center">

                <!-- Search mobile -->
                @include('layouts.header.search-mobile')

                <!-- Notifications -->
                @include('layouts.header.notification')

                <!-- Apps -->
                @include('layouts.header.app')

                <!-- Dark Mode -->
                @include('layouts.header.dark-mode')

                <!-- Profile -->
                @include('layouts.header.profile')
            </div>
        </div>
    </div>
</nav>
