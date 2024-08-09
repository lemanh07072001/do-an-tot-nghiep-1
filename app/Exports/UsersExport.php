<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class UsersExport implements FromCollection, WithHeadings, WithColumnWidths, WithMapping
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
        return User::whereIn('id', $this->id)->select(['id', 'name', 'email', 'status', 'created_at'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Status',
            'Created_at'
            // Add other column headings as needed
        ];
    }

    public function map($user): array
    {
        $status = $user->status == 0 ? 'Active' : 'Inactive';
        return [
            $user->id,
            $user->name,
            $user->email,
            $status,
            Carbon::parse($user->created_at)->format('d-m-y H:i:s'),
            // Adjust the date format as per your requirement
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 20,
            'C' => 30,
            'D' => 15,
            'E' => 30,
        ];
    }
}
