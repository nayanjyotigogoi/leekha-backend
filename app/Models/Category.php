<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    // Optional: relationship to writings
    public function writings()
    {
        return $this->hasMany(Writing::class, 'category', 'name'); 
        // Or use category_id if you later store category as FK
    }
}
