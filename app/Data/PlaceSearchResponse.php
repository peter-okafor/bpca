<?php
namespace App\Data;

class PlaceSearchResponse extends JsonCodable
{
    public $predictions = [];
    public $status;
}
