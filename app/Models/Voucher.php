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
        'date_start',
        'date_end',
        'user_id'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'voucher_user');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_voucher')
            ->withTimestamps();
    }


}
