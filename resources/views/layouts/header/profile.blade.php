<div class="flex items-center ml-3">
    <div>
        <button type="button"
            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
            id="user-menu-button-2" aria-expanded="false" data-dropdown-toggle="dropdown-2">
            <span class="sr-only">Open user menu</span>
            <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                alt="user photo">
        </button>
    </div>
    <!-- Dropdown menu -->
    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
        id="dropdown-2">
        <div class="px-4 py-3" role="none">
            <p class="text-sm text-gray-900 dark:text-white" role="none">
                {{ Auth::user()->name }}
            </p>
            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                {{ Auth::user()->email }}
            </p>
        </div>
        <ul class="py-1" role="none">
            @can('Quản lý trang chủ' )
                <li>
                <a href="{{ route('dashboard_module.dashboard.index') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                    role="menuitem">Dashboard</a>
            </li>
            @endcan

            @can('Cài đặt chung')
                <li>
                <a href="{{ route('setting_module.setting.index') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                    role="menuitem">Settings</a>
            </li>
            @endcan

            @can('Quản lý đơn hàng')
                <li>
                <a href="{{ route('ecommerce_module.order.index') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                    role="menuitem">Đơn hàng</a>
            </li>
            @endcan

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                    class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                    role="menuitem">Đăng xuất</button>
                </form>
            </li>
        </ul>
    </div>
</div>
