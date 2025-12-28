<?php

namespace Database\Seeders;

use App\Models\ReviewComponentContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewComponentContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!app()->environment('local')) {
            return;
        }

        // Trusted By
        ReviewComponentContent::firstOrCreate(
            ['name' => 'Pest UK'],
            [
                'image' => 'https://picsum.photos/200/300',
                'content' => '"Nam aliquam eros gravida rhoncu commodo. Proin facilisis ut neque nec poritor. Praesent id felis mais, efficitur est ac, tempus est. Praesent pellentesque a enim eu volutpat. Ut semper mollis accumsan. Etiam cursus magna lectus."',
                'writer' => 'Jonathan Smith, Director at Pest UK'
            ]
        );

        ReviewComponentContent::firstOrCreate(
            ['name' => 'Pest NG4'],
            [
                'image' => 'https://picsum.photos/200/300',
                'content' => '"Nam aliquam eros gravida rhoncu commodo. Proin facilisis ut neque nec poritor. Praesent id felis mais, efficitur est ac, tempus est. Praesent pellentesque a enim eu volutpat. Ut semper mollis accumsan. Etiam cursus magna lectus."',
                'writer' => 'Jonathan Smith, Director at Pest UK'
            ]
        );

        ReviewComponentContent::firstOrCreate(
            ['name' => 'Pest NG5'],
            [
                'image' => 'https://picsum.photos/200/300',
                'content' => '"Nam aliquam eros gravida rhoncu commodo. Proin facilisis ut neque nec poritor. Praesent id felis mais, efficitur est ac, tempus est. Praesent pellentesque a enim eu volutpat. Ut semper mollis accumsan. Etiam cursus magna lectus."',
                'writer' => 'Jonathan Smith, Director at Pest UK'
            ]
        );
    }
}
