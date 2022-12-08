<?php

namespace App\Http\Livewire\Curriculum\Form;

use App\Models\CurriculumCourse;
use Livewire\Component;

class CurriculumCourseSemesterLivewire extends Component
{
    public $curriculum_id;
    public $year;
    public $semester;

    protected function getListeners()
    {
        return [
            "refresh" => '$refresh',
            "refresh_{$this->year}y_{$this->semester}s_courses" => '$refresh',
        ];
    }

    public function mount($curriculum_id, $year, $semester)
    {
        $this->curriculum_id = $curriculum_id;
        $this->year = $year;
        $this->semester = $semester;
    }

    public function render()
    {
        return view('livewire.curriculum.form.curriculum-course-semester-livewire', [
            'curriculum_courses' => $this->getCurriculumCourses(),
        ]);
    }

    protected function getCurriculumCourses()
    {
        return CurriculumCourse::query()
            ->with('course')
            ->where('curriculum_id', $this->curriculum_id)
            ->where('year', $this->year)
            ->where('semester', $this->semester)
            ->get();
    }
}
