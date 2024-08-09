<ul class="pb-2 space-y-2">
    <li>
        @include('layouts.sidebar.form-search')
    </li>

    {{--  Dashboard  --}}
    <li>
        <button type="button"
            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
            aria-controls="dropdown-layouts" data-collapse-toggle="dropdown-layouts">
            <svg class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
            </svg>
            <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Dashboard</span>
            <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>

        {{--  Sub Menu  --}}
        <ul id="dropdown-layouts"
            class=" py-2 space-y-2 {{ request()->routeIs('dashboard_module.*') ? '' : 'hidden' }}">
            <li>
                <a href="{{ route('dashboard_module.dashboard.index') }}"
                    class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('dashboard_module.dashboard*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    Dashboard
                </a>
            </li>

        </ul>
    </li>
    {{--  End Dashboard  --}}

    {{--  User  --}}
    <li>
        <button type="button"
            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
            aria-controls="dropdown-user" data-collapse-toggle="dropdown-user">
            <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                </path>
            </svg>
            <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Tài khoản</span>
            <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>

        {{--  Sub Menu  --}}
        <ul id="dropdown-user" class=" py-2 space-y-2 {{ request()->routeIs('account_module.*') ? '' : 'hidden' }}">
            <li>
                <a href="{{ route('account_module.user.index') }}"
                    class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('account_module.user*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    Admin
                </a>
            </li>

        </ul>
    </li>
    {{--  End User  --}}

    {{--  Ecommerce  --}}
    <li>
        <button type="button"
            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
            aria-controls="dropdown-categories" data-collapse-toggle="dropdown-categories">
            <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                </path>
            </svg>
            <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Ecommerce</span>
            <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>

        {{--  Sub Menu  --}}
        <ul id="dropdown-categories"
            class=" py-2 space-y-2 {{ request()->routeIs('ecommerce_module.*') ? '' : 'hidden' }}">

            {{--  Categories  --}}
            <li>
                <a href="{{ route('ecommerce_module.categories.index') }}"
                    class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('ecommerce_module.categories*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    Danh mục
                </a>
            </li>

            {{--  Banner  --}}
            <li>
                <a href="{{ route('ecommerce_module.banner.index') }}"
                    class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('ecommerce_module.banner*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    Banner
                </a>
            </li>

             {{--  Properties  --}}
             <li>
                <a href="{{ route('ecommerce_module.properties.index') }}"
                    class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('ecommerce_module.properties*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    Thuộc tính sản phẩm
                </a>
            </li>

             {{--  Brand  --}}
             <li>
                <a href="{{ route('ecommerce_module.brand.index') }}"
                    class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('ecommerce_module.brand*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    Thương hiệu
                </a>
            </li>

            {{--  Label  --}}
            <li>
                <a href="{{ route('ecommerce_module.label.index') }}"
                    class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('ecommerce_module.label*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    Nhãn sản phẩm
                </a>
            </li>

            {{--  Products  --}}
            <li>
                <a href="{{ route('ecommerce_module.products.index') }}"
                    class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('ecommerce_module.products*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                    Sản phẩm
                </a>
            </li>
        </ul>
    </li>
    {{--  End User  --}}

</ul>
