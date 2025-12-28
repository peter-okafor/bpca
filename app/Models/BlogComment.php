<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'author_name',
        'author_email',
        'blog_post_id',
        'parent_id',
        'approved'
    ];

    protected $casts = [
        'approved' => 'boolean'
    ];

    protected $appends = [
        'author',
        'date',
        'like',
        'children'
    ];

    // RELATIONSHIPS
    public function post()
    {
        return $this->belongsTo(BlogPost::class, 'blog_post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    // APPENDS
    protected function author(): Attribute
    {
        return new Attribute(
            function () {
                $user = $this->user;

                return [
                    'email' => $user->email ?? $this->attributes['author_email'],
                    'firstName' => $user->firstName ?? $this->getFirstName($this->attributes['author_name']),
                    'lastName' => $user->lastName ?? $this->getLastName($this->attributes['author_name']),
                    'displayName' => $user->displayName ?? $this->getFirstName($this->attributes['author_name']),
                    'avatar' => 'https://cdn.pixabay.com/photo/2022/08/25/23/06/woman-7411414_1280.png',
                ];
            }
        );
    }

    public function children(): Attribute
    {
        return Attribute::make(
            function () {
                return $this->comment()->where('approved', true)->get();
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


    private function getFirstName(string $fullname)
    {
        return array_pad(explode(' ', $fullname), 2, '')[0];
    }

    private function getLastName(string $fullname)
    {
        return array_pad(explode(' ', $fullname), 2, '')[1];
    }
}
