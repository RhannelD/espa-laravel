<?php

namespace App\Http\Livewire\Evaluate;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class EvaluateLivewire extends Component
{
    use AuthorizesRequests;

    public $user_id;

    public $course_ids = [1, 2, 3, 4];

    public function mount(User $user)
    {
        $this->authorize('evaluateStudent', $user);
        $this->user_id = $user->id;
    }

    public function render()
    {
        return view('livewire.evaluate.evaluate-livewire', [
            'user' => $this->getUser(),
            'selected_courses' => $this->getSelectedCourses(),
        ])->extends('layouts.app', [
            'active_nav' => 'student',
            'title' => "Student Curriculum",
            'breadcrumbs' => [
                [
                    'link' => route('student'),
                    'label' => 'Student',
                ], [
                    'label' => 'Evaluate',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getUser()
    {
        return User::find($this->user_id);
    }

    protected function getSelectedCourses()
    {
        return Course::query()
            ->whereIn('id', $this->course_ids)
            ->toBase()
            ->get();
    }

    public function removeCourse($course_id)
    {
        if (($key = array_search($course_id, $this->course_ids)) !== false) {
            unset($this->course_ids[$key]);
        }
    }

    public function removeCourses()
    {
        $this->course_ids = [];
    }
}
