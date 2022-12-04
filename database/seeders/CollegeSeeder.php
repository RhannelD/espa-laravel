<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Seeder;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colleges = [
            1 => [
                'abbreviation'  => 'CICS',
                'college'       => 'College of Informatics and Computing Sciences',
                'programs'      => [
                    [
                        'abbreviation'  => 'BSIT',
                        'program'      => 'Bachelor of Science in Information Technology',
                    ],
                    [
                        'abbreviation'  => 'BSCS',
                        'program'      => 'Bachelor of Science in Computer Science',
                    ],
                ],
            ],
            2 => [
                'abbreviation'  => 'CE',
                'college'       => 'College of Engineering',
                'programs'      => [
                    [
                        'abbreviation' => 'BSCE',
                        'program'      => 'Bachelor of Science in Computer Engineering',
                    ],
                ],
            ],
            3 => [
                'abbreviation'  => 'CAS',
                'college'       => 'College of Arts and Sciences',
                'programs'      => [
                    [
                        'abbreviation' => 'BA Comm',
                        'program'      => 'Bachelor of Arts in Communication',
                    ],
                    [
                        'abbreviation' => 'BS Criminology',
                        'program'      => 'Bachelor of Science in Criminology',
                    ],
                    [
                        'abbreviation' => 'BS Psychology',
                        'program'      => 'Bachelor of Science in Psychology',
                    ],
                    [
                        'abbreviation' => 'BSFAS',
                        'program'      => 'Bachelor of Science in Fisheries and Aquatic Sciences',
                    ],
                ],
            ],
            4 => [
                'abbreviation'  => 'CTE',
                'college'       => 'College of Teacher Education',
                'programs'      => [
                    [
                        'abbreviation' => 'BSEd',
                        'program'      => 'Bachelor of Secondary Education',
                    ],
                    [
                        'abbreviation' => 'BEEd',
                        'program'      => 'Bachelor of Elementary Education',
                    ],
                ],
            ],
            5 => [
                'abbreviation'  => 'CABEIHM',
                'college'       => 'College of Accountancy, Business, Economics and International Hospitality Management',
                'programs'      => [
                    [
                        'abbreviation' => 'BSA',
                        'program'      => 'Bachelor of Science in Accountancy',
                    ],
                    [
                        'abbreviation' => 'BSBA',
                        'program'      => 'Bachelor of Science in Business Administration',
                    ],
                    [
                        'abbreviation' => 'BSTM',
                        'program'      => 'Bachelor of Science in Tourism Management',
                    ],
                    [
                        'abbreviation' => 'BSHM',
                        'program'      => 'Bachelor of Science in Hospitality Management',
                    ],
                ],
            ],
            6 => [
                'abbreviation'  => 'CIT',
                'college'       => 'College of Industrial Technology',
                'programs'      => [
                    [
                        'abbreviation' => 'BSFT',
                        'program'      => 'Bachelor of Science in Food Technology',
                    ],
                    [
                        'abbreviation' => 'BIT',
                        'program'      => 'Bachelor of Industrial Technology',
                    ],
                ],
            ],
            7 => [
                'abbreviation'  => 'CONAHS',
                'college'       => 'College of Nursing and Allied Health Sciences',
                'programs'      => [
                    [
                        'abbreviation' => 'BSN',
                        'program'      => 'Bachelor of Science in Nursing',
                    ],
                    [
                        'abbreviation' => 'BSND',
                        'program'      => 'Bachelor of Science in Nutrition and Dietetics',
                    ],
                ],
            ],
        ];

        foreach ($colleges as $college) {
            $_college = College::create([
                'college' => $college['college'],
                'abbreviation' => $college['abbreviation'],
            ]);

            foreach ($college['programs'] as $program) {
                $_college->programs()->create($program);
            }
        }
    }
}
