<?php

namespace App\Models;

use App\Models\User;
use App\Models\Client;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory ,NodeTrait;

    protected $fillable = [

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function products()
    {
        return $this->belongsTo(Products::class);
    }

}
