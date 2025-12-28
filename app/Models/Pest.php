<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pest extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'abstract',
        'description',
        'pest_environment',
        'image_url',
        'website_url',
        'show_in_a_to_z'
    ];

    /**
     * The organisations that belong to the Pest
     * @return BelongsToMany
     */
    public function organisations(): BelongsToMany
    {
        return $this->belongsToMany(Organisation::class);
    }

    public function pestType(): BelongsTo
    {
        return $this->belongsTo(PestType::class);
    }

    public function summary(): HasOne
    {
        return $this->hasOne(PestSummary::class);
    }

    /** 
     * Truncate pest description data
     */
    protected function description(): Attribute {
        return Attribute::make(
            get: function (string $value) {
                $pos = strpos($value, '</p>');
                if ($pos) {
                    $truncatedData = substr($value, 0, $pos + 4);
                }
                return $truncatedData ?? $value; 
            },
        );
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'pest_services');
    }
}
