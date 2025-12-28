<?php
namespace App\Services\Helpers;

use Illuminate\Support\Arr;

class MyArr extends Arr
{
    /**
     * Determine if an array contains a value or a set of values
     * 
     * @param array $array
     * @param array|string $values
     * @return bool
     */
    public static function contains($array, $values)
    {
        $values = (array) $values;

        if (! $array || $values === []) {
            return false;
        }

        foreach ($values as $value) {
            if (in_array($value, $array)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the difference between 2 arrays.
     */
    public static function difference(array $array1, array $array2)
    {
        return collect($array1)->diff($array2)->values()->all();
    }
}
