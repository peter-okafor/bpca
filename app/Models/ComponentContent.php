<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'component',
        'content'
    ];
}
