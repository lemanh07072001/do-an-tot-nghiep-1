<?php

namespace App\Models;

use App\Models\User;
use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';



    protected $fillable = [
        'products_id',
        'code',
        'quantity',
        'price',
        'sku',
        'user_id',
    ];

    public function products(){
        return $this->belongsto(Products::class,'products_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
