<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(['email' => 'admin@pests.org'], [
            'name' => 'Admin User',
            'email' => 'admin@pests.org',
            'email_verified_at' => now(),
            'password' => Hash::make('admin@pests.org'),
            'remember_token' => Str::random(10),
        ]);
    }
}
