<?php

namespace App\Http\Livewire\College;

use App\Models\College;
use Livewire\Component;
use App\Traits\AlertTrait;
use Illuminate\Support\Facades\Gate;

class CollegeFormLivewire extends Component
{
    use AlertTrait;

    public $college_id;
    public $college;

    protected function rules()
    {
        return [
            'college.abbreviation' => "required|unique:colleges,abbreviation,{$this->college_id},id",
            'college.college' => "required|unique:colleges,college,{$this->college_id},id",
        ];
    }

    public function mount($college_id=null)
    {
        $this->college_id = $college_id;
        $college = College::find($college_id);
        abort_if(isset($college_id) && is_null($college), 404);
        $this->college = $college? $college->replicate(): new College;
    }

    public function render()
    {
        return view('livewire.college.college-form-livewire')->extends('layouts.app', [
            'active_nav' => 'college',
            'title' => (is_null($this->college_id)? 'Create': 'Update').' College',
            'breadcrumbs' => [
                [
                    'link' => route('college'),
                    'label' => 'College',
                ], [
                    'label' => is_null($this->college_id)? 'Create': 'Update',
                    'active' => true,
                ],
            ],
        ]);
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function save()
    {
        $data = $this->validate();

        $redirect = isset($this->college_id)
            ? $this->update($data)
            : $this->store($data);

        if ($redirect) {
            return redirect()->route('college');
        }
    }

    protected function store($data)
    {
        if ( Gate::denies('create', College::class) ) {
            return;
        }
        
        $college = College::create($data['college']);
    
        if ( $college->wasRecentlyCreated ) {
            $this->session_flash_alert_info('Success!', 'Record has been successfully added');
            return true;
        }
    }

    protected function update($data)
    {
        $college = College::find($this->college_id);
        if ( Gate::allows('update', $college) && $college->update($data['college']) ) {
            $this->session_flash_alert_info('Success!', 'Record has been successfully updated');
            return true;
        }
    }
}
