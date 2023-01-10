<?php

namespace App\Http\Livewire\Student;

use App\Models\User;
use App\Traits\AlertTrait;
use App\Traits\FilterTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class StudentLivewire extends Component
{
    use AuthorizesRequests;
    use AlertTrait;
    use FilterTrait;
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
            'filter_colleges' => $this->getFilterColleges(),
            'filter_programs' => $this->getFilterPrograms(),
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
        $filters = $this->filters;

        return User::query()
            ->withCount('curriculum as has_curriculum')
            ->search($this->search)
            ->isStudent()
            ->when(!empty($filters['program_id']), function ($query) use ($filters) {
                $query->whereHas('student.curriculum', function ($query) use ($filters) {
                    $query->where('program_id', $filters['program_id']);
                });
            }, function ($query) use ($filters) {
                $query->when(!empty($filters['college_id']), function ($query) use ($filters) {
                    $query->whereHas('student.curriculum.program', function ($query) use ($filters) {
                        $query->where('college_id', $filters['college_id']);
                    });
                });
            })
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
