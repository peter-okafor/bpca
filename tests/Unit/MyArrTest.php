<?php

namespace Tests\Unit;

use App\Services\Helpers\MyArr;
use PHPUnit\Framework\TestCase;

class MyArrTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_array_difference()
    {
        $arr1 = ['hello', 'world'];
        $arr2 = ['hello', 'people'];

        $diff = MyArr::difference($arr1, $arr2);

        $this->assertEquals($diff, ['world']);
    }
}
