<?php
namespace App\Data;

use App\Data\JsonCodable;

class GeoBound extends JsonCodable {
	public $north;
	public $east;
	public $south;
	public $west;
}