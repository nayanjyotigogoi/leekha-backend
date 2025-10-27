<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

     protected $fillable = [
        'writing_id', 'parent_id', 'author_name', 'author_email', 'content', 'likes_count'
    ];

    // 🔗 Relationships
    public function writing()
    {
        return $this->belongsTo(Writing::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'target');
    }   
}
