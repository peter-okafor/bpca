<?php
namespace App\Services\Omnet;

use App\Models\Organisation;
use App\Services\Helpers\MyArr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

/**
 * Link Pest and Organisation using services
 */
class OrganisationPestSync 
{
    private $organisation;
    private $pests;
    private $pestDictionary = [
        "ANT" => "Ants",
        "BBUG" => "Bed bugs",
        "BEER" => "Bee Removal",
        "CON" => "Consultant",
        "CROACH" => "Cockroaches",
        "FLEAS" => "Fleas",
        "FLIES" => "Flies",
        "FOX" => "Fox",
        "HUMAN" => "Humane Pest Control",
        "MOLES" => "Moles",
        "MOSQ" => "Mosquitos",
        "MOTH" => "Moths",
        "NCHEM" => "Non Chemical Pest Control",
        "NCHEM2" => "Heat Treatment",
        "OTHINS" => "Other Insects",
        "OTHMAM" => "Other Mammals",
        "RABBITS" => "Rabbits",
        "RAT" => "Rats and Drains",
        "SAB" => "Rats and Mice",
        "SBC" => "Birds",
        "SFumA" => "Fumigation - Soil &amp; Compost (Commercial)",
        "SFumB" => "Fumigation - Buildings (Commercial)",
        "SFumC" => "Fumigation - Under Sheets (Commercial)",
        "SFumD" => "Fumigation - Containers (Commercial)",
        "SFumE" => "Fumigation - Ships (Commercial)",
        "SFumF" => "Fumigation - Aircraft (Commercial)",
        "SFumG" => "Fumigation - Bubble (Commercial)",
        "SFumH" => "Fumigation - Chamber (Commercial)",
        "SQUIR" => "Squirrels",
        "WASP" => "Wasps",
        "WILD" => "Wildlife Management"
    ];

    public function __construct(Organisation $organisation, Collection $pests) {
        $this->organisation = $organisation;
        $this->pests = $pests;
    }

    private function getPestCodes()
    {
        $services = explode(',', $this->organisation->services);

        return MyArr::map($services, function($value) {
            return $this->convertCode($value);
        });
    }

    private function getPestCodeIds()
    {
        $codes = $this->getPestCodes();

        $ids = $this->pests->whereIn('code', $codes)->pluck('id');

        return $ids;
    }

    private function convertCode($code)
    {
        return Str::slug(Str::lower($this->pestDictionary[$code] ?? ""));
    }

    public function sync()
    {
        $ids = $this->getPestCodeIds();
        
        $this->organisation->pests()->sync($ids);
        
        return $this->organisation;
    }
}
