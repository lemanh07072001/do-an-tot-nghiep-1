<td class="md:h-[300px] md:align-top">
    <h3 class="md:font-bold mb-2">Danh sách đơn hàng</h3>

    @if (count($getOders) > 0)
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Mã đơn hàng
                    </th>
                    <th width="20%" scope="col" class="px-6 py-3">
                        Ngày tạo
                    </th>
                    <th width="15%" scope="col" class="px-6 py-3">
                        Tổng tiền
                    </th>
                    <th width="25%"scope="col" class="px-6 py-3">
                        Thanh toán
                    </th>
                    <th width="20%" scope="col" class="px-6 py-3">
                        Trạng thái
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($getOders as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 font-bold py-4  text-gray-900 whitespace-nowrap">
                            {{ $item->code_order }}
                        </th>
                        <td class="px-6 py-4">
                            {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->order_date)->format('d-m-Y H:i:s') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ number_format($item->total_amount, 0, ',', '.') . ' đ' }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($item->payment_method == 'cash_on_delivery')
                                <span
                                    class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded ">Thanh
                                    toán khi nhận hàng</span>
                            @elseif($item->payment_method == 'payment_transfer')
                                <span
                                    class="bg-purple-100 text-purple-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded ">Thanh
                                    toán chuyển khoản</span>
                            @else
                                <span
                                    class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded ">Không
                                    có hình thức</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @if ($item->status == 'pending')
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded ">
                                    Đang chờ xử lý
                                </span>
                            @elseif($item->status == 'completed')
                                <span
                                    class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">
                                    Đã hoàn thành
                                </span>
                            @elseif($item->status == 'cancelled')
                                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded ">
                                    Đã huỷ
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    @else
        <p class="text-[#383838] text-[14px]">Bạn chưa mua đơn hàng nào</p>
    @endif

    @if ($getOders->perPage() <= $getOders->count())
        <div class="mt-3">
            {{ $getOders->onEachSide(5)->links() }}
        </div>
    @endif

</td>
