<?php

namespace App\Models;

use App\Enums\LocalityTypeEnum;
use Illuminate\Support\Collection;
use App\Jobs\UpdateLocalityTypeJob;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\UpdateChildLocalityTypesJob;
use App\Services\MySpatialBuilder;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mostafaznv\NovaMapField\Traits\HasSpatialColumns;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Locality extends Model
{
    use HasSpatialColumns;
    use HasFactory;

    protected $casts = [
        'type' => LocalityTypeEnum::class,
        'has_locality_data' => 'boolean',
        'geodata' => Polygon::class,
        'latlng' => Point::class
    ];

    protected $fillable = [
        'name',
        'type',
        'parent_locality_id',
        'description',
        'stats',
        'latlng',
        'geodata'
    ];

    protected $appends  = [
        'link',
        'organisations'
    ];

    ///
    ///

    public function parentLocality(): BelongsTo
    {
        return $this->belongsTo(Locality::class, 'parent_locality_id');
    }

    public function postcodes(): BelongsToMany
    {
        return $this->belongsToMany(Postcode::class, 'postcode_localities');
    }

    public function subLocalities(): HasMany
    {
        return $this->hasMany(Locality::class, 'parent_locality_id');
    }

    protected function allPostcodes(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->getPostcodes()->sortBy('title'),
        )->shouldCache();
    }

    protected function organisations(): Attribute
    {
        // return Attribute::make(
        //     get: fn($value) => $this->geodata ? Organisation::query()->whereIntersects('geodata', $this->geodata)->orderByDistance('geodata', $this->geodata, 'asc')->with('pests')->get() : null,
        // )->shouldCache();

        return Attribute::make(
            get: function ($value) {
                if (!$this->geodata) {
                    return null;
                }

                try {
                    return Organisation::query()
                    ->whereIntersects('geodata', $this->geodata)
                    ->orderByDistance('geodata', $this->geodata, 'asc')
                    ->with(['allservices.pests'])
                    ->get();
                } catch (\Exception $e) {
                    // Log the error if necessary
                    // \Log::error("Error fetching organisations: " . $e->getMessage());

                    // Return an empty collection if an error occurs
                    return null;
                }
            }
        )->shouldCache();
    }

    protected function link(): Attribute
    {
        return Attribute::make(
            get: function($value) {
                $link = '';
                
                $lineage = $this->lineage();

                foreach ($lineage as $key => $locality) {
                    if ($lineage->keys()->first() === $key) {
                        $locality = 'in-' . $locality;
                    }
                    $link .= '/' . Str::slug($locality);
                }

                $id = Locality::where('name', $this->attributes['name'])->pluck('id')->first();

                if ($link) {
                    $link .= '/' . Str::slug($this->attributes['name']);
                    return '/pest-controllers' . strtolower($link) . '/' . $id;
                } else {
                    $link .= Str::slug($this->attributes['name']);
                    return '/pest-controllers/in-' . strtolower($link) . '/' . $id;
                }
            }
        )->shouldCache();
    }

    /**
     * The "booted" method of the model.
     * @return void
     */
    protected static function booted()
    {
        static::saved(function ($locality) {
            if ($locality->isDirty('parent_locality_id')) {
                // UpdateLocalityTypeJob::dispatch($locality);
            }
            if ($locality->isDirty('type')) {
                // UpdateChildLocalityTypesJob::dispatch($locality);
            }
        });
    }

    protected function getPostcodes(): Collection
    {
        $codes = $this->postcodes()->get(['id', 'title']);

        $childLocalities = $this->subLocalities()->get(['id']);

        foreach ($childLocalities as $locality) {
            $codes = $codes->merge($locality->getPostcodes());
        }

        return $codes;
    }

    public function newEloquentBuilder($query): MySpatialBuilder
    {
        return new MySpatialBuilder($query);
    }

    public static function query(): MySpatialBuilder
    {
        return parent::query();
    }


    private function lineage()
    {
        $parents = collect([]);
        $parent = $this->parentLocality;
        
        while (!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parentLocality;
        }

        return $parents->reverse()->pluck('name', 'id');
    }

}
