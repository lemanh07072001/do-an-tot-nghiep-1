<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;

use App\Models\Categories;
use App\Models\ProductVariant;
use App\Models\RelatedProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sort_description',
        'images',
        'description',
        'avatar',
        'sku',
        'price',
        'price_sale',
        'status',
        'user_id',
        'label',
        'categories_id',
        'attributeCatalogue',
        'attributes',
        'variants'
    ];

    public function product_variants(){
        return $this->hasMany(ProductVariant::class,'products_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class);
    }

    public function relatedProducts()
    {
        return $this->hasMany(RelatedProduct::class);
    }

    public function groupProducts()
    {
        return $this->belongsToMany(GroupProduct::class);
    }


}
