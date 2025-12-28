<?php

namespace Tests\Unit;

use App\Models\Organisation;
use App\Services\Omnet\UpdateOrganisation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateOrganisationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test populating with features.
     *
     * @return void
     */
    public function test_populate()
    {
        $organisation = Organisation::factory()->create();
        $populator = new UpdateOrganisation(Organisation::find($organisation->id));
        $features = [
            'features' => 'test feature',
            'description' => 'test description',
            'contact_hours' => 'test contact',
        ];

        $populator->populate($features);

        $this->assertDatabaseHas('organisations', $features);
    }
}
