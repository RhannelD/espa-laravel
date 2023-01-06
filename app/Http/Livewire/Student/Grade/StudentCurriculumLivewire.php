<?php

namespace App\Http\Livewire\Student\Grade;

use App\Models\Curriculum;
use App\Models\Grade;
use App\Models\Student;
use App\Models\User;
use App\Traits\AlertTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class StudentCurriculumLivewire extends Component
{
    use AuthorizesRequests;
    use AlertTrait;

    public $user_id;

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function mount(User $user)
    {
        $this->authorize('updateStudentGrade', $user);
        $this->user_id = $user->id;
        $this->hydrate();
    }

    public function hydrate()
    {
        $user = $this->getUser();
        if (!$user->curriculum()->exists()) {
            return redirect()->route('student.curriculum.form', ['user' => $this->user_id]);
        }

        if (Gate::denies('updateStudentGrade', $user)) {
            return redirect(url()->previous());
        }
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

    public function delete($grade_id)
    {
        $user = $this->getUser();
        if (Gate::allows('deleteStudentGrade', $user) && $user->grades()->where('id', $grade_id)->delete()) {
            $this->alert_success('Record Deleted!');
        }
    }
}
