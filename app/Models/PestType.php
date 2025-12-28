<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PestType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type'
    ];

    public function count():Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->pests()->count(),
        )->shouldCache();
    }

    public function pests(): HasMany
    {
        return $this->hasMany(Pest::class);
    }
}
