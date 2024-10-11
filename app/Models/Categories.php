<?php

namespace App\Models;

use App\Models\Products;
use Spatie\Image\Enums\Fit;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Categories extends Model implements HasMedia
{
    use HasFactory, NodeTrait, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'hot',
        'slug',
        'parent_id',
        'user_id',
        'status',
        'image'
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('categories')
            ->nonQueued();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Products::class, 'categories_id');
    }
}
