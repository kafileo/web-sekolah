<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $table = 'information';

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'user_id',
        'excerpt',
        'content',
        'is_active',
        'published_date',
        'views_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
