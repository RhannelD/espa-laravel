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
            'academic_year' => "required|digits:4|integer|min:1900|max:".(date('Y')+2),
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

        $curriculum->academic_year = $data['academic_year'];
        if ($curriculum = $curriculum->duplicate()) {
            $this->hide_modal('duplicate-modal');

            $this->session_flash_alert_success('Curriculum Duplicated!');

            return redirect()->route('curriculum.course', ['curriculum' => $curriculum->id]);
        }
    }
}
