<?php

namespace App\Http\Livewire\Curriculum;

use App\Models\Curriculum;
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

        return view('livewire.curriculum.curriculum-course-livewire', [
            'curriculum' => $curriculum,
        ])->extends('layouts.app', [
            'active_nav' => 'curriculum',
            'title' => "Curriculum Courses",
            'breadcrumbs' => [
                [
                    'link' => route('curriculum'),
                    'label' => 'Curriculum',
                ], [
                    'link' => route('curriculum.course', [$curriculum->id]),
                    'label' => "{$curriculum->title} {$curriculum->academic_year}",
                ], [
                    'label' => 'Courses',
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
            'courses' => function ($query) {
                $query->groupBy('year')
                ->groupBy('semester')
                ->orderBy('year')
                ->orderBy('semester');
            },
        ]);
    }
}
