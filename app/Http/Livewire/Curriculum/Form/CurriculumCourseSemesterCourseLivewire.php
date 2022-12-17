<?php

namespace App\Http\Livewire\Curriculum\Form;

use App\Models\CurriculumCourse;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CurriculumCourseSemesterCourseLivewire extends Component
{
    public $curriculum_course_id;
    public $curriculum_course;

    protected $rules = [
        'curriculum_course.requisite_standing' => 'max:255',
    ];

    protected function getListeners()
    {
        return [
            "refresh" => '$refresh',
            "refresh_curriculum_course_{$this->curriculum_course_id}" => '$refresh',
        ];
    }

    public function mount(CurriculumCourse $curriculum_course)
    {
        $this->curriculum_course_id = $curriculum_course->id;
        $this->curriculum_course = $curriculum_course->replicate();
    }

    public function render()
    {
        return view('livewire.curriculum.form.curriculum-course-semester-course-livewire', [
            'curriculum_course_data' => $this->getCurriculumCourse(),
        ]);
    }

    public function getCurriculumCourse()
    {
        return CurriculumCourse::query()
            ->with([
                'course',
                'prerequisite_curriculum_courses' => function ($query) {
                    $query->with('course');
                },
                'corequisite_curriculum_courses' => function ($query) {
                    $query->with('course');
                },
            ])
            ->whereId($this->curriculum_course_id)
            ->first();
    }

    public function updatedCurriculumCourse($value)
    {
        $data = $this->validate();

        $this->save($data);
    }

    protected function save($data)
    {
        $curriculum_course = CurriculumCourse::find($this->curriculum_course_id);
        if (isset($curriculum_course) && Gate::allows('update', $curriculum_course->curriculum)) {
            $curriculum_course->update($data['curriculum_course']);
        }
    }
}
