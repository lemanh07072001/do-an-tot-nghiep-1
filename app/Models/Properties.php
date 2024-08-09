<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Properties extends Model
{
    use HasFactory,NodeTrait;

    protected $fillable = [
        'name',
        'value',
        'slug',
        'parent_id',
        'status',
    ];
}
