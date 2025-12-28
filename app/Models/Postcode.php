<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\MySpatialBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;

class Postcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'geodata',
        'geopoint',
    ];

    protected $casts = [
        'geodata' => Polygon::class,
        'geopoint' => Point::class,
    ];

    public function organisations(): BelongsToMany
    {
        return $this->belongsToMany(Organisation::class, 'organisation_locations', 'postcode_id', 'organisation_id');
    }

    public function newEloquentBuilder($query): MySpatialBuilder
    {
        return new MySpatialBuilder($query);
    }

    public static function query(): MySpatialBuilder
    {
        return parent::query();
    }

    public function localities(): BelongsToMany
    {
        return $this->belongsToMany(Locality::class, 'postcode_localities');
    }
}
