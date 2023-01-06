<?php

namespace App\Http\Livewire\Student\Grade;

use App\Models\Course;
use App\Models\Grade;
use App\Models\User;
use App\Traits\AlertTrait;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class GradeFormLivewire extends Component
{
    use AlertTrait;

    public $user_id;
    public $course_id;
    public $grade;

    protected $rules = [
        'grade.grade' => [
            "in:1,1.25,1.5,1.75,2,2.25,2.5,2.75,3,INC,5,",
        ],
        'course_id' => 'exists:courses,id',
    ];

    public function mount($course_id, $user_id)
    {
        $this->course_id = $course_id;
        $this->user_id = $user_id;
        $this->grade = new Grade;
    }

    public function render()
    {
        return view('livewire.student.grade.grade-form-livewire', [
            'course' => $this->getCourse(),
        ]);
    }

    protected function getCourse()
    {
        return Course::find($this->course_id);
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function save()
    {
        $rules = $this->rules;
        $rules['grade.grade'][] = 'required';

        $data = $this->validate($rules);

        $this->save_grade($data);
    }

    protected function save_grade($data)
    {
        $user = User::find($this->user_id);
        if (Gate::denies('updateStudentGrade', $user)) {
            return;
        }

        $grade = $user->grades()->create($data['grade'] + [
            'course_id' => $data['course_id'],
        ]);

        if ($grade->wasRecentlyCreated) {
            $this->alert_success('Graded Successfully');
            $this->emitUp('refresh');
        }
    }
}
