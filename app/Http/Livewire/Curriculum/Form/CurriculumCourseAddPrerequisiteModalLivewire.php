<?php

namespace App\Http\Livewire\Curriculum\Form;

use App\Models\CurriculumCourse;
use App\Traits\AlertTrait;
use App\Traits\ModalTrait;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class CurriculumCourseAddPrerequisiteModalLivewire extends Component
{
    use AlertTrait;
    use ModalTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $modal_id = 'course-prerequisit-add-modal';

    public $curriculum_course_id;
    public $year = 0;
    public $semester = 0;

    public $search, $showRow = 10;

    protected $queryString = [
        'search' => ['except' => '', 'as' => 'search_req'],
        'showRow' => ['except' => 10, 'as' => 'row_req'],
        'page' => ['except' => 1, 'as' => 'page_req'],
    ];

    protected $listeners = [
        'open_selection' => 'openSelection',
    ];

    public function openSelection($curriculum_course_id)
    {
        $curriculum_course = CurriculumCourse::find($curriculum_course_id);
        if (isset($curriculum_course)) {
            $this->curriculum_course_id = $curriculum_course_id;
            $this->year = $curriculum_course->year;
            $this->semester = $curriculum_course->semester;
            $this->resetPage();
            $this->show_modal($this->modal_id);
        }
    }

    public function render()
    {
        return view('livewire.curriculum.form.curriculum-course-add-prerequisite-modal-livewire', [
            'curriculum_courses' => $this->getCourses(),
        ]);
    }

    protected function getCourses()
    {
        $search = $this->search;
        $curriculum_course_id = $this->curriculum_course_id;
        $year = $this->year;
        $semester = $this->semester;

        return CurriculumCourse::query()
            ->with('course')
            ->where('id', '!=', $curriculum_course_id)
            ->where(function ($query) use ($year, $semester) {
                $query->where('year', '<', $year)
                    ->orWhere(function ($query) use ($year, $semester) {
                        $query->where('year', $year)
                            ->where('semester', '<', $semester);
                    });
            })
            ->whereHas('course', function ($query) use ($search) {
                $query->search($search);
            })
            ->whereHas('curriculum.courses', function ($query) use ($curriculum_course_id) {
                $query->where('id', $curriculum_course_id);
            })
            ->whereDoesntHave('corequisite_curriculum_courses', function ($query) use ($curriculum_course_id) {
                $query->where('corequisite_cc_id', $curriculum_course_id);
            })
            ->paginate($this->showRow);
    }

    public function addCurriculumCoursePrerequisite($curriculum_course_id)
    {
        $corequisite_curriculum_course = CurriculumCourse::find($this->curriculum_course_id);
        if (is_null($corequisite_curriculum_course) || Gate::denies('update', $corequisite_curriculum_course->curriculum)) {
            return;
        }

        $prerequisite_curriculum_course = CurriculumCourse::find($curriculum_course_id);
        if (is_null($prerequisite_curriculum_course)) {
            return;
        }

        $added_prerequisite = $corequisite_curriculum_course->curriculum_course_prerequisites()->firstOrCreate([
            'prerequisite_cc_id' => $curriculum_course_id,
        ]);

        if ($added_prerequisite->wasRecentlyCreated) {
            session()->flash('successful', 'Course successfully added.');

            $this->emit("refresh_curriculum_course_{$this->curriculum_course_id}");
            $this->emit("refresh_curriculum_course_{$curriculum_course_id}");
        }
    }
}
