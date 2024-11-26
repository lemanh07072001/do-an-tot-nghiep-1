<?php

namespace App\Services\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Banner;
use App\Models\OrderItem;
use App\Models\Properties;
use App\Exports\OrderExport;
use App\Helpers\FormatFunction;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class OrderService
{
    public function getData($request)
    {
        $searchInput = $request->searchInput;
        $searchStatus = $request->searchStatus;
        $searchMethod = $request->searchMethod;

        $filer = [];

        $query =  Order::query();

        $query = $query->with(['user']);

        if ($request->has('searchInput') && isset($searchInput)) {
            $query->where(function ($query) use ($searchInput) {
                $query->where('code_order', 'like', '%' . $searchInput . '%');
            });
        }

        if ($request->has('searchStatus') && isset($searchStatus)) {
            $query->where(function ($query) use ($searchStatus) {
                $query->where('status', 'like', '%' . $searchStatus . '%');
            });
        }

        if ($request->has('searchMethod') && isset($searchMethod)) {
            $query->where(function ($query) use ($searchMethod) {
                $query->where('payment_method', 'like', '%' . $searchMethod . '%');
            });
        }


        if (!empty($filer)) {
            $query = $query->where($filer);
        }


        return DataTables::of($query)
            ->addColumn('code_order', function ($order) {
                return '<div class="font-bold">' . $order->code_order . '</div>';
            })
            ->addColumn('order_date', function ($order) {
                return FormatFunction::formatDate($order->order_date);
            })
            ->addColumn('total_amount', function ($order) {
                return FormatFunction::formatPrice($order->total_amount);
            })
            ->addColumn('payment_method', function ($order) {
                return FormatFunction::paymentFormOrder($order);
            })
            ->addColumn('status', function ($order) {
                return FormatFunction::statusFormOrder($order);
            })
            ->addColumn('action', function ($order) {
                $actions = '';


                // Kiểm tra quyền xóa khuyến mãi
                if (auth()->user()->can('Xem đơn hàng')) {
                    $actions .= ' <button type="button" class="modal-order inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-400 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-400 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            <svg class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                        </button>';
                }

                // Nếu không có quyền nào thì trả về một thông báo hoặc HTML trống
                return $actions ?: '<span class="text-gray-500">Không có quyền</span>';
            })

            ->rawColumns(['code_order', 'order_date', 'total_amount', 'payment_method', 'status', 'action'])
            ->make(true);
    }

    public function statusOrder($request)
    {
        $id = $request->idOrder;
        $value = $request->value;

        $getOrder = Order::find($id);

        if ($getOrder) {
            // Lưu trạng thái cũ trước khi cập nhật
            $oldStatus = $getOrder->status;

            // Cập nhật trạng thái đơn hàng
            $getOrder->update(['status' => $value]);

            // Lấy danh sách sản phẩm trong đơn hàng
            $orderItems = $getOrder->orderItems;

            // Xử lý số lượng sản phẩm theo trạng thái mới
            foreach ($orderItems as $item) {
                $quantity = $item->quantity;

                if ($getOrder->status == 'cancelled') {
                    // Nếu đơn hàng bị hủy, cộng số lượng sản phẩm vào kho
                    $currentStock = $item->product_variant->product_variants;
                    $newQuantity = $currentStock + $quantity;

                    // Giả sử bạn có một biến $maxStock để xác định số lượng tối đa cho phép trong kho
                    $maxStock = $item->product_variant->quantity; // Thay đổi theo cách lưu trữ số lượng tối đa

                    // Đảm bảo rằng số lượng không vượt quá số lượng tối đa
                    if ($newQuantity > $maxStock) {
                        // Thông báo lỗi nếu số lượng sau khi cộng vượt quá số lượng tối đa
                        return response()->json([
                            'success' => false,
                            'message' => 'Số lượng sản phẩm không thể vượt quá số lượng tối đa trong kho.'
                        ], 400); // Mã lỗi 400 cho yêu cầu không hợp lệ
                    }

                    // Cập nhật số lượng sản phẩm vào kho
                    $item->product_variant->update(['product_variants' => $newQuantity]);
                } elseif ($oldStatus == 'cancelled' && ($getOrder->status == 'completed' || $getOrder->status == 'pending')) {
                    // Nếu đơn hàng trước đó bị hủy và bây giờ không còn bị hủy, trừ số lượng sản phẩm
                    $currentStock = $item->product_variant->product_variants;
                    $newQuantity = $currentStock - $quantity;



                    // Kiểm tra xem số lượng hủy có lớn hơn số lượng có sẵn không
                    if ($quantity > $currentStock) {
                        // Thông báo lỗi nếu số lượng hủy lớn hơn số lượng có sẵn
                        return response()->json([
                            'success' => false,
                            'message' => 'Số lượng hủy lớn hơn số lượng sản phẩm có sẵn trong kho.'
                        ], 400); // Mã lỗi 400 cho yêu cầu không hợp lệ
                    }

                    // Kiểm tra xem số lượng sau khi trừ có nhỏ hơn 0 không
                    if ($newQuantity <= 0) {
                        // Thông báo lỗi nếu số lượng sau khi trừ nhỏ hơn 0
                        return response()->json([
                            'success' => false,
                            'message' => 'Số lượng không thể nhỏ hơn 0.'
                        ], 400); // Mã lỗi 400 cho yêu cầu không hợp lệ
                    }


                    // Cập nhật số lượng nếu tất cả điều kiện đều đúng
                    $item->product_variant->update(['product_variants' => $newQuantity]);
                }
            }
            // Trả về thông báo thành công nếu không có lỗi xảy ra
            return response()->json([
                'success' => true,
                'message' => 'Trạng thái đơn hàng đã được cập nhật thành công.'
            ], 200);
        } else {
            // Thông báo lỗi nếu đơn hàng không tìm thấy
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng không tồn tại.'
            ], 404);
        }
    }

    public function getItemOrder($request)
    {
        $id = $request->idOrderItem;

        $getOrder = Order::find($id);

        if ($getOrder) {
            $dataOrder = [];
            $getOrderItems = $getOrder->orderItems;

            // Duyệt lấy từng orderItem
            foreach ($getOrderItems as $orderItem) {
                $nameProduct = '';
                // Lấy sản phẩm
                $getProduct = $orderItem->product_variant->products;

                $codeArray = explode(', ', $orderItem->product_variant->code);

                foreach ($codeArray as $code) {
                    $getProperties = Properties::where('status', 0)->where('id', $code)->first();

                    if ($getProperties) {
                        $nameProduct .= ' - ' . $getProperties->name;
                    }
                }


                $dataOrder[] = [
                    'sku' => $orderItem->product_variant->sku,
                    'name' => $getProduct->name . $nameProduct,
                    'product_variants' => $orderItem->product_variant->product_variants,
                ];
            }

            return response()->json([
                'success' => true,
                'orderCode' => $getOrder->code_order,
                'data' => $dataOrder
            ]);
        }

        return null;
    }

    public function excelOrder($request)
    {

        // Get the current year, date, and month
        $year = Carbon::now()->year;
        $date = Carbon::now()->day;
        $month = Carbon::now()->month;

        // Construct the file name for the exported Excel file
        $fileName = 'export/order/' . $year . '/' . $date . '-' . $month . '-' . time() . '.xlsx';


        // Use the Excel facade to store the exported data in the specified file path
        Excel::store(new OrderExport($request->id), $fileName, 'public');

        // Return a JSON response with the URL of the exported Excel file
        return response()->json([
            'file' => Storage::url($fileName)
        ]);
    }
}
