<?php

namespace App\Http\Livewire\Officer;

use App\Http\Livewire\Student\StudentPasswordLivewire;
use Illuminate\Support\Facades\Gate;

class OfficerPasswordLivewire extends StudentPasswordLivewire
{
    public function render()
    {
        return view('livewire.officer.officer-password-livewire', [
            'user_name' => $this->getUserName(),
        ]);
    }

    protected function userCanUpdatePassword($user)
    {
        return Gate::allows('updateOfficerPassword', $user);
    }
}
