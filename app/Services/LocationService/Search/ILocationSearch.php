<?php
namespace App\Services\LocationService\Search;

interface ILocationSearch {
	public function search(string $postcode, string $pest_code): array;
}