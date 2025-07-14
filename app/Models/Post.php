<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'type', 'product_id', 'title', 'slug', 'excerpt', 'content', 'image', 'thumbnail',
        'tags', 'status', 'views', 'is_featured', 'start_date', 'end_date', 'author_id',
        'meta_title', 'meta_description'
    ];
    public function comments()
{
    return $this->hasMany(\App\Models\Comment::class);
}

public function reactions()
{
    return $this->hasMany(\App\Models\PostReaction::class);
}
public function product()
{
    return $this->belongsTo(\App\Models\Product::class, 'product_id');
}

public function author()
{
    return $this->belongsTo(\App\Models\User::class, 'author_id');
}

}
