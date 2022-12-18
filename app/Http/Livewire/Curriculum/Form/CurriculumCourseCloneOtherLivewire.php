<?php

namespace App\Http\Livewire\Curriculum\Form;

use App\Models\Curriculum;
use App\Traits\AlertTrait;
use App\Traits\ModalTrait;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class CurriculumCourseCloneOtherLivewire extends Component
{
    use AlertTrait;
    use ModalTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $modal_id = 'curriculum-clone-other-modal';

    public $curriculum_id;

    public $search, $showRow = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'showRow' => ['except' => 10, 'as' => 'row'],
    ];

    protected $listeners = [
        'open_other_clone_selection' => 'openOtherCloneSelection',
    ];

    public function mount($curriculum_id)
    {
        $this->curriculum_id = $curriculum_id;
    }

    public function openOtherCloneSelection()
    {
        $this->show_modal($this->modal_id);
    }

    public function render()
    {
        return view('livewire.curriculum.form.curriculum-course-clone-other-livewire', [
            'curricula' => $this->getCurricula(),
        ]);
    }

    protected function getCurricula()
    {
        return Curriculum::query()
            ->with(['program.college'])
            ->search($this->search, Curriculum::SEARCHFILTERS + ['program' => ['abbreviation', 'college' => ['abbreviation']]])
            ->where('id', '!=', $this->curriculum_id)
            ->has('courses')
            ->paginate($this->showRow);
    }

    public function duplicate($duplicate_curriculum_id)
    {
        $curriculum_duplicating = Curriculum::find($duplicate_curriculum_id);
        if (Gate::denies('duplicate', $curriculum_duplicating)) {
            $this->alert_error('You dont have permission!');
            return;
        }

        $curriculum_id = $this->curriculum_id;
        $curriculum = Curriculum::find($curriculum_id);
        if (Gate::denies('update', $curriculum)) {
            $this->alert_error('You dont have permission!');
            return;
        }

        $toRefreshSemesters = $curriculum->courses()
            ->select('year', 'semester')
            ->groupBy('year')
            ->groupBy('semester')
            ->toBase()
            ->get();

        $curriculum->courses()->delete();

        $curriculum_duplicating->courses()->orderBy('year')->orderBy('semester')->chunkById(20, function ($curriculum_courses) use ($curriculum, $toRefreshSemesters) {
            $curriculum_courses->each(function ($curriculum_course) use ($curriculum, $toRefreshSemesters) {
                $toRefreshSemesterExist = $toRefreshSemesters->where('year', $curriculum_course->year)->where('semester', $curriculum_course->semester)->first();
                if (is_null($toRefreshSemesterExist)) {
                    $toRefreshSemesters->push((object) [
                        'year' => $curriculum_course->year,
                        'semester' => $curriculum_course->semester,
                    ]);
                }

                $curriculum_course = $curriculum_course->duplicate();
                $curriculum_course->update(['curriculum_id' => $curriculum->id]);

                $curriculum_course->curriculum_course_prerequisites->each(function ($duplicatedCurriculumCoursePrerequisite) use ($curriculum) {
                    // Querying the right Pre-Requisite for the Duplicated Curriculum Course
                    $duplicatedCurriculumCourseMustPrerequisite = $curriculum->courses()
                        ->where('course_id', $duplicatedCurriculumCoursePrerequisite->prerequisite_curriculum_course->course_id)
                        ->first();

                    // Updating the right Pre-Requisite for the Duplicated Curriculum Course
                    if (isset($duplicatedCurriculumCourseMustPrerequisite)) {
                        $duplicatedCurriculumCoursePrerequisite->update([
                            'prerequisite_cc_id' => $duplicatedCurriculumCourseMustPrerequisite->id,
                        ]);
                    }
                });
            });
        });

        $this->alert_success('Curriculum Courses Duplication Successfully');
        $this->hide_modal($this->modal_id);

        $toRefreshSemesters->each(function($toRefreshSemester) {
            $this->emitTo('curriculum.form.curriculum-course-semester-livewire', "refresh_{$toRefreshSemester->year}y_{$toRefreshSemester->semester}s_courses");
        });
    }
}
