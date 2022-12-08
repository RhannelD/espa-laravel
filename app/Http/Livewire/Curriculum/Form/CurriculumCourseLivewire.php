<?php

namespace App\Http\Livewire\Curriculum\Form;

use App\Models\Curriculum;
use App\Models\CurriculumCourse;
use Livewire\Component;

class CurriculumCourseLivewire extends Component
{
    public $curriculum_id;

    public function mount(Curriculum $curriculum)
    {
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
        CurriculumCourse::where('curriculum_id', $this->curriculum_id)->delete();
        
        $this->emitTo('curriculum.form.curriculum-course-semester-livewire', 'refresh');
    }
}
