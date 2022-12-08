<?php

namespace Database\Seeders;

use App\Models\User;
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
        $users_data = [
            [
                'firstname' => 'Rhannel',
                'lastname' => 'Dinlasan',
                'sex' => 'male',
                'email' => 'rhannel@gmail.com',
                'role' => 'Super Admin',
            ],
            [
                'firstname' => 'Noey',
                'lastname' => 'De Jesus',
                'sex' => 'female',
                'email' => 'noey@gmail.com',
                'role' => 'College Dean',
            ],
            [
                'firstname' => 'Benjie',
                'lastname' => 'Samonte',
                'sex' => 'male',
                'email' => 'benjie@gmail.com',
                'role' => 'Program Chairperson',
            ],
        ];

        foreach ($users_data as $user_data) {
            $user = User::factory()->create(\Arr::except($user_data, ['role']));
            $user->assignRole($user_data['role']);
        }

        // Students -----------------------------------------------------

        for ($count = 0; $count < 100; $count++) {
            while (true) {
                try {
                    $user = User::factory()->create([
                        'sr_code' => '18-' . rand(10000, 99999),
                    ]);
                    // $user->assignRole('Student');
                    break;
                } catch (\Throwable $th) {

                }
            }
        }
    }
}
