<x-app-layout>
    <div class="px-4 pt-6">


        <div class="grid gap-4 xl:grid-cols-2 2xl:grid-cols-3">
            <!-- Main widget -->
            <div
                class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex-shrink-0">
                        <span
                            class="text-xl font-bold leading-none text-gray-900 sm:text-2xl dark:text-white">{{ $getTotal }}
                            VND</span>
                        <h3 class="text-base font-light text-gray-500 dark:text-gray-400">Tổng số tiền</h3>
                    </div>

                </div>
                <div >
                    {!! $getChartData->container() !!}
                </div>
                <!-- Card Footer -->
                <div
                    class="flex items-center justify-between pt-3 mt-4 border-t border-gray-200 sm:pt-6 dark:border-gray-700">
                    <div>
                        <button
                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 rounded-lg hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                            type="button" data-dropdown-toggle="weekly-sales-dropdown">
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

                                @case('12_months')
                                    12 tháng
                                @break

                                Hôm nay

                                @default
                            @endswitch
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg></button>
                        <!-- Dropdown menu -->
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                            id="weekly-sales-dropdown">
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="{{ route('dashboard_module.dashboard.index', array_merge(request()->all(), ['chart' => 'yesterday'])) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Hôm qua</a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard_module.dashboard.index', array_merge(request()->all(), ['chart' => 'today'])) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Hôm nay</a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard_module.dashboard.index', array_merge(request()->all(), ['chart' => '7_days'])) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">7 ngày trước</a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard_module.dashboard.index', array_merge(request()->all(), ['chart' => '30_days'])) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">30 ngày trước</a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard_module.dashboard.index', array_merge(request()->all(), ['chart' => '12_months'])) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">12 tháng</a>
                                </li>
                            </ul>

                        </div>
                    </div>

                </div>
            </div>
            <!--Tabs widget -->
            @include('backend.dashboard.tabsWidget')
        </div>
        <div class="grid w-full grid-cols-1 gap-4 mt-4 xl:grid-cols-2 2xl:grid-cols-3">
            @include('backend.dashboard.widgetProduct', ['getSalesData' => $getSalesData])
            @include('backend.dashboard.widgetUser', ['getUserData' => $getUserData])


            <div
                class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <div class="w-full">
                    <h1 class="font-bold mb-3">Thống kê đơn hàng</h1>
                    @if (count($getTotalOrder) > 0)
                        @foreach ($getTotalOrder as $order)
                            @if ($order->status == 'pending')
                                <div class="p-4 transition-shadow border mb-3 rounded-lg shadow-sm hover:shadow-lg">
                                    <div class="flex items-start justify-between">
                                        <div class="flex flex-col space-y-2">
                                            <span class="text-gray-900 font-bold">Đang chờ xử lý</span>
                                            <span class="text-sm font-semibold">
                                                Số lượng: {{ $order->count }}
                                            </span>
                                            <span class="text-sm font-semibold">
                                                Tổng tiền:
                                                {{ number_format($order->total_amount, 0, ',', '.') . ' VND' }}
                                            </span>
                                        </div>
                                        <div class="p-6 bg-gray-200 rounded-md">
                                            <svg class="w-10 h-10 text-gray-800 dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                    d="M8.737 8.737a21.49 21.49 0 0 1 3.308-2.724m0 0c3.063-2.026 5.99-2.641 7.331-1.3 1.827 1.828.026 6.591-4.023 10.64-4.049 4.049-8.812 5.85-10.64 4.023-1.33-1.33-.736-4.218 1.249-7.253m6.083-6.11c-3.063-2.026-5.99-2.641-7.331-1.3-1.827 1.828-.026 6.591 4.023 10.64m3.308-9.34a21.497 21.497 0 0 1 3.308 2.724m2.775 3.386c1.985 3.035 2.579 5.923 1.248 7.253-1.336 1.337-4.245.732-7.295-1.275M14 12a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                                            </svg>

                                        </div>
                                    </div>

                                </div>
                            @elseif ($order->status == 'completed')
                                <div class="p-4 transition-shadow border mb-3 rounded-lg shadow-sm hover:shadow-lg">
                                    <div class="flex items-start justify-between">
                                        <div class="flex flex-col space-y-2">
                                            <span class="text-gray-900 font-bold">Đã xử lý</span>
                                            <span class="text-sm font-semibold">
                                                Số lượng: {{ $order->count }}
                                            </span>
                                            <span class="text-sm font-semibold">
                                                Tổng tiền:
                                                {{ number_format($order->total_amount, 0, ',', '.') . ' VND' }}
                                            </span>
                                        </div>
                                        <div class="p-6 bg-gray-200 rounded-md">
                                            <svg class="w-10 h-10 text-gray-800 dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m7.171 12.906-2.153 6.411 2.672-.89 1.568 2.34 1.825-5.183m5.73-2.678 2.154 6.411-2.673-.89-1.568 2.34-1.825-5.183M9.165 4.3c.58.068 1.153-.17 1.515-.628a1.681 1.681 0 0 1 2.64 0 1.68 1.68 0 0 0 1.515.628 1.681 1.681 0 0 1 1.866 1.866c-.068.58.17 1.154.628 1.516a1.681 1.681 0 0 1 0 2.639 1.682 1.682 0 0 0-.628 1.515 1.681 1.681 0 0 1-1.866 1.866 1.681 1.681 0 0 0-1.516.628 1.681 1.681 0 0 1-2.639 0 1.681 1.681 0 0 0-1.515-.628 1.681 1.681 0 0 1-1.867-1.866 1.681 1.681 0 0 0-.627-1.515 1.681 1.681 0 0 1 0-2.64c.458-.361.696-.935.627-1.515A1.681 1.681 0 0 1 9.165 4.3ZM14 9a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                                            </svg>

                                        </div>
                                    </div>

                                </div>
                            @elseif ($order->status == 'cancelled')
                                <div class="p-4 transition-shadow border mb-3 rounded-lg shadow-sm hover:shadow-lg">
                                    <div class="flex items-start justify-between">
                                        <div class="flex flex-col space-y-2">
                                            <span class="text-gray-900 font-bold">Đã huỷ</span>
                                            <span class="text-sm font-semibold">
                                                Số lượng: {{ $order->count }}
                                            </span>
                                            <span class="text-sm font-semibold">
                                                Tổng tiền:
                                                {{ number_format($order->total_amount, 0, ',', '.') . ' VND' }}
                                            </span>
                                        </div>
                                        <div class="p-6 bg-gray-200 rounded-md">
                                            <svg class="w-10 h-10 text-gray-800 dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M10.7367 14.5876c.895.2365 2.8528.754 3.1643-.4966.3179-1.2781-1.5795-1.7039-2.5053-1.9117-.1034-.0232-.1947-.0437-.2694-.0623l-.6025 2.4153c.0611.0152.1328.0341.2129.0553Zm.8452-3.5291c.7468.1993 2.3746.6335 2.6581-.5025.2899-1.16213-1.2929-1.5124-2.066-1.68348-.0869-.01923-.1635-.03619-.2262-.0518l-.5462 2.19058c.0517.0129.1123.0291.1803.0472Z" />
                                                <path fill="currentColor" fill-rule="evenodd"
                                                    d="M9.57909 21.7008c5.35781 1.3356 10.78401-1.9244 12.11971-7.2816 1.3356-5.35745-1.9247-10.78433-7.2822-12.11995C9.06034.963624 3.6344 4.22425 2.2994 9.58206.963461 14.9389 4.22377 20.3652 9.57909 21.7008ZM14.2085 8.0526c1.3853.47719 2.3984 1.1925 2.1997 2.5231-.1441.9741-.6844 1.4456-1.4013 1.6116.9844.5128 1.485 1.2987 1.0078 2.6612-.5915 1.6919-1.9987 1.8347-3.8697 1.4807l-.454 1.8196-1.0972-.2734.4481-1.7953c-.2844-.0706-.575-.1456-.8741-.2269l-.44996 1.8038-1.09594-.2735.45407-1.8234c-.10059-.0258-.20185-.0522-.30385-.0788-.15753-.0411-.3168-.0827-.47803-.1231l-1.42812-.3559.54468-1.2563s.80844.215.7975.1991c.31063.0769.44844-.1256.50282-.2606l.71781-2.8766.11562.0288c-.04375-.0175-.08343-.0288-.11406-.0366l.51188-2.05344c.01375-.23312-.06688-.52719-.51125-.63812.01718-.01157-.79688-.19813-.79688-.19813l.29188-1.17187 1.51313.37781-.0013.00562c.2275.05657.4619.11032.7007.16469l.4497-1.80187 1.0965.27343-.4406 1.76657c.2944.06718.5906.135.8787.20687l.4375-1.755 1.0975.27344-.4493 1.8025Z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    @endif

                </div>

            </div>
        </div>

    </div>
    @push('js')
        <script src="{{ $getChartData->cdn() }}"></script>

        {{ $getChartData->script() }}
    @endpush
</x-app-layout>
