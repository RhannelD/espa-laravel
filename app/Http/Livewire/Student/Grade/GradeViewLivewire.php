<?php

namespace App\Http\Livewire\Student\Grade;

use App\Models\Grade;
use Livewire\Component;

class GradeViewLivewire extends Component
{
    public $grade_id;

    public function mount($grade_id)
    {
        $this->grade_id = $grade_id;
    }

    public function render()
    {
        return view('livewire.student.grade.grade-view-livewire', [
            'grade' => $this->getGrade(),
        ]);
    }

    public function getGrade()
    {
        return Grade::find($this->grade_id);
    }
}
