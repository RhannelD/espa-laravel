<?php

namespace Database\Seeders;

use App\Models\Course;
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
        $courses = Course::get();
        $curricula = $this->getCurricula();

        foreach ($curricula as $curriculum_data) {
            $program = $programs->where('abbreviation', $curriculum_data['program'])->first();

            if ($program) {
                $curriculum = $program->curricula()->create(array_slice($curriculum_data, 1, 2));

                foreach ($curriculum_data['references'] as $reference) {
                    $curriculum->references()->create($reference);
                }

                foreach ($curriculum_data['courses'] as $course) {
                    $course['course_id'] = $courses->where('code', $course['code'])->first()->id;
                    $curriculum_course = $curriculum->courses()->create(\Arr::except($course, ["code", "prerequisites"]));

                    if (!isset($course['prerequisites'])) {
                        continue;
                    }
                    foreach ($course['prerequisites'] as $prerequisite_course_code) {
                        $prerequisite_curriculum_course = $curriculum->courses()->whereHas('course', function($query) use ($prerequisite_course_code) {
                            $query->where('code', $prerequisite_course_code);
                        })->first();

                        $curriculum_course->curriculum_course_prerequisites()->create([
                            'prerequisite_cc_id' => $prerequisite_curriculum_course->id,
                        ]);
                    }
                }
            }
        }
    }

    public function getCurricula()
    {
        return [
            [
                'program' => 'BSIT',
                'track' => 'Network Technology Track',
                'academic_year' => '2018',
                'references' => [
                    [
                        'reference' => 'CMO No. 25 series of 2015',
                    ],
                ],
                'courses' => [
                    [
                        "code" => "IT 111",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "GEd 102",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "GEd 108",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "Fili 101",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "PE 101",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "NSTP 111",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "GEd 103",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "GEd 104",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "CS 111",
                        "year" => "1",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 111",
                        ],
                    ],
                    [
                        "code" => "CS 131",
                        "year" => "1",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 111",
                        ],
                    ],
                    [
                        "code" => "MATH 111",
                        "year" => "1",
                        "semester" => "2",
                        "prerequisites" => [
                            "GEd 102",
                        ],
                    ],
                    [
                        "code" => "Fili 102",
                        "year" => "1",
                        "semester" => "2",
                    ],
                    [
                        "code" => "GEd 105",
                        "year" => "1",
                        "semester" => "2",
                    ],
                    [
                        "code" => "GEd 109",
                        "year" => "1",
                        "semester" => "2",
                    ],
                    [
                        "code" => "PE 102",
                        "year" => "1",
                        "semester" => "2",
                        "prerequisites" => [
                            "PE 101",
                        ],
                    ],
                    [
                        "code" => "NSTP 121",
                        "year" => "1",
                        "semester" => "2",
                        "prerequisites" => [
                            "NSTP 111",
                        ],
                    ],
                    [
                        "code" => "CS 121",
                        "year" => "2",
                        "semester" => "1",
                        "prerequisites" => [
                            "CS 111",
                        ],
                    ],
                    [
                        "code" => "IT 211",
                        "year" => "2",
                        "semester" => "1",
                        "prerequisites" => [
                            "CS 111",
                        ],
                    ],
                    [
                        "code" => "CS 211",
                        "year" => "2",
                        "semester" => "1",
                        "prerequisites" => [
                            "CS 111",
                            "CS 131",
                        ],
                    ],
                    [
                        "code" => "Litr 102",
                        "year" => "2",
                        "semester" => "1",
                    ],
                    [
                        "code" => "CpE 405",
                        "year" => "2",
                        "semester" => "1",
                        "prerequisites" => [
                            "MATH 111",
                        ],
                    ],
                    [
                        "code" => "Phy 101",
                        "year" => "2",
                        "semester" => "1",
                        "prerequisites" => [
                            "MATH 111",
                        ],
                    ],
                    [
                        "code" => "IT 212",
                        "year" => "2",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 111",
                        ],
                    ],
                    [
                        "code" => "PE 103",
                        "year" => "2",
                        "semester" => "1",
                        "prerequisites" => [
                            "PE 101",
                        ],
                    ],
                    [
                        "code" => "IT 221",
                        "year" => "2",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 111",
                        ],
                    ],
                    [
                        "code" => "IT 223",
                        "year" => "2",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 212",
                        ],
                    ],
                    [
                        "code" => "IT 222",
                        "year" => "2",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 211",
                        ],
                    ],
                    [
                        "code" => "MATH 408",
                        "year" => "2",
                        "semester" => "2",
                        "prerequisites" => [
                            "MATH 111",
                        ],
                    ],
                    [
                        "code" => "ES 101",
                        "year" => "2",
                        "semester" => "2",
                        "prerequisites" => [
                            "Phy 101",
                        ],
                    ],
                    [
                        "code" => "GEd 106",
                        "year" => "2",
                        "semester" => "2",
                    ],
                    [
                        "code" => "GEd 101",
                        "year" => "2",
                        "semester" => "2",
                    ],
                    [
                        "code" => "PE 104",
                        "year" => "2",
                        "semester" => "2",
                        "prerequisites" => [
                            "PE 101",
                        ],
                    ],
                    [
                        "code" => "IT 311",
                        "year" => "3",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 221",
                            "IT 222",
                        ],
                    ],
                    [
                        "code" => "IT 312",
                        "year" => "3",
                        "semester" => "1",
                        "prerequisites" => [
                            "CS 131",
                        ],
                    ],
                    [
                        "code" => "NTT 401",
                        "year" => "3",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 223",
                        ],
                    ],
                    [
                        "code" => "NTT 402",
                        "year" => "3",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 223",
                        ],
                    ],
                    [
                        "code" => "IT 313",
                        "year" => "3",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 222",
                        ],
                    ],
                    [
                        "code" => "IT 314",
                        "year" => "3",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 211",
                        ],
                    ],
                    [
                        "code" => "GEd 107",
                        "year" => "3",
                        "semester" => "1",
                    ],
                    [
                        "code" => "IT 321",
                        "year" => "3",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 314",
                        ],
                    ],
                    [
                        "code" => "NTT 403",
                        "year" => "3",
                        "semester" => "2",
                        "prerequisites" => [
                            "NTT 401",
                        ],
                    ],
                    [
                        "code" => "NTT 404",
                        "year" => "3",
                        "semester" => "2",
                        "prerequisites" => [
                            "NTT 402",
                        ],
                    ],
                    [
                        "code" => "IT 322",
                        "year" => "3",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 312",
                        ],
                    ],
                    [
                        "code" => "IT 323",
                        "year" => "3",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 223",
                        ],
                    ],
                    [
                        "code" => "IT 324",
                        "year" => "3",
                        "semester" => "2",
                    ],
                    [
                        "code" => "IT 325",
                        "year" => "3",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 313",
                        ],
                    ],
                    [
                        "code" => "IT 331",
                        "year" => "3",
                        "semester" => "3",
                        "prerequisites" => [
                            "IT 321",
                        ],
                    ],
                    [
                        "code" => "IT 332",
                        "year" => "3",
                        "semester" => "3",
                        "prerequisites" => [
                            "IT 314",
                        ],
                    ],
                    [
                        "code" => "CS 423",
                        "year" => "4",
                        "semester" => "1",
                    ],
                    [
                        "code" => "IT 411",
                        "year" => "4",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 324",
                        ],
                    ],
                    [
                        "code" => "ENGG 405",
                        "year" => "4",
                        "semester" => "1",
                    ],
                    [
                        "code" => "NTT 405",
                        "year" => "4",
                        "semester" => "1",
                        "prerequisites" => [
                            "NTT 403",
                        ],
                    ],
                    [
                        "code" => "IT 413",
                        "year" => "4",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 323",
                        ],
                    ],
                    [
                        "code" => "IT 414",
                        "year" => "4",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 325",
                        ],
                    ],
                    [
                        "code" => "IT 412",
                        "year" => "4",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 332",
                        ],
                    ],
                    [
                        "code" => "IT 421",
                        "year" => "4",
                        "semester" => "2",
                    ],
                ],
            ],
            [
                'program' => 'BSIT',
                'track' => 'Business Analytics Track',
                'academic_year' => '2018',
                'references' => [
                    [
                        'reference' => 'CMO No. 25 series of 2015',
                    ],
                ],
                'courses' => [
                    [
                        "code" => "IT 111",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "GEd 102",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "GEd 108",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "Fili 101",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "PE 101",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "NSTP 111",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "GEd 103",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "GEd 104",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "CS 111",
                        "year" => "1",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 111",
                        ],
                    ],
                    [
                        "code" => "CS 131",
                        "year" => "1",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 111",
                        ],
                    ],
                    [
                        "code" => "MATH 111",
                        "year" => "1",
                        "semester" => "2",
                        "prerequisites" => [
                            "GEd 102",
                        ],
                    ],
                    [
                        "code" => "Fili 102",
                        "year" => "1",
                        "semester" => "2",
                    ],
                    [
                        "code" => "GEd 105",
                        "year" => "1",
                        "semester" => "2",
                    ],
                    [
                        "code" => "GEd 109",
                        "year" => "1",
                        "semester" => "2",
                    ],
                    [
                        "code" => "PE 102",
                        "year" => "1",
                        "semester" => "2",
                        "prerequisites" => [
                            "PE 101",
                        ],
                    ],
                    [
                        "code" => "NSTP 121",
                        "year" => "1",
                        "semester" => "2",
                        "prerequisites" => [
                            "NSTP 111",
                        ],
                    ],
                    [
                        "code" => "CS 121",
                        "year" => "2",
                        "semester" => "1",
                        "prerequisites" => [
                            "CS 111",
                        ],
                    ],
                    [
                        "code" => "IT 211",
                        "year" => "2",
                        "semester" => "1",
                        "prerequisites" => [
                            "CS 111",
                        ],
                    ],
                    [
                        "code" => "CS 211",
                        "year" => "2",
                        "semester" => "1",
                        "prerequisites" => [
                            "CS 111",
                            "CS 131",
                        ],
                    ],
                    [
                        "code" => "Litr 102",
                        "year" => "2",
                        "semester" => "1",
                    ],
                    [
                        "code" => "CpE 405",
                        "year" => "2",
                        "semester" => "1",
                        "prerequisites" => [
                            "MATH 111",
                        ],
                    ],
                    [
                        "code" => "Phy 101",
                        "year" => "2",
                        "semester" => "1",
                        "prerequisites" => [
                            "MATH 111",
                        ],
                    ],
                    [
                        "code" => "IT 212",
                        "year" => "2",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 111",
                        ],
                    ],
                    [
                        "code" => "PE 103",
                        "year" => "2",
                        "semester" => "1",
                        "prerequisites" => [
                            "PE 101",
                        ],
                    ],
                    [
                        "code" => "IT 221",
                        "year" => "2",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 111",
                        ],
                    ],
                    [
                        "code" => "IT 223",
                        "year" => "2",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 212",
                        ],
                    ],
                    [
                        "code" => "IT 222",
                        "year" => "2",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 211",
                        ],
                    ],
                    [
                        "code" => "MATH 408",
                        "year" => "2",
                        "semester" => "2",
                        "prerequisites" => [
                            "MATH 111",
                        ],
                    ],
                    [
                        "code" => "ES 101",
                        "year" => "2",
                        "semester" => "2",
                        "prerequisites" => [
                            "Phy 101",
                        ],
                    ],
                    [
                        "code" => "GEd 106",
                        "year" => "2",
                        "semester" => "2",
                    ],
                    [
                        "code" => "GEd 101",
                        "year" => "2",
                        "semester" => "2",
                    ],
                    [
                        "code" => "PE 104",
                        "year" => "2",
                        "semester" => "2",
                        "prerequisites" => [
                            "PE 101",
                        ],
                    ],
                    [
                        "code" => "IT 311",
                        "year" => "3",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 221",
                            "IT 222",
                        ],
                    ],
                    [
                        "code" => "IT 312",
                        "year" => "3",
                        "semester" => "1",
                        "prerequisites" => [
                            "CS 131",
                        ],
                    ],
                    [
                        "code" => "BAT 401",
                        "year" => "3",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 221",
                            "IT 222",
                        ],
                    ],
                    [
                        "code" => "BAT 402",
                        "year" => "3",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 221",
                            "IT 222",
                        ],
                    ],
                    [
                        "code" => "IT 313",
                        "year" => "3",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 222",
                        ],
                    ],
                    [
                        "code" => "IT 314",
                        "year" => "3",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 221",
                        ],
                    ],
                    [
                        "code" => "GEd 107",
                        "year" => "3",
                        "semester" => "1",
                    ],
                    [
                        "code" => "IT 321",
                        "year" => "3",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 314",
                        ],
                    ],
                    [
                        "code" => "BAT 403",
                        "year" => "3",
                        "semester" => "2",
                        "prerequisites" => [
                            "BAT 401",
                        ],
                    ],
                    [
                        "code" => "BAT 404",
                        "year" => "3",
                        "semester" => "2",
                        "prerequisites" => [
                            "BAT 402",
                        ],
                    ],
                    [
                        "code" => "IT 322",
                        "year" => "3",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 312",
                        ],
                    ],
                    [
                        "code" => "IT 323",
                        "year" => "3",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 223",
                        ],
                    ],
                    [
                        "code" => "IT 324",
                        "year" => "3",
                        "semester" => "2",
                    ],
                    [
                        "code" => "IT 325",
                        "year" => "3",
                        "semester" => "2",
                        "prerequisites" => [
                            "IT 313",
                        ],
                    ],
                    [
                        "code" => "IT 331",
                        "year" => "3",
                        "semester" => "3",
                        "prerequisites" => [
                            "IT 321",
                        ],
                    ],
                    [
                        "code" => "IT 332",
                        "year" => "3",
                        "semester" => "3",
                        "prerequisites" => [
                            "IT 314",
                        ],
                    ],
                    [
                        "code" => "CS 423",
                        "year" => "4",
                        "semester" => "1",
                    ],
                    [
                        "code" => "IT 411",
                        "year" => "4",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 324",
                        ],
                    ],
                    [
                        "code" => "ENGG 405",
                        "year" => "4",
                        "semester" => "1",
                    ],
                    [
                        "code" => "BAT 405",
                        "year" => "4",
                        "semester" => "1",
                        "prerequisites" => [
                            "BAT 404",
                        ],
                    ],
                    [
                        "code" => "IT 413",
                        "year" => "4",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 323",
                        ],
                    ],
                    [
                        "code" => "IT 414",
                        "year" => "4",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 325",
                        ],
                    ],
                    [
                        "code" => "IT 412",
                        "year" => "4",
                        "semester" => "1",
                        "prerequisites" => [
                            "IT 332",
                        ],
                    ],
                    [
                        "code" => "IT 421",
                        "year" => "4",
                        "semester" => "2",
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
                'courses' => [
                    [
                        "code" => "GEd 101",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "GEd 105",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "GEd 102",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "ACC 101",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "MGT 303",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "MGT 207",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "NSTP 111",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "PE 101",
                        "year" => "1",
                        "semester" => "1",
                    ],
                    [
                        "code" => "GEd 104",
                        "year" => "1",
                        "semester" => "2",
                    ],
                    [
                        "code" => "Fili 102",
                        "year" => "1",
                        "semester" => "2",
                    ],
                    [
                        "code" => "GEd 107",
                        "year" => "1",
                        "semester" => "2",
                    ],
                    [
                        "code" => "ACC 102",
                        "year" => "1",
                        "semester" => "2",
                    ],
                    [
                        "code" => "ECO 310",
                        "year" => "1",
                        "semester" => "2",
                    ],
                    [
                        "code" => "MGT 406",
                        "year" => "1",
                        "semester" => "2",
                    ],
                    [
                        "code" => "NSTP 121",
                        "year" => "1",
                        "semester" => "2",
                    ],
                    [
                        "code" => "PE 102",
                        "year" => "1",
                        "semester" => "2",
                    ],
                    [
                        "code" => "GEd 108",
                        "year" => "2",
                        "semester" => "1",
                    ],
                    [
                        "code" => "Fili 101",
                        "year" => "2",
                        "semester" => "1",
                    ],
                    [
                        "code" => "IT 101",
                        "year" => "2",
                        "semester" => "1",
                    ],
                    [
                        "code" => "ACC 203",
                        "year" => "2",
                        "semester" => "1",
                    ],
                    [
                        "code" => "ACC 204",
                        "year" => "2",
                        "semester" => "1",
                    ],
                    [
                        "code" => "LAW 201",
                        "year" => "2",
                        "semester" => "1",
                    ],
                    [
                        "code" => "MGT 208",
                        "year" => "2",
                        "semester" => "1",
                    ],
                    [
                        "code" => "MGT 209",
                        "year" => "2",
                        "semester" => "1",
                    ],
                    [
                        "code" => "PE 103",
                        "year" => "2",
                        "semester" => "1",
                    ],
                    [
                        "code" => "GEd 103",
                        "year" => "2",
                        "semester" => "2",
                    ],
                    [
                        "code" => "GEd 106",
                        "year" => "2",
                        "semester" => "2",
                    ],
                    [
                        "code" => "GEd 109",
                        "year" => "2",
                        "semester" => "2",
                    ],
                    [
                        "code" => "ACC 205",
                        "year" => "2",
                        "semester" => "2",
                    ],
                    [
                        "code" => "ACC 206",
                        "year" => "2",
                        "semester" => "2",
                    ],
                    [
                        "code" => "ACC 207",
                        "year" => "2",
                        "semester" => "2",
                    ],
                    [
                        "code" => "LAW 202",
                        "year" => "2",
                        "semester" => "2",
                    ],
                    [
                        "code" => "PE 104",
                        "year" => "2",
                        "semester" => "2",
                    ],
                    [
                        "code" => "Litr 102",
                        "year" => "3",
                        "semester" => "1",
                    ],
                    [
                        "code" => "ACC 308",
                        "year" => "3",
                        "semester" => "1",
                    ],
                    [
                        "code" => "ACC 309",
                        "year" => "3",
                        "semester" => "1",
                    ],
                    [
                        "code" => "ACC 310",
                        "year" => "3",
                        "semester" => "1",
                    ],
                    [
                        "code" => "TAX 301",
                        "year" => "3",
                        "semester" => "1",
                    ],
                    [
                        "code" => "ACC 311",
                        "year" => "3",
                        "semester" => "1",
                    ],
                    [
                        "code" => "ECO 307",
                        "year" => "3",
                        "semester" => "1",
                    ],
                    [
                        "code" => "STS 301",
                        "year" => "3",
                        "semester" => "1",
                    ],
                    [
                        "code" => "ACC 313",
                        "year" => "3",
                        "semester" => "2",
                    ],
                    [
                        "code" => "ACC 312",
                        "year" => "3",
                        "semester" => "2",
                    ],
                    [
                        "code" => "ACC 315",
                        "year" => "3",
                        "semester" => "2",
                    ],
                    [
                        "code" => "RFB 301",
                        "year" => "3",
                        "semester" => "2",
                    ],
                    [
                        "code" => "TAX 302",
                        "year" => "3",
                        "semester" => "2",
                    ],
                    [
                        "code" => "FM 101",
                        "year" => "3",
                        "semester" => "2",
                    ],
                    [
                        "code" => "ACC 314",
                        "year" => "3",
                        "semester" => "2",
                    ],
                    [
                        "code" => "ACC 417",
                        "year" => "4",
                        "semester" => "1",
                    ],
                    [
                        "code" => "ACC 416",
                        "year" => "4",
                        "semester" => "1",
                    ],
                    [
                        "code" => "ACC 418",
                        "year" => "4",
                        "semester" => "2",
                    ],
                    [
                        "code" => "ACC 419",
                        "year" => "4",
                        "semester" => "2",
                    ],
                    [
                        "code" => "ACC 420",
                        "year" => "4",
                        "semester" => "2",
                    ],
                    [
                        "code" => "FM 415",
                        "year" => "4",
                        "semester" => "2",
                    ],
                    [
                        "code" => "MGT 304",
                        "year" => "4",
                        "semester" => "2",
                    ],
                    [
                        "code" => "ACC 421",
                        "year" => "4",
                        "semester" => "2",
                    ],
                    [
                        "code" => "MGT 410",
                        "year" => "4",
                        "semester" => "2",
                    ],
                ],
            ],
        ];
    }
}
