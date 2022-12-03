<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'firstname' => 'rhannel',
            'lastname'  => 'dinlasan',
            'email'     => 'rhannel@gmail.com',
        ]);
    }
}
