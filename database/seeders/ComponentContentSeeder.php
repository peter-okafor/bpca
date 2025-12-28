<?php

namespace Database\Seeders;

use App\Models\ComponentContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComponentContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Why use pests.org?
        ComponentContent::firstOrCreate(
            ['component' => 'Benefits'],
            ['content' => 'Nam aliquam eros gravida rhoncus commodo. Proin facilisis ut neque nec poritor. Praesent id felis mais, efficitur est ac, tempus est. Praesent pellentesque a enim eu volutpat. Ut semper mollis accumsan. Etiam cursus magna lectus.']
        );

        // About content
        ComponentContent::firstOrCreate(
            ['component' => 'About'],
            ['content' => '']
        );

        // A to Z of pests description
        ComponentContent::firstOrCreate(
            ['component' => 'AtoZDescription'],
            ['content' => 'Nam aliquam eros gravida rhoncus commodo. Proin facilisis ut neque nec porttitor. Praesent id felis mattis, efficitur est ac, tempus est.']
        );
    }
}
