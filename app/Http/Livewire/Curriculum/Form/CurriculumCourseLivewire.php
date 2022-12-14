<?php

namespace App\Http\Livewire\Curriculum\Form;

use App\Models\Curriculum;
use App\Models\CurriculumCourse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CurriculumCourseLivewire extends Component
{
    use AuthorizesRequests;

    public $curriculum_id;

    public function mount(Curriculum $curriculum)
    {
        $this->authorize('update', $curriculum);
        $this->curriculum_id = $curriculum->id;
    }

    public function render()
    {
        $curriculum = $this->getCurriculum();

        return view('livewire.curriculum.form.curriculum-course-livewire', [
            'curriculum' => $curriculum,
        ])->extends('layouts.app', [
            'active_nav' => 'curriculum',
            'title' => "Curriculum Course Form",
            'breadcrumbs' => [
                [
                    'link' => route('curriculum'),
                    'label' => 'Curriculum',
                ], [
                    'link' => route('curriculum.course', [$curriculum->id]),
                    'label' => "{$curriculum->title} {$curriculum->academic_year}",
                ], [
                    'label' => 'Form Courses',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getCurriculum()
    {
        return Curriculum::find($this->curriculum_id)->load([
            'program',
            'references',
        ]);
    }

    public function emptyCurriculum()
    {
        $curriculum = Curriculum::find($this->curriculum_id);
        if (Gate::allows('update', $curriculum)) {
            $curriculum->courses()
                ->select('year', 'semester')
                ->groupBy('year')
                ->groupBy('semester')
                ->toBase()
                ->get()
                ->each(function ($curriculumCourse) {
                    $this->emitTo('curriculum.form.curriculum-course-semester-livewire', "refresh_{$curriculumCourse->year}y_{$curriculumCourse->semester}s_courses");
                });

            $curriculum->courses()->delete();
        }
    }

    public function delete_curriculum_course($curriculum_course_id)
    {
        $curriculum_course = CurriculumCourse::find($curriculum_course_id);
        if (isset($curriculum_course) && Gate::allows('update', $curriculum_course->curriculum)) {
            $this->emit("refresh_{$curriculum_course->year}y_{$curriculum_course->semester}s_courses");

            foreach ($curriculum_course->prerequisite_curriculum_courses as $prerequisite_curriculum_course) {
                $this->emit("refresh_curriculum_course_{$prerequisite_curriculum_course->id}");
            }
            foreach ($curriculum_course->corequisite_curriculum_courses as $corequisite_curriculum_course) {
                $this->emit("refresh_curriculum_course_{$corequisite_curriculum_course->id}");
            }

            $curriculum_course->delete();
        }
    }
}
