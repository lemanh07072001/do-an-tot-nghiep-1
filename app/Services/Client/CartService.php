<?php

namespace App\Services\Client;

use App\Models\Voucher;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CartService
{
    public function getCart()
    {

        $cart = session()->get('cart', []);

        $data = [
            'cart' => $cart
        ];

        $total = array_reduce($cart, function ($sum, $item) {
            if (is_array($item) && isset($item['price']) && isset($item['quantity'])) {
                return $sum + ((int)$item['price'] * (int)$item['quantity']);
            }
            return $sum;
        }, 0);



        $order = [
            'data' => $data,
            'total' => $total,
        ];
        return $order;
    }
    public function addCart($request)
    {

        $dataAttribute = $request->data;

        $attributeID = $dataAttribute['id'];
        $attributeName = $dataAttribute['name'];
        $attributePriceSale = $dataAttribute['priceSale'];
        $attributePrice = $dataAttribute['price'];
        $attributeQuantity = $dataAttribute['quantity'];
        $attributeAvatar = $dataAttribute['avatar'];
        $attribute = $dataAttribute['attribute'];
        $idattribute = $dataAttribute['attributeID'];

        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);

        // Tạo một key duy nhất cho sản phẩm dựa trên id và thuộc tính
        $key = implode('-', array_values($idattribute));

        $priceProduct = 0;

        if ($attributePriceSale == '0') {
            $priceProduct = $attributePrice;
        } else {
            $priceProduct = $attributePriceSale;
        }

        // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng hay chưa
        if (isset($cart[$key])) {
            // Tăng số lượng nếu đã có
            $cart[$key]['quantity'] = $attributeQuantity;
            $cart[$key]['total'] = $priceProduct * $cart[$key]['quantity'];
        } else {
            // Thêm sản phẩm mới
            $cart[$key] = [
                'id' => $attributeID,
                'name' => $attributeName,
                'price' => $priceProduct,
                'avatar' => $attributeAvatar,
                'quantity' => $attributeQuantity,
                'attribute' => $attribute,
                'total' => $attributePriceSale * $attributeQuantity,
            ];
        }

        // Cập nhật lại giỏ hàng trong session
        session()->put('cart', $cart);

        // Tính tổng giá trị của giỏ hàng
        $totalCartValue = array_sum(array_column($cart, 'total'));

        // Phản hồi JSON
        return response()->json([
            'success' => 'Sản phẩm đã được thêm vào giỏ hàng',
            'cart' => $cart,
            'totalCartValue' => $totalCartValue,
            'totalItems' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    public function updateCart($request)
    {
        $data = $request->data;


        // Lấy dữ liệu giỏ hàng từ session
        $cart = session()->get('cart', []);

        foreach ($data as $value) {
            $id = $value['id'];


            // Kiểm tra nếu sản phẩm có trong giỏ hàng
            if (isset($cart[$id])) {
                // Cập nhật số lượng sản phẩm
                $cart[$id]['quantity'] = $value['quantity'];
                $cart[$id]['total'] = $cart[$id]['price'] * $value['quantity'];
            }
        }

        // $cart['nameVoucher'] = $nameVoucher;
        // Lưu giỏ hàng đã cập nhật lại vào session
        session(['cart' => $cart]);

        // Tính tổng giá trị của giỏ hàng
        $totalCartValue = array_sum(array_column($cart, 'total'));

        // Phản hồi JSON
        return response()->json([
            'success' => 'Giỏ hàng đã cập nhật thành công!',
            'cart' => $cart,
            'totalCartValue' => $totalCartValue,
            'totalItems' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    public function deleteCart($request)
    {
        $id = $request->get('id');
        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);

        // Kiểm tra nếu sản phẩm tồn tại trong giỏ hàng
        if (isset($cart[$id])) {
            // Xóa sản phẩm khỏi giỏ hàng
            unset($cart[$id]);

            // Cập nhật lại session giỏ hàng
            session(['cart' => $cart]);
        }

        // Tính tổng giá trị của giỏ hàng
        $totalCartValue = array_sum(array_column($cart, 'total'));

        // Phản hồi JSON
        return response()->json([
            'success' => 'Xoá sản phẩm thành công!',
            'cart' => $cart,
            'totalCartValue' => $totalCartValue,
            'totalItems' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    public function getVouchers()
    {
        $userId = !empty(Auth::user()->id);


        if ($userId) {
            $allVouchers = Voucher::doesntHave('orders')

                ->where(function ($query) {
                    $query->where('date_end', '>', Carbon::now())
                        ->orWhereNull('date_end'); // Lấy ra voucher có date_end là null

                })
                ->where('limit', '>', 0)                // limit lớn hơn 0
                ->where('status', 0)                    // status bằng 0
                ->whereColumn('unlimited', '<=', 'limit') // unlimited nhỏ hơn hoặc bằng limit
                ->orderBy('id', 'desc')
                ->get();

        } else {
            $allVouchers = [];
        }

        return $allVouchers;
    }

    public function checkVoucher($request)
    {

        $voucherCode = $request->name;



        // Retrieve the voucher
        $voucher = Voucher::where('name', $voucherCode)
            ->where(function ($query) {
                $query->where('date_end', '>', Carbon::now())
                    ->orWhereNull('date_end');
                $query->where('limit', '>', 0)
                    ->orWhereNull('limit');
            })
            ->where('status', 0)
            ->first();

        if (!$voucher) {
            return response()->json([
                'status' => false,
                'message' => 'Voucher không tồn tại hoặc không hợp lệ.'
            ]);
        }

        // Calculate cart total
        $cart = session()->get('cart', []);
        $total = array_reduce($cart, function ($sum, $item) {
            return $sum + ((int)$item['price'] * (int)$item['quantity']);
        }, 0);

        // Apply voucher discount to total
        $totalAfterDiscount = $total;
        if ($voucher->discount_type === 'vnd') {
            $totalAfterDiscount -= (int)$voucher->value_reduction;
        } elseif ($voucher->discount_type === '%') {
            $discountAmount = ($total * $voucher->value_reduction) / 100;
            $totalAfterDiscount -= $discountAmount;
        }

        // Ensure total is not negative
        $totalAfterDiscount = max($totalAfterDiscount, 0);

        return response()->json([
            'status' => true,
            'voucher' => $voucher,
            'total' => $totalAfterDiscount
        ]);
    }

}
