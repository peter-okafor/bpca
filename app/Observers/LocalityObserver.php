<?php

namespace App\Observers;

use App\Models\Locality;
use App\Jobs\UpdateLocalityTypeJob;

class LocalityObserver
{
    /**
     * Handle events after all transactions are committed.
     * @var bool
     */
    public bool $afterCommit = true;

    /**
     * Handle the Locality "created" event.
     *
     * @param  \App\Models\Locality  $locality
     *
     * @return void
     */
    public function created(Locality $locality)
    {
        //
    }

    /**
     * Handle the Locality "updated" event.
     *
     * @param  \App\Models\Locality  $locality
     *
     * @return void
     */
    public function updated(Locality $locality)
    {
//        ray($locality);
//        if ($locality->isDirty('parent_locality_id')) {
//            UpdateLocalityTypeJob::dispatch($locality);
//        }
    }

    /**
     * Handle the Locality "deleted" event.
     *
     * @param  \App\Models\Locality  $locality
     *
     * @return void
     */
    public function deleted(Locality $locality)
    {
        //
    }

    /**
     * Handle the Locality "restored" event.
     *
     * @param  \App\Models\Locality  $locality
     *
     * @return void
     */
    public function restored(Locality $locality)
    {
        //
    }

    /**
     * Handle the Locality "force deleted" event.
     *
     * @param  \App\Models\Locality  $locality
     *
     * @return void
     */
    public function forceDeleted(Locality $locality)
    {
        //
    }
}
