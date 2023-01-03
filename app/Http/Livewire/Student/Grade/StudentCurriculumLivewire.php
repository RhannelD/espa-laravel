<?php

namespace App\Http\Livewire\Student\Grade;

use App\Models\Curriculum;
use App\Models\User;
use Livewire\Component;

class StudentCurriculumLivewire extends Component
{
    public $user_id;

    public function mount(User $user)
    {
        abort_unless($user->isStudent, 403);

        $this->user_id = $user->id;
    }

    public function render()
    {
        return view('livewire.student.grade.student-curriculum-livewire', [
            'user' => $this->getUser(),
            'curriculum' => $this->getCurriculum(),
        ])->extends('layouts.app', [
            'active_nav' => 'student',
            'title' => "Student Grade Form",
            'breadcrumbs' => [
                [
                    'link' => route('student'),
                    'label' => 'Student',
                ], [
                    'link' => route('student.curriculum', ['user' => $this->user_id]),
                    'label' => 'Curriculum',
                ], [
                    'label' => 'Grade Form',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getUser()
    {
        return User::find($this->user_id);
    }

    protected function getCurriculum()
    {
        $user_id = $this->user_id;

        return Curriculum::query()
            ->with([
                'program',
                'references',
                'courses.course.grades' => function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                },
            ])
            ->whereHas('users', function ($query) use ($user_id) {
                $query->where('users.id', $user_id);
            })
            ->first();
    }
}
