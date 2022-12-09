<?php

namespace App\Http\Livewire\Curriculum\Form;

use App\Models\Course;
use App\Models\Curriculum;
use App\Traits\AlertTrait;
use App\Traits\ModalTrait;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class CurriculumCourseAddModalLivewire extends Component
{
    use AlertTrait;
    use ModalTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $modal_id = 'course-add-modal';

    public $curriculum_id;
    public $year;
    public $semester;

    public $search, $showRow = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'showRow' => ['except' => 10, 'as' => 'row'],
    ];

    protected $listeners = [
        'open_selection' => 'openSelection',
    ];

    public function mount($curriculum_id)
    {
        $this->curriculum_id = $curriculum_id;
    }

    public function openSelection($year, $semester)
    {
        $this->year = $year;
        $this->semester = $semester;
        $this->resetPage();
        $this->show_modal($this->modal_id);
    }

    public function render()
    {
        return view('livewire.curriculum.form.curriculum-course-add-modal-livewire', [
            'courses' => $this->getCourses()
        ]);
    }

    protected function getCourses()
    {
        $curriculum_id = $this->curriculum_id;

        return Course::query()
            ->search($this->search)
            ->whereDoesntHave('curriculum_courses', function($query) use ($curriculum_id) {
                $query->where('curriculum_id', $curriculum_id);
            })
            ->paginate($this->showRow);
    }

    public function addCourse($course_id)
    {
        $curriculum = Curriculum::find($this->curriculum_id);
        if (Gate::denies('update', $curriculum) || !Course::where('id', $course_id)->exists()) {
            return;
        }

        if ($curriculum->courses()->where('course_id', $course_id)->exists()) {
            $this->alert_error('Course Already Added!');
            return;
        }

        $curriculum_course = $curriculum->courses()->create([
            'course_id' => $course_id,
            'year' => $this->year,
            'semester' => $this->semester,
        ]);

        if ($curriculum_course->wasRecentlyCreated) {
            session()->flash('successful', 'Course successfully added.');

            $this->emitTo('curriculum.form.curriculum-course-semester-livewire', "refresh_{$this->year}y_{$this->semester}s_courses");
        }
    }
}
