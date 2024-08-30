<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'discount_type',
        'value_reduction',
        'limit',
        'status',
        'time',
        'date_start',
        'date_end',
        'user_id'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
