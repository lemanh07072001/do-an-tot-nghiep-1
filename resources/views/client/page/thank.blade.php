@extends('client.layout.layoutMatter')

@section('content')
<div class="flex items-center justify-center min-h-screen p-6">

        <!-- Card -->
        <div class="w-full max-w-lg bg-[#f7f5f3] rounded-lg shadow-xl p-8">
            <!-- Success Message -->
            <div class="flex justify-center mb-6">
                <div class="flex items-center justify-center w-16 h-16 bg-green-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>

            <!-- Success Title -->
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-4">Thanh Toán Thành Công!</h2>
            <p class="text-center text-gray-600 mb-6">Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi. Đơn hàng của bạn đã được thanh toán thành công.</p>

            <!-- Order Details -->
            <div class="bg-gray-100 p-4 rounded-md shadow-sm mb-6">
                <h3 class="font-semibold text-lg text-gray-900 mb-2">Thông Tin Đơn Hàng</h3>
                <ul class="space-y-2 text-gray-700">
                    <li><strong>Mã Đơn Hàng:</strong> #987654</li>
                    <li><strong>Tổng Tiền:</strong> 1,250,000 VND</li>
                    <li><strong>Ngày Thanh Toán:</strong> 08/11/2024</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between">
                <a href="/" class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600 transition duration-300">Trở Về Trang Chủ</a>
                <a href="/orders" class="text-blue-500 py-2 px-6 rounded-lg border border-blue-500 hover:bg-blue-50 transition duration-300">Xem Đơn Hàng</a>
            </div>
        </div>

    </div>

@endsection
