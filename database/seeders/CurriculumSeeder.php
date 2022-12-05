<?php

namespace Database\Seeders;

use App\Models\Curriculum;
use App\Models\Program;
use Illuminate\Database\Seeder;

class CurriculumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programs = Program::get();
        $curricula = $this->getCurricula();

        foreach ($curricula as $curriculum) {
            $program = $programs->where('abbreviation', $curriculum['program'])->first();

            if ($program) {
                $program->curricula()->create(array_slice($curriculum, 1));
            }
        }
    }

    public function getCurricula()
    {
        return [
            [
                'program' => 'BSIT',
                'track' => 'NETWORK TECHNOLOGY TRACK',
                'academic_year' => '2018',
            ],
            [
                'program' => 'BSIT',
                'track' => 'BUSINESS ANALYTICS TRACK',
                'academic_year' => '2018',
            ],
            [
                'program' => 'BIT',
                'track' => 'Electronics Technology',
                'academic_year' => '2018',
            ],
        ];
    }
}
