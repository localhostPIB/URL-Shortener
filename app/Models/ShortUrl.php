<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    protected $fillable = [
        'original_url',
        'short_url',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];
}
