<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'preview',
        'description',
        'category_id',
        'thumbnail',
    ];
    protected $with = [
        'category',
        'comments',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy("created_at", 'DESC');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class)->orderBy("created_at", 'DESC');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
