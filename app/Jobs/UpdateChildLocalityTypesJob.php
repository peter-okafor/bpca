<?php

namespace App\Jobs;

use App\Models\Locality;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateChildLocalityTypesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Locality $locality;

    /**
     * Create a new job instance.
     * @return void
     */
    public function __construct(int|Locality $locality)
    {
        if ($locality instanceof int) {
            $locality = Locality::find($locality);
        }
        $this->locality = $locality;
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        $children = Locality::where('parent_locality_id', '=', $this->locality->id)
            ->get();
        foreach ($children as $locality) {
            $locality->type = $this->locality->type->nextLevelDown();
            $locality->save();
        }
    }
}
