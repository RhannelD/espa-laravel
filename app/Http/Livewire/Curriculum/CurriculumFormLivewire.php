<?php

namespace App\Http\Livewire\Curriculum;

use App\Models\College;
use App\Models\Curriculum;
use App\Models\CurriculumReference;
use App\Models\Program;
use App\Traits\AlertTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CurriculumFormLivewire extends Component
{
    use AuthorizesRequests;
    use AlertTrait;

    public $curriculum_id;
    public $curriculum;
    public $college_id;
    public $references = [['id' => "0", 'reference' => '']];

    protected function rules()
    {
        return [
            'college_id' => "required|exists:colleges,id",
            'curriculum.program_id' => "required|exists:programs,id",
            'curriculum.track' => "required",
            'curriculum.academic_year' => "required|digits:4|integer|min:1900|max:".(date('Y')+2),
            'references' => "required|array|min:1",
            'references.*.id' => "required|integer|min:0",
            'references.*.reference' => "required|distinct",
        ];
    }

    protected $validationAttributes = [
        'college_id' => 'college',
        'curriculum.program_id' => 'program',
        'references.*.reference' => 'reference',
    ];

    public function mount($curriculum_id=null)
    {
        $this->curriculum_id = $curriculum_id;
        $curriculum = Curriculum::find($curriculum_id);

        abort_if(isset($curriculum_id) && is_null($curriculum), 404);
        $this->authorize(is_null($curriculum_id)? 'create': 'update', is_null($curriculum_id)? Curriculum::class: $curriculum);

        $this->curriculum = $curriculum? $curriculum->replicate(): new Curriculum;
        $this->college_id = $curriculum? $curriculum->program->college_id: null;
        $this->references = $curriculum? $curriculum->references()->select('id', 'reference')->get()->toArray(): $this->references;
    }

    public function render()
    {
        return view('livewire.curriculum.curriculum-form-livewire', [
            'colleges' => $this->getColleges(),
            'programs' => $this->getPrograms(),
        ])->extends('layouts.app', [
            'active_nav' => 'curriculum',
            'title' => (is_null($this->curriculum_id)? 'Create': 'Update').' Curriculum',
            'breadcrumbs' => [
                [
                    'link' => route('curriculum'),
                    'label' => 'Curriculum',
                ], [
                    'label' => is_null($this->curriculum_id)? 'Create': 'Update',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getColleges()
    {
        return College::get();
    }

    protected function getPrograms()
    {
        return Program::query()
            ->where('college_id', $this->college_id)
            ->get();
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function updatedCollegeId($value)
    {
        $this->curriculum->program_id = null;
    }

    public function addReference()
    {
        $this->references[] =[
            'id' => "0",
            'reference' => '',
        ];
    }

    public function removeReference($index)
    {
        unset($this->references[$index]);
    }

    public function save()
    {
        $data = $this->validate();

        $redirect = isset($this->curriculum_id)
            ? $this->update($data)
            : $this->store($data);

        if ($redirect) {
            return redirect()->route('curriculum');
        }
    }

    protected function store($data)
    {
        if ( Gate::denies('create', Curriculum::class) ) {
            return;
        }
        
        $curriculum = Curriculum::create($data['curriculum']);
    
        if ( $curriculum->wasRecentlyCreated ) {
            foreach ($data['references'] as $reference) {
                $curriculum->references()->create($reference);
            }
            $this->session_flash_alert_info('Success!', 'Record has been successfully added');
            return true;
        }
    }

    protected function update($data)
    {
        $curriculum = Curriculum::find($this->curriculum_id);
        if ( Gate::denies('update', $curriculum) ) {
            return;
        }

        $updated = false;
        if ($curriculum->update($data['curriculum'])) {
            $updated = true;
        }

        $references = collect($data['references']);

        if ($curriculum->references()->whereNotIn('id', $references->where('id', '!=', 0)->pluck('id'))->delete()) {
            $updated = true;
        }
        foreach ($references as $reference) {
            $curriculum->references()->updateOrCreate([
                'id' => $reference['id'],
            ], [
                'reference' => $reference['reference'],
            ]);
        }
        
        $this->session_flash_alert_info('Success!', 'Record has been successfully updated');
        return $updated;
    }
}
