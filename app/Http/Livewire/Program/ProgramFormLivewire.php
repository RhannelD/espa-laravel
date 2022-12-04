<?php

namespace App\Http\Livewire\Program;

use App\Models\College;
use App\Models\Program;
use Livewire\Component;
use App\Traits\AlertTrait;
use Illuminate\Support\Facades\Gate;

class ProgramFormLivewire extends Component
{
    use AlertTrait;

    public $program_id;
    public $program;

    protected function rules()
    {
        return [
            'program.college_id' => "required|exists:colleges,id",
            'program.abbreviation' => "required|unique:programs,abbreviation,{$this->program_id},id",
            'program.program' => "required|unique:programs,program,{$this->program_id},id",
        ];
    }

    public function mount($program_id=null)
    {
        $this->program_id = $program_id;
        $program = Program::find($program_id);
        abort_if(isset($program_id) && is_null($program), 404);
        $this->program = $program? $program->replicate(): new Program;
    }

    public function render()
    {
        return view('livewire.program.program-form-livewire', [
            'colleges' => $this->getColleges(),
        ])->extends('layouts.app', [
            'active_nav' => 'program',
            'title' => (is_null($this->program_id)? 'Create': 'Update').' Program',
            'breadcrumbs' => [
                [
                    'link' => route('program'),
                    'label' => 'Program',
                ], [
                    'label' => is_null($this->program_id)? 'Create': 'Update',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getColleges()
    {
        return College::get();
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function save()
    {
        $data = $this->validate();

        $redirect = isset($this->program_id)
            ? $this->update($data)
            : $this->store($data);

        if ($redirect) {
            return redirect()->route('program');
        }
    }

    protected function store($data)
    {
        if ( Gate::denies('create', Program::class) ) {
            return;
        }
        
        $program = Program::create($data['program']);
    
        if ( $program->wasRecentlyCreated ) {
            $this->session_flash_alert_info('Success!', 'Record has been successfully added');
            return true;
        }
    }

    protected function update($data)
    {
        $program = Program::find($this->program_id);
        if ( Gate::allows('update', $program) && $program->update($data['program']) ) {
            $this->session_flash_alert_info('Success!', 'Record has been successfully updated');
            return true;
        }
    }
}
