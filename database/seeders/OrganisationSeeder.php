<?php

namespace Database\Seeders;

use App\Jobs\UpdateOrganisationInformation;
use App\Models\Organisation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;


class OrganisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents('https://filebin.net/c2muyv0qr6vuqg0d/organisations.json');
        // $json = File::get("database/data/organisations.json");
        $orgs = json_decode($json);
        foreach ($orgs as $organisation) {
            $organisation->Latitude = $organisation->Position->Latitude;
            $organisation->Longitude = $organisation->Position->Longitude;
            unset($organisation->Position);
            (new UpdateOrganisationInformation((array) $organisation))->handle();
        }
    }
}
