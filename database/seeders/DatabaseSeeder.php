<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::factory()->create([
            'usertype'  => 'admin',
            'firstname' => 'rhannel',
            'lastname'  => 'dinlasan',
            'sex'       => 'male',
            'email'     => 'rhannel@gmail.com',
        ]);

        for ($count = 0; $count < 100; $count++) {
            while (true) {
                try {
                    User::factory()->create([
                        'sr_code' => '18-'.rand(10000, 99999),
                    ]);
                    break;
                } catch (\Throwable $th) {
                    
                }
            }
        }

        $this->call([
            StudentSeeder::class,
            CollegeSeeder::class,
        ]);
    }
}
