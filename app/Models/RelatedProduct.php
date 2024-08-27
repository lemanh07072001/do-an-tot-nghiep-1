<?php

namespace App\Models;

use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RelatedProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'products_id',

    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
