<?php
namespace App\Services;

use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\DB;
use MatanYadaev\EloquentSpatial\Objects\Geometry;
use MatanYadaev\EloquentSpatial\SpatialBuilder;

class MySpatialBuilder extends SpatialBuilder
{
    protected function toExpression(Geometry|string $geometryOrColumn): Expression
    {
        if ($geometryOrColumn instanceof Geometry) {
        $wkt = $geometryOrColumn->toWkt();

        return DB::raw("ST_GeomFromText('{$wkt}', 4326)");
        }

        return DB::raw("`{$geometryOrColumn}`");
    }
}
