<?php

namespace App\Http\Livewire\Student;

use App\Models\User;
use Livewire\Component;
use App\Traits\AlertTrait;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StudentLivewire extends Component
{
    use AuthorizesRequests;
    use AlertTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search, $showRow = 10;

    public function render()
    {
        return view('livewire.student.student-livewire', [
            'students' => $this->getStudents(),
        ])->extends('layouts.app', [
            'title' => 'Student',
            'breadcrumbs' => [
                [
                    'link' => route('student'),
                    'label' => 'Student',
                ], [
                    'label' => 'List',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getStudents()
    {
        return User::query()
            ->search($this->search)
            ->isStudent()
            ->paginate($this->showRow);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (Gate::allows('delete', $user) && $user->delete()) {
            $this->alert_success('Record Deleted!');
        }
    }
}
