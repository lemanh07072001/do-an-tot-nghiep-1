<?php

namespace App\Imports;

use App\Models\User;
use Laravolt\Avatar\Avatar;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UsersImport implements ToModel, WithUpserts, WithChunkReading, WithHeadingRow, ShouldQueue
{



    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => $row['password'],
        ]);
    }

    public function uniqueBy()
    {
        return 'email';
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}
