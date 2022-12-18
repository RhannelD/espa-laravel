<?php

namespace App\Http\Livewire\Curriculum;

use App\Models\Curriculum;
use App\Traits\AlertTrait;
use App\Traits\ModalTrait;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CurriculumDuplicateLivewire extends Component
{
    use AlertTrait;
    use ModalTrait;

    public $curriculum_id;
    public $academic_year;

    protected $listeners = [
        'duplicate' => 'settingCurriculum',
    ];

    protected function rules()
    {
        return [
            'curriculum_id' => 'exists:curricula,id',
            'academic_year' => "required|digits:4|integer|min:1900|max:" . (date('Y') + 2),
        ];
    }

    public function mount($curriculum = null)
    {
        if (isset($curriculum)) {
            $this->settingCurriculum(Curriculum::find($curriculum));
        }
    }

    public function settingCurriculum(Curriculum $curriculum)
    {
        if (Gate::denies('duplicate', $curriculum)) {
            return;
        }
        $this->curriculum_id = $curriculum->id;
        $this->academic_year = $curriculum->academic_year;
        $this->show_modal('duplicate-modal');
    }

    public function render()
    {
        return view('livewire.curriculum.curriculum-duplicate-livewire');
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function duplicateCurriculum()
    {
        $data = $this->validate();
        $curriculum = Curriculum::find($this->curriculum_id);
        if (Gate::denies('duplicate', $curriculum)) {
            return;
        }

        $exists = Curriculum::query()
            ->where('program_id', $curriculum->program_id)
            ->where('track', $curriculum->track)
            ->where('academic_year', $data['academic_year'])
            ->exists();

        if ($exists) {
            $this->addError('academic_year', 'This curriculum\'s academic year already exists!');
            return;
        }

        if ($duplicatedCurriculum = $this->curriculumDuplication($curriculum, $data['academic_year'])) {
            $this->hide_modal('duplicate-modal');

            $this->session_flash_alert_success('Curriculum Duplicated!');

            return redirect()->route('curriculum.course', ['curriculum' => $duplicatedCurriculum->id]);
        }
    }

    protected function curriculumDuplication(Curriculum $curriculum, $academic_year)
    {
        $curriculum->academic_year = $academic_year;
        $duplicatedCurriculum = $curriculum->duplicate();

        // Correcting Duplicated Curriculum Course's with Pre-Requisite/s because \Bkwld\Cloner\Cloneable is not capable of duplicating CurriculumCoursePrerequisite correctly because of foreign id prerequisite_cc_id

        // Querying each Duplicated Curriculum Courses with wrong Pre-Requisite/s
        $duplicatedCurriculum->courses()
            ->with('curriculum_course_prerequisites.prerequisite_curriculum_course')
            ->whereHas('curriculum_course_prerequisites')
            ->chunkById(20, function ($duplicatedCurriculumCourses) use ($duplicatedCurriculum) {
                // Each Duplicated Curriculum Courses with wrong Pre-Requisite/s
                $duplicatedCurriculumCourses->each(function ($duplicatedCurriculumCourse) use ($duplicatedCurriculum) {
                    // Each wrong Pre-Requisites of the Duplicated Curriculum Course
                    $duplicatedCurriculumCourse->curriculum_course_prerequisites->each(function ($duplicatedCurriculumCoursePrerequisite) use ($duplicatedCurriculum) {
                        // Querying the right Pre-Requisite for the Duplicated Curriculum Course
                        $duplicatedCurriculumCourseMustPrerequisite = $duplicatedCurriculum->courses()
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

        return $duplicatedCurriculum;
    }
}
