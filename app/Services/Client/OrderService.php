<?php

namespace App\Services\Client;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Voucher;
use App\Models\Products;
use App\Models\OrderItem;
use App\Rules\PhoneNumber;
use Illuminate\Support\Str;
use App\Helpers\FormatFunction;
use App\Services\Backend\VNPayService;
use App\Services\Backend\ZaloPayService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class OrderService
{

    function generateUniqueOrderCode()
    {
        do {
            $orderCode = 'ORD-' . Str::upper(Str::random(10));
        } while (Order::where('code_order', $orderCode)->exists());

        return $orderCode;
    }

    public function validateOrderData(array $data)
    {
        // Các quy tắc xác thực
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15', // Thay đổi độ dài tối đa nếu cần
            'selectDistrict' => 'required|string',
            'selectCommune' => 'required|string',
            'selectProvince' => 'required|string',
            'address' => 'required|string|max:500',
            'note' => 'nullable|string|max:1000',
            'payment_method' => 'required|string|in:cash_on_delivery,payment_transfer', // Thay đổi phương thức thanh toán nếu cần
            'voucher_code' => 'nullable|string|max:50',
        ];

        // Tạo validator
        $validator = Validator::make($data, $rules);

        // Kiểm tra xem có lỗi không
        if ($validator->fails()) {
            // Nếu có lỗi, trả về thông báo lỗi
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function order($request)
    {


        // Các quy tắc xác thực
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => [
                'required',
                'string',
                'max:10',
                new PhoneNumber()
            ],
            'selectDistrict' => 'required|string',
            'selectCommune' => 'required|string',
            'selectProvince' => 'required|string',
            'address' => 'required|string|max:500',
            'note' => 'nullable|string|max:1000',
            'payment_method' => 'required|string|in:cash_on_delivery,payment_transfer', // Thay đổi phương thức thanh toán nếu cần
            'voucher_code' => 'nullable|string|max:50',
        ];

        // Thông báo lỗi
        $messages = [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là chuỗi.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.string' => 'Số điện thoại phải là chuỗi.',
            'phone.max' => 'Số điện thoại không được vượt quá :max ký tự.',
            'selectDistrict.required' => 'Quận/huyện là bắt buộc.',
            'selectCommune.required' => 'Xã/phường là bắt buộc.',
            'selectProvince.required' => 'Tỉnh/thành phố là bắt buộc.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.string' => 'Địa chỉ phải là chuỗi.',
            'address.max' => 'Địa chỉ không được vượt quá 500 ký tự.',
            'note.string' => 'Ghi chú phải là chuỗi.',
            'note.max' => 'Ghi chú không được vượt quá 1000 ký tự.',
            'payment_method.required' => 'Phương thức thanh toán là bắt buộc.',
            'payment_method.in' => 'Phương thức thanh toán không hợp lệ.',
            'voucher_code.string' => 'Mã voucher phải là chuỗi.',
            'voucher_code.max' => 'Mã voucher không được vượt quá 50 ký tự.',
        ];

        // Tạo validator
        $validator = Validator::make($request->data, $rules, $messages);

        // Kiểm tra xem có lỗi không
        if ($validator->fails()) {
            // Trả về lỗi xác thực dưới dạng JSON
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $dataOrderAjax = $request->data;


        $cart = session()->get("cart", []);

        $codeOrder = $this->generateUniqueOrderCode();

        $addressOrder = $dataOrderAjax['address'] . ', ' . $dataOrderAjax['selectCommune'] . ', ' . $dataOrderAjax['selectDistrict'] . ', ' . $dataOrderAjax['selectProvince'];

        $totalCartValue = array_sum(array_column($cart, 'total'));

        $totalValue = $totalCartValue;

        $getVocher = null;
        if ($dataOrderAjax['voucher_code']) {
            $getVoucher = Voucher::where('name', $dataOrderAjax['voucher_code'])
                ->where(function ($query) {
                    $query->where('date_end', '>', Carbon::now())
                        ->orWhereNull('date_end'); // Lấy ra voucher có date_end là null

                })
            ->where('limit', '>', 0)                // limit lớn hơn 0
            ->where('status', 0)                    // status bằng 0
            ->whereColumn('unlimited', '<=', 'limit') // unlimited nhỏ hơn hoặc bằng limit
            ->first();

            if ($getVoucher != null) {

                if ($getVoucher->discount_type == 'vnd') {
                    $totalValue = $totalCartValue - $getVoucher->value_reduction;

                    $totalValue = max($totalValue, 0);
                } else if ($getVoucher->discount_type == '%') {

                    $discountAmount = ($totalCartValue * $getVoucher->value_reduction) / 100; // Giảm giá theo phần trăm
                    $totalValue = $totalCartValue - $discountAmount;

                    // Đảm bảo không giảm giá trị tổng nhỏ hơn 0
                    $totalValue = max($totalValue, 0);
                }
            }
        }



        $dataOrder = [
            'code_order' => $codeOrder,
            'order_date' => FormatFunction::getDatetime(),
            'total_amount' => $totalValue,
            'name' => $dataOrderAjax['name'],
            'phone' => $dataOrderAjax['phone'],
            'email' => $dataOrderAjax['email'],
            'note' => $dataOrderAjax['note'],
            'shipping_address' => $addressOrder,
            'voucher_code' => $dataOrderAjax['voucher_code'],
            'payment_method' => $dataOrderAjax['payment_method'],
            'status' => 'pending',
            'user_id' => Auth::id(),
        ];

        if ($dataOrderAjax['payment_method'] == 'payment_transfer') {
            $dataOrderVNPay = [
                'code_order' => $codeOrder,
                'total' => $totalValue,
            ];
            $VNPay = new VNPayService($dataOrderVNPay);
            $orderVNPay = $VNPay->payment();
            return response()->json([
                'type' => 'payment_transfer',
                'data' => $orderVNPay
            ]);
        }


        $dataInsertOrder = Order::create($dataOrder);

        if ($dataInsertOrder) {
            foreach ($cart as $key => $item) {

                $getProducts = Products::with(['product_variants' => function ($query) use ($key) {
                    $query->where('code', str_replace("-", ", ", $key));
                }])->where('status', 0)->get();



                foreach ($getProducts as $product) {

                    // Kiểm tra nếu có bất kỳ biến thể nào thỏa mãn
                    foreach ($product->product_variants as $variant) {

                        foreach($cart as $item){
                            $newQuantity = $variant->quantity - $item['quantity'];
                            $variant->update(['product_variants'=>$newQuantity]);
                        }
                        $dataOrderItem = [
                            'order_id' => $dataInsertOrder->id,
                            'product_variant_id' => $variant->id,
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                            'total_price' => $item['total'],
                        ];

                        // Tạo OrderItem, sử dụng model OrderItem
                        OrderItem::create($dataOrderItem);
                    }
                }
            }

            if($getVocher){

                if ($getVoucher->discount_type == 'vnd') {
                    $totalValue = $totalCartValue - $getVoucher->value_reduction;

                    $totalValue = max($totalValue, 0);
                } else if ($getVoucher->discount_type == '%') {

                    $discountAmount = ($totalCartValue * $getVoucher->value_reduction) / 100; // Giảm giá theo phần trăm

                    // Đảm bảo không giảm giá trị tổng nhỏ hơn 0
                    $totalValue = max($totalValue, 0);
                }

                $dataInsertOrder->voucher()->sync($getVocher->id,['user_id' => Auth::id()]);

                $getVocher->update(['unlimited' => $getVocher->unlimited + 1]);


            }

            session()->forget('cart');

            return response()->json([
                 'type' => 'cash_on_delivery',
                'status' =>'success',
                'message'=> 'Bạn đã đặt hàng thành công!',
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Lỗi hệ thống vui lòng thử lại sau!',
            ]);
        }

    }
}
