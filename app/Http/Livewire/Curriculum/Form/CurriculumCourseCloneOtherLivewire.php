<?php

namespace App\Http\Livewire\Curriculum\Form;

use App\Models\Curriculum;
use App\Traits\AlertTrait;
use App\Traits\ModalTrait;
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

        $curriculum->courses()->delete();

        $curriculum_duplicating->courses()->chunkById(20, function($curriculum_courses) use ($curriculum_id) {
            $curriculum_courses->each(function ($curriculum_course) use ($curriculum_id) {
                $curriculum_course->replicate()->fill(['curriculum_id'=>$curriculum_id])->save();
            });
        });

        $this->alert_success('Curriculum Courses Duplication Successfully');
        $this->hide_modal($this->modal_id);
        $this->emitTo('curriculum.form.curriculum-course-semester-livewire', 'refresh');
    }
}
