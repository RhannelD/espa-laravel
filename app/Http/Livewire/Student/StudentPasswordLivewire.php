<?php

namespace App\Http\Livewire\Student;

use App\Models\User;
use Livewire\Component;
use App\Traits\AlertTrait;
use App\Traits\ModalTrait;
use App\Rules\ConfirmPasswordRule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class StudentPasswordLivewire extends Component
{
    use AlertTrait;
    use ModalTrait;
    public $modal = 'student-password-modal';

    public $user_id;
    public $password;
    public $user_password;

    protected $rules = [
        'password' => "required|min:6",
        'user_password' => ["required"],
    ];

    protected $validationAttributes = [
        'password' => 'new password',
    ];

    protected $messages = [
        'user_password.required' => 'Your password is required.',
    ];

    protected $listeners = [
        'edit' => 'edit',
    ];

    public function edit($user_id)
    {
        $exists = User::whereId($user_id)->exists();
        if ($exists) {
            $this->user_id = $user_id;
            $this->show_modal($this->modal);
        }
    }

    public function render()
    {
        return view('livewire.student.student-password-livewire', [
            'student_name' => $this->getStudentName(),
        ]);
    }

    protected function getStudentName()
    {
        return User::find($this->user_id)->flname?? '';
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function save()
    {
        $rules = $this->rules;
        $rules['user_password'][] = new ConfirmPasswordRule;

        $data = $this->validate($rules);

        $student = User::find($this->user_id);
        if (Gate::allows('updatePassword', $student) && $student->update(['password' => Hash::make($data['password'])])) {
            $this->hide_modal($this->modal);
            $this->alert_success('Password Successfully Change');
            $this->reset(['password','user_password']);
        }
    }
}
