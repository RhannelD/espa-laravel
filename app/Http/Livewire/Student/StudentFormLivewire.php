<?php

namespace App\Http\Livewire\Student;

use App\Models\User;
use Livewire\Component;
use App\Rules\SrCodeRule;
use App\Traits\AlertTrait;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StudentFormLivewire extends Component
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
            'user.sr_code' => ["required", "unique:users,sr_code,{$this->user_id},id", new SrCodeRule],
            'user.email' => "required|unique:users,email,{$this->user_id},id",
            'user.sex' => "required|in:male,female",
        ];
    }

    public function mount($user_id=null)
    {
        $this->user_id = $user_id;
        $user = User::find($user_id);

        abort_if(isset($user_id) && is_null($user), 404);
        $this->authorize(is_null($user_id)? 'createStudent': 'updateStudent', is_null($user_id)? User::class: $user);

        $this->user = $user? $user->replicate(): new User;
    }

    public function render()
    {
        return view('livewire.student.student-form-livewire')->extends('layouts.app', [
            'active_nav' => 'student',
            'title' => (is_null($this->user_id)? 'Create': 'Update').' Student',
            'breadcrumbs' => [
                [
                    'link' => route('student'),
                    'label' => 'Student',
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

        isset($this->user_id)
            ? $this->update($data)
            : $this->store($data);
    }

    protected function store($data)
    {
        if ( Gate::denies('createStudent', User::class) ) {
            return;
        }
        
        $user = User::create($data['user']+[
            'password' => Hash::make('password'),
        ]);
    
        if ( $user->wasRecentlyCreated ) {
            $this->session_flash_alert_info('Success!', 'Record has been successfully added');
            return redirect()->route('student.curriculum.form', ['user' => $user->id]);
        }
    }

    protected function update($data)
    {
        $user = User::find($this->user_id);
        if ( Gate::allows('updateStudent', $user) && $user->update($data['user']) ) {
            $this->session_flash_alert_info('Success!', 'Record has been successfully updated');
            return redirect()->route('student');
        }
    }
}
