<?php

namespace Database\Seeders;

use App\Models\Curriculum;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $curriculumIds = Curriculum::query()->toBase()->get('id')->pluck('id');
        $curriculumIdCount = count($curriculumIds);

        User::query()
            ->isStudent()
            ->chunkById(20, function ($students) use ($curriculumIds, $curriculumIdCount) {
                $students->each(function ($student) use ($curriculumIds, $curriculumIdCount) {
                    $student->student()->create([
                        'curriculum_id' => $curriculumIds[rand(0, ($curriculumIdCount - 1))],
                    ]);
                });
            });
    }
}
