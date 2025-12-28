<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use HasFactory;

    const WORDS_PER_MINUTE = 300;

    protected $hidden = [
        'blogComments'
    ];

    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'user_id',
        'blog_category_id',
        'published',
        'slug',
        'meta',
        'seo_title',
        'likes'
    ];

    protected $casts = [
        'published' => 'boolean',
        'meta' => 'array',
    ];

    protected $appends = [
        'featuredImage',
        'date',
        'href',
        'desc',
        'shortContent',
        'like',
        'bookmark',
        'commentCount',
        'viewdCount',
        'readingTime',
        'postType',
        'categories',
        'author',
        'tags',
        'comments'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($post) {
            Cache::forget("blog - post - {$post->slug}");
            Cache::forget("blog - recent - posts");
            Cache::forget("blog - related - posts - post - {$post->slug}");
        });

        static::deleted(function ($post) {
            Cache::forget("blog - post - {$post->slug}");
            Cache::forget("blog - recent - posts");
            Cache::forget("blog - related - posts - post - {$post->slug}");
        });
    }

    // RELATIONSHIPS
    public function blogComments()
    {
        return $this->hasMany(BlogComment::class);
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id', 'id');
    }

    public function images()
    {
        // return $this->belongsToMany(BlogImage::class);
        return $this->belongsToMany(BlogImage::class)
            ->withPivot('blog_image_id', 'blog_post_id')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // APPENDS
    protected function comments(): Attribute
    {
        return Attribute::make(
            function () {
                return $this->blogComments()->where([
                    'parent_id' => null,
                    'approved' => true
                ])->get();
            }
        );
    }

    protected function tags(): Attribute
    {
        return Attribute::make(
            function () {
                return [$this->category];
            },
        );
    }

    protected function author(): Attribute
    {
        return Attribute::make(
            function () {
                return $this->user;
            },
        );
    }

    protected function categories(): Attribute
    {
        return Attribute::make(
            function () {
                return [$this->category];
            },
        );
    }

    protected function getPostTypeAttribute()
    {
        return "standard";
    }

    protected function getReadingTimeAttribute()
    {
        return (int) floor(strlen($this->attributes['content']) / self::WORDS_PER_MINUTE);
    }

    protected function getViewdCountAttribute()
    {
        return 0;
    }

    protected function getCommentCountAttribute()
    {
        return count($this->comments ?? []);
    }

    protected function bookmark(): Attribute
    {
        return Attribute::make(
            function () {
                return [
                    'count' => 0,
                    'isBookmarked' => false
                ];
            },
        );
    }

    protected function like(): Attribute
    {
        return Attribute::make(
            function () {
                return [
                    'count' => 0,
                    'isLiked' => false
                ];
            },
        );
    }

    protected function desc(): Attribute
    {
        return Attribute::make(
            function () {
                return $this->attributes['subtitle'];
            },
        );
    }

    protected function href(): Attribute
    {
        return Attribute::make(
            function () {
                return '/page/' . $this->attributes['slug'];
            },
        );
    }

    protected function date(): Attribute
    {
        return Attribute::make(
            function () {
                return $this->attributes['created_at'];
            },
        );
    }

    protected function getFeaturedImageAttribute()
    {
        $image = $this->images()->first()->image ?? "";
        return $image ? env("MIX_APP_AWS_S3") . $image : $image;
        // return 'https://cdn.pixabay.com/photo/2013/09/11/12/01/biological-181237_1280.jpg';
    }

    public function getShortContentAttribute()
    {
        $content = strip_tags($this->content);

        $content = trim(preg_replace('/\s\s+/', ' ', $content));

        $sentences = explode(".", $content);
        $firstSentence = $sentences[0];

        $words = explode(" ", $firstSentence);

        $shortContent = implode(" ", array_slice($words, 0, 10));

        return $shortContent .= "...";
    }
}
