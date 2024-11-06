<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_order',
        'order_date',
        'total_amount',
        'name',
        'email',
        'phone',
        'note',
        'shipping_address',
        'payment_method',
        'user_id',
        'status',
    ];

    public function voucher()
    {
        return $this->belongsToMany(Voucher::class, 'order_voucher')
            ->withPivot('user_id')
            ->withTimestamps();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
