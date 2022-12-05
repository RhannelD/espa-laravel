<?php

namespace App\Http\Livewire\Course;

use App\Models\Course;
use App\Traits\AlertTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class CourseLivewire extends Component
{
    use AuthorizesRequests;
    use AlertTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search, $showRow = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'showRow' => ['except' => 10, 'as' => 'row'],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->authorize('viewAny', Course::class);
    }

    public function hydrate()
    {
        if (Gate::denies('viewAny', Course::class)) {
            return redirect(url()->previous());
        }
    }

    public function render()
    {
        return view('livewire.course.course-livewire', [
            'courses' => $this->getCourses(),
        ])->extends('layouts.app', [
            'active_nav' => 'course',
            'title' => 'Course',
            'breadcrumbs' => [
                [
                    'link' => route('course'),
                    'label' => 'Course',
                ], [
                    'label' => 'List',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getCourses()
    {
        return Course::query()
            ->search($this->search)
            ->paginate($this->showRow);
    }

    public function delete($id)
    {
        $course = Course::find($id);
        if (Gate::allows('delete', $course) && $course->delete()) {
            $this->alert_success('Record Deleted!');
        }
    }
}
