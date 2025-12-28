<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterComponentContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'item',
        'link'
    ];
}
