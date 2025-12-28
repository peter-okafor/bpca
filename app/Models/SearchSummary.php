<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SearchSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'key',
        'stat'
    ];
}
