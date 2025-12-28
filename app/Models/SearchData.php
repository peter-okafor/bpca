<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SearchData extends Model
{
    use HasFactory;

    protected $fillable = [
        'postcode_id',
        'service',
        // 'premises',
        'session_id'
    ];

    public function postcode()
    {
        return $this->belongsTo(Postcode::class, 'postcode_id');
    }
}
