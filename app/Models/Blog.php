<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title',
        'slug',
        'category_id',
        'content',
        'tags',
        'color',
        'is_published'
    ];

    protected $casts = [
        'tags' => 'array'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
