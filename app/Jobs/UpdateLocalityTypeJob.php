<?php

namespace App\Jobs;

use App\Models\Locality;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateLocalityTypeJob implements ShouldQueue
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
        $parent = Locality::select(['type'])->find($this->locality->parent_locality_id);
        if (!is_null($parent)) {
            $parentType = $parent->type;

            $this->locality->type = $parentType->nextLevelDown();
            $this->locality->saveQuietly();
        }
    }
}
