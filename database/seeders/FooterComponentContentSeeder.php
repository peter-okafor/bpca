<?php

namespace Database\Seeders;

use App\Models\FooterComponentContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FooterComponentContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FooterComponentContent::firstOrCreate(
            ['item' => 'Home'],
            ['link' => '/']
        );

        FooterComponentContent::firstOrCreate(
            ['item' => 'About Us'],
            ['link' => '/about']
        );

        FooterComponentContent::firstOrCreate(
            ['item' => 'A-Z of Pests'],
            ['link' => '/pests']
        );

        FooterComponentContent::firstOrCreate(
            ['item' => 'Blog'],
            ['link' => '/blog']
        );
    }
}
