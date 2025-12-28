<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

    protected $appends = [
        'image',
        'href',
        'count',
        'color',
        'taxonomy'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget("blog - categories");
            Cache::forget("blog - categories - 5");
        });

        static::deleted(function () {
            Cache::forget("blog - categories");
            Cache::forget("blog - categories - 5");
        });
    }

    protected function href (): Attribute
    {
        return Attribute::make(
            function () {
                return '/category/'.$this->attributes['name'];
            }
        );
    }

    protected function count (): Attribute
    {
        return Attribute::make(
            function () {
                return $this->posts()->count();
            }
        );
    }

    protected function color (): Attribute
    {
        return Attribute::make(
            function () {
                return 'pink';
            }
        );
    }

    protected function taxonomy (): Attribute
    {
        return Attribute::make(
            function () {
                return 'category';
            }
        );
    }



    public function posts ()
    {
        return $this->hasMany(BlogPost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->belongsToMany(BlogImage::class);
    }

    protected function image(): Attribute
    {
        return new Attribute(
            function () {
                $image = $this->images()->first()->image ?? "";
                return $image ? env("MIX_APP_AWS_S3") . $image : $image;
            }
        );
    }
}
