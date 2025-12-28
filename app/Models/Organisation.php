<?php

namespace App\Models;

use App\Services\MySpatialBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Organisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'name',
        'services',
        'premises_type',
        'logo_url',
        'address_1',
        'address_2',
        'town',
        'postcode',
        'contact_hours',
        'description',
        'geodata',
        'email',
        'telephone',
        'mobile',
        'features',
        'accreditation_year',
    ];

    protected $casts = [
        'geodata' => Point::class,
        'features' => 'array',
    ];

    //region RELATIONSHIPS

    /**
     * The pests that the organisation covers
     * @return BelongsToMany
     */
    public function pests(): BelongsToMany
    {
        return $this->belongsToMany(Pest::class);
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Postcode::class, 'organisation_locations', 'organisation_id', 'postcode_id');
    }

    public function searches(): BelongsToMany
    {
        return $this->belongsToMany(SearchData::class, 'search_results', 'organisation_id', 'search_data_id');
    }

    //endregion

    //region HELPERS
    public function newEloquentBuilder($query): MySpatialBuilder
    {
        return new MySpatialBuilder($query);
    }
    
    public static function query(): MySpatialBuilder
    {
        return parent::query();
    }

    //endregion

    public function allservices(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'organisation_services');
    }

    protected function fallbackLogo(): Attribute
    {
        return Attribute::make(
            function () {
                return asset('/images/BPCA-member-logo-400-400.png');
            }
        );
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->name, '-');
    }

    public static function addSlugToData($organisations)
    {
        return $organisations->map(function ($org) {
            $org->slug = Str::slug($org->name);
            return $org;
        });
    }
}
