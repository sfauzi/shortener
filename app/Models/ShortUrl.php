<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'original_url',
        'keyword',
        'title',
        'short_url',
        'qrcode_path',
        'clicks',
    ];
}
