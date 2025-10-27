<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Writing extends Model
{
    use HasFactory;
    protected $fillable = [
        'author_id', 'title', 'category', 'preview', 'content', 'reading_time', 'likes_count'
    ];

     // 🔗 Relationships
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'target');
    }

    // public function comments()
    // {
    //     return $this->hasMany(Comment::class);
    // }

}
