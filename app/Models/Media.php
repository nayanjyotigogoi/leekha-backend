<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
     protected $fillable = [
        'type',
        'path',
        'alt_text',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];
}
