<?php

namespace App\Services\LocationService\Geocode;

use App\Data\GeoBound;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Objects\LineString;

class OSGeocoder
{
    private $srid = 4326;

    public function geocode(string $query): GeoBound
    {
        // Set the API endpoint and your API key
        $endpoint = "https://api.os.uk/search/names/v1/find";
        $api_key = "VMb6uQwO8opE9ArNorCD3lfAHYjLx2nN";

        // Set the parameters for the API request
        $params = array(
            "query" => $query,
            "key" => $api_key,
          //  "dataset" => "DPA,LPI",
           // "polygon" => "true"  // Include the polygon in the response
        );

        // Build the query string
        $query_string = http_build_query($params);

        // Send the request and retrieve the response
        $response = file_get_contents($endpoint."?".$query_string);
        $data = json_decode($response, true);

        // Extract the polygon coordinates from the response
        $polygon = $data["results"][0]["geometry"]["polygon"];

        // Format the coordinates as a MySQL POLYGON string
        $mysql_polygon = "(";
        $lineArray = collect();
        foreach ($polygon as $point) {
            $lineArray->add(new Point($point[0], $point[0]), $this->srid);
            $mysql_polygon .= $point[0]." ".$point[1].", ";
        }

        ray($lineArray->all(), $response);
        // Remove the last comma and close the polygon
        return new Polygon([new LineString($lineArray->all())], $this->srid);

        //return rtrim($mysql_polygon, ", ").")";
    }

}
