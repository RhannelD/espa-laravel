<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use PhpParser\Node\Stmt\While_;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $students = User::factory(100)->create();

        // foreach ($students as $student) {
        //     while (true) {
        //         try {
        //             $student->student()->updateOrCreate([
        //                 'sr_code' => '18-'.rand(10000, 99999),
        //             ]);
        //             break;
        //         } catch (\Throwable $th) {
                    
        //         }
        //     }
        // }
    }
}
