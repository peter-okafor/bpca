<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PestSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'pest_id',
        'count',
        'date'
    ];

    public function pests(): BelongsTo
    {
        return $this->belongsTo(Pest::class, 'pest_id');
    }
}
