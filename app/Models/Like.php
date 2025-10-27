<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    public function target()
    {
        return $this->morphTo(); // can be Writing or Comment
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
