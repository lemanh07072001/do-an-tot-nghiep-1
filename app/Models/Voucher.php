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

    public function scopeActive($query)
    {
        return $query->where('status', 1); // Assuming 'status' field indicates if a voucher is active
    }

    public function scopeValid($query)
    {
        $now = now();
        return $query->where('date_start', '<=', $now)
            ->where('date_end', '>=', $now); // Adjust these fields if you have different validity fields
    }
}
