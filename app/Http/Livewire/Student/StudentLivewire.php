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

    protected $listeners = [
        'searching' => '$refresh',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'showRow' => ['except' => 10, 'as' => 'row'],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->authorize('viewAnyStudent', User::class);
    }

    public function hydrate()
    {
        if (Gate::denies('viewAnyStudent', User::class)) {
            return redirect(url()->previous());
        }
    }

    public function render()
    {
        return view('livewire.student.student-livewire', [
            'students' => $this->getStudents(),
        ])->extends('layouts.app', [
            'active_nav' => 'student',
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
            ->withCount('curriculum as has_curriculum')
            ->search($this->search)
            ->isStudent()
            ->paginate($this->showRow);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (Gate::allows('deleteStudent', $user) && $user->delete()) {
            $this->alert_success('Record Deleted!');
        }
    }
}
