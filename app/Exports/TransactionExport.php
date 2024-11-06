<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Properties;
use App\Models\ProductVariant;
use App\Helpers\FormatFunction;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class TransactionExport implements FromCollection,WithHeadings,WithMapping,WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id;

    public function __construct($request)
    {
        $this->id = $request;
    }

    public function collection()
    {
        $data =  ProductVariant::whereIn('id', $this->id)
            ->with('products',function($query){
                $query->select(['id', 'name']);
            })
            ->select([ 'sku', 'price','code','quantity','products_id', 'product_variants', 'created_at'])->get();

        return $data;
    }

    public function headings(): array
    {
        return [
            'SKU',
            'Tên sản phẩm',
            'Gía tiền',
            'Số lượng',
            'Đã bán',
            'Ngày tạo'
            // Add other column headings as needed
        ];
    }

    public function map($product): array
    {
        $name = $product->products->name;
        $getCodeArray = explode(',', $product->code);

        // Retrieve properties based on IDs
        $properties = Properties::where('status', 0)->whereIn('id', $getCodeArray)->get();

        // Concatenate property names
        $getName = '';
        foreach ($properties as $property) {
            $getName .= ' - ' . $property->name;
        }

        $dataName = htmlspecialchars($name . $getName);


        $price = number_format($product->price, 0, ',', '.') . ' đ';


        return [
            $product->sku,
            $dataName,
            $price,
            $product->quantity,
            $product->product_variants,

            Carbon::parse($product->created_at)->format('d-m-y H:i:s'),
            // Adjust the date format as per your requirement
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 40,
            'C' => 20,
            'D' => 25,
            'E' => 25,
            'F' => 60,
        ];
    }
}
