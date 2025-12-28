<?php
namespace App\Data;

class JsonCodable
{
    public $original;

	public function __construct(array $arr) {
        $this->original = $arr;

        foreach ($arr as $key => $value) {
            $this->{$key} = $this->objectify($value);
        }
	}

    private function objectify ($value)
    {
        return json_decode(json_encode($value));
    }
}
