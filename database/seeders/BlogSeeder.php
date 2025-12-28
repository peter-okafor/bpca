<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BlogPost;
use App\Models\BlogImage;
use App\Models\BlogComment;
use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        if (!app()->environment('local')) {
            return;
        }
        $users = User::factory(10)->has(
            BlogImage::factory(1),
            'images'
        )->create();

        $categories = BlogCategory::factory(10)->has(
            BlogImage::factory(1),
            'images'
        )->create([
            'user_id' => $users->random()->first()->id
        ]);

        $posts = BlogPost::factory(10)->has(
            BlogImage::factory(1),
            'images'
        )->create([
            'user_id' => $users->random()->first()->id,
            'blog_category_id' => $categories->random()->first()->id,
        ]);

        BlogComment::factory(10)->create([
            'blog_post_id' => $posts->random()->first()->id,
        ]);
    }
}
