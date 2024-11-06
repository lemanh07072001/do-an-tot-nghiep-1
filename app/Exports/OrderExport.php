<?php

namespace App\Exports;

use App\Helpers\FormatFunction;
use Carbon\Carbon;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class OrderExport implements FromCollection,WithHeadings, WithColumnWidths, WithMapping
{
    protected $id;

    public function __construct($request)
    {
        $this->id = $request;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::whereIn('id', $this->id)->get();
    }

    public function headings(): array
    {
        return [
            'Mã đơn hàng',
            'Ngày tạo',
            'Họ tên',
            'Email',
            'Điện thoại',
            'Địa chỉ',
            'Tổng tiền',
            'Hình thức thanh toán',
            'Trạng thái'
            // Add other column headings as needed
        ];
    }

    public function map($order): array
    {
        if($order->status == 'pending'){
            $status = 'Đang chờ xử lý';
        }else if($order->status == 'completed'){
            $status = 'Đã xử lý';
        }else{
            $status = 'Đã huỷ';
        }

        $price = FormatFunction::formatPrice($order->total_amount);


        if($order->payment_method == 'cash_on_delivery'){
            $method = 'Thanh toán khi nhận hàng';
        }else{
            $method = 'Thanh toán chuyển khoản';
        }

        return [
            $order->code_order,
            Carbon::parse($order->order_date)->format('d-m-y H:i:s'),
            $order->name,
            $order->email,
            $order->phone,
            $order->shipping_address,
            $price,
            $method,
            $status,
            // Adjust the date format as per your requirement
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 30,
            'F' => 30,
            'G' => 20,
            'H' => 30,
            'I' => 20,
        ];
    }
}
