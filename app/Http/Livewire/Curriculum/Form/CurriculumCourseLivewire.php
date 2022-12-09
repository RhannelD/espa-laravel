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
            $curriculum->courses()->delete();

            $this->emitTo('curriculum.form.curriculum-course-semester-livewire', 'refresh');
        }
    }
}
