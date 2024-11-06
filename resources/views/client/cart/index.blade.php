@extends('client.layout.layoutMatter')

@section('content')
    <!-- Break -->
    <section>
        <div class="container max-w-[1170px] mx-auto items-center h-full px-2.5 pt-6 ">
            <div class="grid md:grid-cols-1 lg:grid-cols-5 grid-cols-1">
                <div class="col-span-1 md:col-span-1 lg:col-span-3 mx-auto lg:m-0">
                    <nav class="flex items-center h-full w-full" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                            <li class="inline-flex items-center">
                                <a href="#"
                                    class="inline-flex items-center text-md font-medium text-gray-700 hover:text-[#ff5b26] ">
                                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                    </svg>
                                    Trang chủ
                                </a>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <span class="ms-1 text-md font-medium text-gray-500 md:ms-2">Giỏ
                                        hàng</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="col-span-1 mt-3 md:mt-3 lg:mt-0 md:col-span-1 lg:col-span-2 mx-auto lg:m-0">

                </div>
            </div>
        </div>
    </section>
    <!-- End -->
    <div>
        <div class="container max-w-[1170px] mx-auto   items-center h-full px-2.5 pb-6 ">
            <div class="mt-10">
                <div class="shadow-[0px_4px_30px_0px_rgba(0,0,0,0.1)] rounded-[32px] p-[20px] border-[1px] border-solid">
                    <div class="px-3">
                        <table class="w-full" id="tableCartProduct">
                            <thead>
                                <tr>
                                    <th
                                        class="border-b-2 text-left border-solid text-[#666666] uppercase text-[14px] font-bold tracking-wider">
                                        Sản phẩm</th>
                                    <th width="20%"
                                        class="border-b-2 text-left border-solid text-[#666666] uppercase text-[14px] font-bold tracking-wider">
                                        Giá</th>
                                    <th width="10%"
                                        class="border-b-2 text-left border-solid text-[#666666] uppercase text-[14px] font-bold tracking-wider">
                                        Số lượng</th>
                                    <th width="20%"
                                        class="border-b-2 text-right border-solid text-[#666666] uppercase text-[14px] font-bold tracking-wider">
                                        Số tiền</th>
                                    <th width="10%"
                                        class="border-b-2 text-right border-solid text-[#666666] uppercase text-[14px] font-bold tracking-wider">
                                        Thao tác</th>
                                </tr>
                            </thead>

                            <tbody>

                                @if (!empty($carts['cart']) && count($carts['cart']) > 0)
                                    @foreach ($carts['cart'] as $key=>$cart)

                                        <tr class="rowCart w-full border-solid border-b-[1px] border-b-gray-300"
                                            data-id="{{ $key ?? '' }}">
                                            <td class="p-2 ">
                                                <div class="flex">
                                                    <div class="w-20 mr-3">
                                                        <img src="{{ asset($cart['avatar'] ?? '') }}" />
                                                    </div>
                                                    <div>
                                                        <p class="text-[#919191] text-[14px]">{{ $cart['name'] ?? '' }}</p>
                                                        @if (!empty($cart['attribute']))
                                                            @php
                                                                $keys = array_keys($cart['attribute']);
                                                            @endphp
                                                            @foreach ($keys as $item)
                                                                <p class="text-[#d2d2d2] text-[12px]">{{ $item }} :
                                                                    {{ $cart['attribute'][$item] ?? '' }}</p>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-[16px] font-bold" data-price="{{ $cart['price']?? 0 }}">
                                                {{ number_format($cart['price'] ?? 0, 0, ',', '.') ?? 0}} ₫
                                            </td>

                                            <td>
                                                <div class="relative flex items-center">
                                                    <button type="button" id="decrement-button"
                                                        data-input-counter-decrement="counter-input-{{ $key ?? '' }}"
                                                        class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                        <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 18 2">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                                        </svg>
                                                    </button>
                                                    <input type="text" id="counter-input-{{ $key ?? '' }}"
                                                        data-input-counter data-input-counter-min="1"
                                                        class="input-quantity flex-shrink-0 text-gray-900 dark:text-white border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center"
                                                        value="{{ $cart['quantity'] ?? 1 }}" required />
                                                    <button type="button" id="increment-button"
                                                        data-input-counter-increment="counter-input-{{ $key ?? '' }}"
                                                        class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                        <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 18 18">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M9 1v16M1 9h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>

                                            <td class="text-[16px] font-bold text-right" data-total-price="{{ $cart['total']?? 0 }}">
                                                {{ number_format($cart['total'] ?? 0, 0, ',', '.') ?? 0}} ₫
                                            </td>

                                            <td class="text-right">
                                                <button
                                                    class="delete-cart flex items-center justify-end w-full text-[#b5b5b5]"
                                                    data-id="{{ $key ?? '' }}">
                                                    <svg class="w-6 h-6 text-[#b5b5b5]" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="1"
                                                            d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                    Xoá
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="p-8">
                                            <div class="flex flex-col items-center justify-center w-full">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 3h18l-2 10H5l-2-10zM5 13h14v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6z" />
                                                </svg>
                                                <h2 class="text-2xl font-semibold text-gray-700 mb-2">Giỏ hàng của bạn
                                                    trống</h2>
                                                <p class="text-gray-500 mb-6">Hãy thêm sản phẩm để tiếp tục mua sắm.</p>
                                                <a href="{{ route('index') }}"
                                                    class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">Tiếp
                                                    tục mua sắm</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>

                    <div class="py-4">
                        <div class="flex">
                            <a href="{{ route('allProductCategories') }}"
                                class="mr-2 border-2 border-[#fe5b26] text-sm px-4 py-2 rounded-[100em] text-[#fe5b26] uppercase hover:bg-[#fe5b26] hover:text-white">
                                Xem sản phẩm
                            </a>

                            <button id="btnUpdateCart"
                                class="border-2 border-[#fe5b26] text-sm px-4 py-2 rounded-[100em] text-[#fe5b26] uppercase hover:bg-[#fe5b26] hover:text-white">
                                Cập nhật giỏ hàng
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="shadow-[0px_4px_30px_0px_rgba(0,0,0,0.1)] rounded-[10px] p-[20px] border-[1px] border-solid mt-5 relative overflow-hidden before:content-[''] before:bg-[-55px 0px] before:h-[4px] before:absolute before:left-0 before:top-0 before:right-0 before:bg-[url('../images/cart-border.jpg')]">

                <div class="grid grid-cols-12 gap-2">
                    <div class="col-span-7">
                        <div class="flex">
                            <svg class="w-6 h-6 text-[#fd5a26]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5"
                                    d="M12.0001 20v-4M7.00012 4h9.99998M9.00012 5v5c0 .5523-.46939 1.0045-.94861 1.279-1.43433.8217-2.60135 3.245-2.25635 4.3653.07806.2535.35396.3557.61917.3557H17.5859c.2652 0 .5411-.1022.6192-.3557.3449-1.1204-.8221-3.5436-2.2564-4.3653-.4792-.2745-.9486-.7267-.9486-1.279V5c0-.55228-.4477-1-1-1h-4c-.55226 0-.99998.44772-.99998 1Z" />
                            </svg>

                            <h1 class="uppercase text-[#fd5a26] font-bold ml-1">Địa chỉ nhận hàng</h1>
                        </div>
                        <div>
                            <div class="mt-3 px-2">
                                <div class="grid gap-2 mb-6 md:grid-cols-2">
                                    <div>
                                        <input type="text" id="name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#fd5a26] focus:border-[#fd5a26] block w-full p-2"
                                            placeholder="Họ và tên" />
                                             <div class="error-message text-[12px] mt-1" id="name-error" style="color: red;"></div>
                                    </div>
                                    <textarea id="note" rows="4"
                                        class="row-span-5 block p-2 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-[#fd5a26] focus:border-[#fd5a26] "
                                        placeholder="Nhập ghi chú cho chúng tôi"></textarea>
                                    <div class="grid gap-2 md:grid-cols-2">
                                        <div>
                                            <input type="text" id="email"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#fd5a26] focus:border-[#fd5a26] block w-full p-2"
                                                placeholder="Email" />
                                                 <div class="error-message text-[12px] mt-1" id="email-error" style="color: red;"></div>
                                        </div>

                                        <div>
                                            <input type="text" id="phone"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#fd5a26] focus:border-[#fd5a26] block w-full p-2"
                                                placeholder="Số điện thoại" />
                                                 <div class="error-message text-[12px] mt-1" id="phone-error" style="color: red;"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <select id="selectProvince"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#fd5a26] focus:border-[#fd5a26] block w-full p-2">
                                            <option value=" " >Tỉnh/Thành phố</option>

                                        </select>
                                         <div class="error-message text-[12px] mt-1" id="selectProvince-error" style="color: red;"></div>
                                    </div>

                                    <div>
                                        <select id="selectDistrict" disabled
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#fd5a26] focus:border-[#fd5a26] block w-full p-2">
                                            <option value=" " >Quận/Huyện</option>
                                        </select>
                                         <div class="error-message text-[12px] mt-1" id="selectDistrict-error" style="color: red;"></div>
                                    </div>

                                    <div>
                                        <select id="selectCommune" disabled
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#fd5a26] focus:border-[#fd5a26] block w-full p-2">
                                            <option value="" >Phường/Xã</option>
                                        </select>
                                         <div class="error-message text-[12px] mt-1" id="selectCommune-error" style="color: red;"></div>
                                    </div>

                                    <div>
                                        <input type="text" id="address"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#fd5a26] focus:border-[#fd5a26] block w-full p-2"
                                            placeholder="Toà nhà, Tên đường,..." />
                                             <div class="error-message text-[12px] mt-1" id="address-error" style="color: red;"></div>
                                    </div>

                                    <div>
                                        <button
                                            class="uppercase bg-[#757575] w-full px-4 py-2 rounded-[5px] text-sm text-white">
                                            Tải File Excel
                                        </button>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-span-5">
                        <div class="flex">
                            <svg class="w-6 h-6 text-[#fd5a26]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z" />
                            </svg>


                            <h1 class="uppercase text-[#fd5a26] font-bold ml-1">Hình thức thanh toán</h1>
                        </div>
                        <div class="mt-3 px-2">
                            <div class="flex mb-3 me-4">
                                <input checked id="default-radio-1" type="radio" name="default-radio" value="cash_on_delivery"
                                    class="payment_method w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                <label for="default-radio-1" class="ms-2 text-sm font-medium text-[#818181]">
                                    Thanh toán tiền mặt khi nhận hàng
                                </label>
                            </div>
                            <div class="flex mb-3 me-4">
                                <input  id="default-radio-2" type="radio" name="default-radio" value="payment_transfer"
                                    class="payment_method w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                <label for="default-radio-2" class="ms-2 text-sm font-medium  text-[#818181]">
                                    Thanh toán chuyển khoản qua tài khoản ngân hàng (khuyên dùng)
                                </label>
                            </div>

                            <div class="flex rounded-lg overflow-hidden">
                                <input placeholder="Mã Voucher" id="input-code"
                                    value="{{ !empty($voucher->name) ? $voucher->name : '' }}"
                                    class="w-2/3 placeholder:pr-5 rounded-s-xl bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-[#fd5a26] focus:border-[#fd5a26] block p-2" />
                                <button class="w-1/3 bg-red-500">
                                    <div class="flex items-center p-2">
                                        <svg class="w-6 h-6 text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M18.5 12A2.5 2.5 0 0 1 21 9.5V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v2.5a2.5 2.5 0 0 1 0 5V17a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-2.5a2.5 2.5 0 0 1-2.5-2.5Z" />
                                        </svg>
                                        <span class="text-[14px] ml-1 text-white" data-modal-target="voucher-modal"
                                            data-modal-toggle="voucher-modal">Nhập voucher</span>
                                    </div>
                                </button>
                            </div>
                            <p id="errorVoucerUnique"></p>
                        </div>

                        <div class="mt-3 px-2">
                            <div class="flex justify-between">
                                <p class="text-[#222222] text-sm">Giảm giá Voucher</p>
                                <p class="text-[#222222] text-sm" id="voucherSale">0đ</p>
                            </div>


                            <div class="mt-3 text-end">
                                <span class="text-[#AEAEAE]">
                                    Tổng tiền hàng( <span class="text-[#EB1F26]">{{ count($carts['cart']) }} sản
                                        phẩm</span> ):<span
                                        class="totalNumber font-bold text-[25px] ml-1 text-[#EB1F26]">{{ number_format($total, 0, ',', '.') }}đ</span>
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-3">
                            <button type="button" id="order-now"
                                class="focus:outline-none block uppercase text-white bg-[#EF4444] hover:bg-red-800 focus:ring-4 focus:ring-transparent font-medium rounded-lg text-sm px-5 py-2">
                                Đặt mua ngay
                            </button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Voucher Modal -->
    @include('client.cart.modalVoucher', ['getVouchers' => $getVouchers])
    <!-- End Voucher Modal -->
@endsection

@push('js')
    <script>
        var updateCartUrl = '{{ route('updateCart') }}';
        var deleteCartUrl = '{{ route('deleteCart') }}';
    </script>
    <script src="{{ asset('assets/client/js/cartOrder.js') }}"></script>
    <script src="{{ asset('assets/client/js/order.js') }}"></script>
@endpush
