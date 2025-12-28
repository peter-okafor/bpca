<?php

namespace Database\Seeders;

use App\Models\Pest;
use App\Models\Service;
use App\Models\PestType;
use Illuminate\Support\Str;
use App\Enums\PestEnvironment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $services = [
            "Ants" => "ANT",
            "Bed bugs" => "BBUG",
            "Bee Removal" => "BEER",
            "Consultant" => "CON",
            "Cockroaches" => "CROACH",
            "Fleas" => "FLEAS",
            "Flies" => "FLIES",
            "Fox" => "FOX",
            "Humane Pest Control" => "HUMAN",
            "Moles" => "MOLES",
            "Mosquitos" => "MOSQ",
            "Moths" => "MOTH",
            "Non Chemical Pest Control" => "NCHEM",
            "Heat Treatment" => "NCHEM2",
            "Other Insects" => "OTHINS",
            "Other Mammals" => "OTHMAM",
            "Rabbits" => "RABBITS",
            "Rats and Drains" => "RAT",
            "Rats and Mice" => "SAB",
            "Birds" => "SBC",
            "Fumigation - Soil &amp; Compost (Commercial)" => "SFumA",
            "Fumigation - Buildings (Commercial)" => "SFumB",
            "Fumigation - Under Sheets (Commercial)" => "SFumC",
            "Fumigation - Containers (Commercial)" => "SFumD",
            "Fumigation - Ships (Commercial)" => "SFumE",
            "Fumigation - Aircraft (Commercial)" => "SFumF",
            "Fumigation - Bubble (Commercial)" => "SFumG",
            "Fumigation - Chamber (Commercial)" => "SFumH",
            "Squirrels" => "SQUIR",
            "Wasps" => "WASP",
            "Wildlife Management" => "WILD"
        ];
        $types = [
            'Crawling insect',
            'Mammal',
            'Parasite',
            'Flying insect',
            'Rodent',
            'Moth',
            'Mite',
            'Arachnid',
            'Larvae',
            'Birds',
            'Slugs',
            'Timber pest',
            'Biting insect'
        ];

        foreach ($types as $name) {
            PestType::updateOrCreate([
                'type' => $name,
            ], [
                'type' => $name,
                'slug' => Str::slug(Str::lower($name))
            ]);
        }

        foreach ($services as $name => $code) {
            Service::updateOrCreate([
                'code' => $code,
            ], [
                'name' => $name,
                'code' => $code
            ]);
        }

        $json = file_get_contents('https://filebin.net/c2muyv0qr6vuqg0d/pests.json');
        // $json = File::get("database/data/pests.json");
        $pests = json_decode($json);

        foreach ($pests as $pest) {
            $type = PestType::query()->firstWhere('type','=', $pest->PestType);
            Pest::updateOrCreate([
                'name' => $pest->Name
            ], [
                'name' => $pest->Name,
                'code' => Str::slug(Str::lower($pest->Name)),
                'listing_id' => $pest->ListingId,
                'abstract' => $pest->Introduction,
                'pest_type_id' => $type->id ?? null,
                'pest_environment' => PestEnvironment::fromKey($pest->Environment),
                'image_url' => $pest->PrimaryImage,
                'website_url' => $pest->DetailURL,
                'description' => $pest->Description,
                'show_in_a_to_z' => true
            ]);
        }
    }
}
