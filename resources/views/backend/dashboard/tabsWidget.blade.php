<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white">Thống kê sản phẩm bán chạy
        <button data-popover-target="popover-description" data-popover-placement="bottom-end" type="button"><svg
                class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                    clip-rule="evenodd"></path>
            </svg><span class="sr-only">Show information</span></button>
    </h3>
    <div data-popover id="popover-description" role="tooltip"
        class="absolute z-10 invisible inline-block text-sm font-light text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
        <div class="p-3 space-y-2">
            <h3 class="font-semibold text-gray-900 dark:text-white">Statistics</h3>
            <p>Thống kê là một nhánh của toán học ứng dụng liên quan đến việc thu thập, mô tả,
                phân tích và suy ra kết luận từ dữ liệu định lượng.</p>
            <a href="#"
                class="flex items-center font-medium text-primary-600 dark:text-primary-500 dark:hover:text-primary-600 hover:text-primary-700">Read
                more <svg class="w-4 h-4 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"></path>
                </svg></a>
        </div>
        <div data-popper-arrow></div>
    </div>
    <div class="sm:hidden">
        <label for="tabs" class="sr-only">Select tab</label>
        <select id="tabs"
            class="bg-gray-50 border-0 border-b border-gray-200 text-gray-900 text-sm rounded-t-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <option>Statistics</option>
            <option>Services</option>
            <option>FAQ</option>
        </select>
    </div>

    <div class="border-t border-gray-200 dark:border-gray-600">
        <div class=" pt-4">
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @if (count($data) > 0)

                    @foreach ($data as $item)

                        <li class="py-3 sm:py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center min-w-0">
                                    <img class="flex-shrink-0 w-10 h-10"
                                        src="{{ asset($item->product_variant->products->avatar) }}" alt="imac image">
                                    <div class="ml-3">
                                        <p class="font-medium text-gray-900 truncate dark:text-white">
                                            {{ $item->product_variant->products->name }}
                                        </p>

                                        <div class="text-[13px] text-gray-500 ">
                                            @foreach ($item->property_names as $key => $property)
                                            <span>{{ $key }}: {{ $property }}</span> |
                                        @endforeach
                                        </div>
                                         <div
                                            class="flex items-center justify-start flex-1 text-sm text-green-500 dark:text-green-400">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path clip-rule="evenodd" fill-rule="evenodd"
                                                    d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z">
                                                </path>
                                            </svg>
                                            {{ round($item->percentage) }}%
                                            @switch(request('last'))
                                                @case('yesterday')
                                                    <span class="ml-2 text-gray-500">so với hôm qua </span>
                                                @break

                                                @case('today')
                                                    <span class="ml-2 text-gray-500">so với hôm nay </span>
                                                @break

                                                @case('7_days')
                                                    <span class="ml-2 text-gray-500">so với 7 ngày trước </span>
                                                @break

                                                @case('30_days')
                                                    <span class="ml-2 text-gray-500">so với 30 ngày trước </span>
                                                @break

                                                @case('90_days')
                                                    <span class="ml-2 text-gray-500">so với 90 ngày trước </span>
                                                @break

                                                @default
                                            @endswitch

                                        </div>
                                    </div>
                                </div>
                                <div class="text-[12px] font-sm text-gray-900 ">
                                    Đã bán: {{ $item->total_quantity }}

                                </div>
                            </div>
                        </li>
                    @endforeach
                @else
                    <div class="text-center">Chưa có sản phẩm nào</div>
                @endif


            </ul>
        </div>

    </div>
    <!-- Card Footer -->
    <div class="flex items-center justify-between pt-3 mt-5 border-t border-gray-200 sm:pt-6 dark:border-gray-700">
        <div>
            <button
                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 rounded-lg hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                type="button" data-dropdown-toggle="stats-dropdown">
                @switch(request('last'))
                    @case('yesterday')
                        Hôm qua
                    @break

                    @case('today')
                        Hôm nay
                    @break

                    @case('7_days')
                        7 ngày trước
                    @break

                    @case('30_days')
                        30 ngày trước
                    @break

                    @case('90_days')
                        90 ngày trước
                    @break
                        Hôm nay
                    @default
                @endswitch
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg></button>
            <!-- Dropdown menu -->
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                id="stats-dropdown">

                <ul class="py-1" role="none">
                    <li>
                        <a href="{{ route('dashboard_module.dashboard.index', array_merge(request()->all(), ['last' => 'yesterday'])) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                            role="menuitem">Hôm qua</a>
                    </li>
                    <li >
                        <a href="{{ route('dashboard_module.dashboard.index', array_merge(request()->all(), ['last' => 'today'])) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                            role="menuitem">Hôm nay</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard_module.dashboard.index',array_merge(request()->all(), ['last' => '7_days'])) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                            role="menuitem">7 ngày trước</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard_module.dashboard.index',array_merge(request()->all(), ['last' => '30_days'])) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                            role="menuitem">30 ngày trước</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard_module.dashboard.index',array_merge(request()->all(), ['last' => '90_days'])) }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                            role="menuitem">90 ngày trước</a>
                    </li>
                </ul>

            </div>
        </div>

    </div>
</div>
