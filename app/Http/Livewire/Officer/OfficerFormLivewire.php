<?php

namespace App\Http\Livewire\Officer;

use App\Models\User;
use App\Traits\AlertTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class OfficerFormLivewire extends Component
{
    use AuthorizesRequests;
    use AlertTrait;

    public $user_id;
    public $user;

    protected function rules()
    {
        return [
            'user.firstname' => "required",
            'user.lastname' => "required",
            'user.email' => "required|unique:users,email,{$this->user_id},id",
            'user.sex' => "required|in:male,female",
        ];
    }

    public function mount($user_id=null)
    {
        $this->user_id = $user_id;
        $user = User::find($user_id);

        abort_if(isset($user_id) && is_null($user), 404);
        $this->authorize(is_null($user_id)? 'createOfficer': 'updateOfficer', is_null($user_id)? User::class: $user);

        $this->user = $user? $user->replicate(): new User;
    }

    public function render()
    {
        return view('livewire.officer.officer-form-livewire')->extends('layouts.app', [
            'active_nav' => 'officer',
            'title' => (is_null($this->user_id)? 'Create': 'Update').' Officer',
            'breadcrumbs' => [
                [
                    'link' => route('officer'),
                    'label' => 'Officer',
                ], [
                    'label' => is_null($this->user_id)? 'Create': 'Update',
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

        $redirect = isset($this->user_id)
            ? $this->update($data)
            : $this->store($data);

        if ($redirect) {
            return redirect()->route('officer');
        }
    }

    protected function store($data)
    {
        if ( Gate::denies('createOfficer', User::class) ) {
            return;
        }
        
        $user = User::create($data['user']+[
            'password' => Hash::make('password'),
        ]);
    
        if ( $user->wasRecentlyCreated ) {
            $this->session_flash_alert_info('Success!', 'Record has been successfully added');
            return true;
        }
    }

    protected function update($data)
    {
        $user = User::find($this->user_id);
        if ( Gate::allows('updateOfficer', $user) && $user->update($data['user']) ) {
            $this->session_flash_alert_info('Success!', 'Record has been successfully updated');
            return true;
        }
    }
}
