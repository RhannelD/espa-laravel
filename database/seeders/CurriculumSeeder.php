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

        foreach ($curricula as $curriculum_data) {
            $program = $programs->where('abbreviation', $curriculum_data['program'])->first();

            if ($program) {
                $curriculum = $program->curricula()->create(array_slice($curriculum_data, 1, 2));
                
                foreach ($curriculum_data['references'] as $reference) {
                    $curriculum->references()->create($reference);
                }
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
                'references' => [
                    [
                        'reference' => 'CMO No. 25 series of 2015',
                    ],
                ],
            ],
            [
                'program' => 'BSIT',
                'track' => 'BUSINESS ANALYTICS TRACK',
                'academic_year' => '2018',
                'references' => [
                    [
                        'reference' => 'CMO No. 25 series of 2015',
                    ],
                ],
            ],
            [
                'program' => 'BIT',
                'track' => 'Electronics Technology',
                'academic_year' => '2018',
                'references' => [
                    [
                        'reference' => 'CMO No. 20 S. 2013',
                    ],
                ],
            ],
        ];
    }
}
