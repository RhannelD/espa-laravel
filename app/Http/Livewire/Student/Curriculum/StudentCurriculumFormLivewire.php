<?php

namespace App\Http\Livewire\Student\Curriculum;

use App\Models\Curriculum;
use App\Models\Student;
use App\Models\User;
use App\Traits\AlertTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class StudentCurriculumFormLivewire extends Component
{
    use AuthorizesRequests;
    use AlertTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $user_id;
    public $search, $showRow = 10, $intended;

    protected $listeners = [
        'searching' => '$refresh',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'showRow' => ['except' => 10, 'as' => 'row'],
        'page' => ['except' => 1],
    ];

    public function mount(User $user)
    {
        $this->authorize('viewStudentCurriculum', $user);
        $this->user_id = $user->id;

        $this->setUrlIntended(url()->current(), url()->previous());
    }

    public function hydrate()
    {
        if (Gate::denies('updateStudentCurriculum', $this->getUser())) {
            return redirect(url()->previous());
        }
    }

    public function setUrlIntended($current_url, $previous_url)
    {
        if (!empty($previous_url) && $current_url != $previous_url && $previous_url != route('student.form')) {
            session()->put('url.intended', $previous_url);
        } else {
            session()->forget('url.intended');
        }
    }

    public function render()
    {
        return view('livewire.student.curriculum.student-curriculum-form-livewire', [
            'user' => $this->getUser(),
            'curricula' => $this->getCurricula(),
        ])->extends('layouts.app', [
            'active_nav' => 'student',
            'title' => "Student Curriculum Form",
            'breadcrumbs' => [
                [
                    'link' => route('student'),
                    'label' => 'Student',
                ], [
                    'label' => 'Curriculum Form',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getUser()
    {
        return User::find($this->user_id);
    }

    protected function getCurricula()
    {
        $user_id = $this->user_id;
        return Curriculum::query()
            ->with([
                'program' => function ($query) {
                    $query->with('college');
                },
            ])
            ->search($this->search, Curriculum::SEARCHFILTERS + ['program' => ['abbreviation', 'college' => ['abbreviation']]])
            ->whereDoesntHave('students', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })
            ->paginate($this->showRow);
    }

    public function save($curriculum_id)
    {
        $curriculum_exist = Curriculum::where('id', $curriculum_id)->exists();
        if (!$curriculum_exist) {
            return;
        }

        $user = $this->getUser();
        if (Gate::allows('updateStudentCurriculum', $user) && $user->student()->updateOrCreate([], ['curriculum_id' => $curriculum_id])) {
            $this->session_flash_alert_info('Success!', 'Record has been successfully updated');
            return redirect()->intended(route('student'));
        }
    }
}
