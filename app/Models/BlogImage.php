<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'alt'
    ];

    // public function getKeyName()
    // {
    //     return 'alt';
    // }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blogImage) {
            if (!$blogImage->alt) {
                $pathInfo = pathinfo($blogImage->image);
                $blogImage->alt = $pathInfo['filename'];
            }
        });
    }

    public function post()
    {
        return $this->belongsToMany(BlogPost::class);
    }

    public function category()
    {
        return $this->belongsToMany(BlogCategory::class);
    }
}
