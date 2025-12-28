<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'avatar',
        'bgImage',
        'firstName',
        'displayName',
        'lastName',
    ];

    public function posts()
    {
        return $this->hasMany(BlogPost::class);
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }

    public function categories()
    {
        return $this->hasMany(BlogCategory::class);
    }

    public function images()
    {
        return $this->belongsToMany(BlogImage::class);
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            function () {
                $image = $this->images()->first()->image ?? null;

                return $image ? '/storage/'.$image : $image;
            }
        );
    }

    protected function getBgImageAttribute()
    {
        $image = $this->images()->first()->image ?? null;

        return $image ? '/storage/'.$image : $image;
    }

    protected function getFirstNameAttribute()
    {
        return strstr($this->attributes['name'], ' ', true);
    }

    protected function getDisplayNameAttribute()
    {
        return strstr($this->attributes['name'], ' ', true);
    }

    protected function getLastNameAttribute()
    {
        return str_replace(
            ' ',
            '',
            strstr($this->attributes['name'], ' ')
        );
    }
}
