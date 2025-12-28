<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SearchResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'search_data_id',
        'organisation_id'
    ];

    public function searchData()
    {
        return $this->belongsTo(SearchData::class, 'search_data_id');
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }
}
