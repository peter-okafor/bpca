<?php

namespace App\Jobs\Locality;

use App\Enums\LocalityTypeEnum;
use App\Models\Locality;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Locale;
use MatanYadaev\EloquentSpatial\Objects\Point;

class SeedData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $uk_towns;
    /**
     * Create a new job3 instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->uk_towns = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $county_cache = collect();
        foreach ($this->uk_towns as $town) {

            $parent = $county_cache->where('name', '=', $town->County)->first();
            
            if (empty($parent)) {
                $parent = Locality::whereName($town->County)->whereType(LocalityTypeEnum::County())->get()->first();
                $county_cache->add($parent);
            }

            Locality::updateOrCreate([
                'name' => $town->Place,
                'type' => LocalityTypeEnum::Town()
            ], [
                'name' => $town->Place,
                'description' => $town->Place,
                'parent_locality_id' => $parent->id ?? null,
                'type' => LocalityTypeEnum::Town(),
                'has_locality_data' => true,
                'latlng' => $this->coordText($town->Latitude, $town->Longitude),
            ]);
        }
    }

    private function coordText($lat, $lng): ?Point
    {
        if (empty($lat) || empty($lng)) {
            return null;
        }

        return new Point($lat, $lng, 4326); //'Point('.$lat.' '.$lng.')';
    }
}
