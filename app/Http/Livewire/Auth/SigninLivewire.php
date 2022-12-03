<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Traits\AlertTrait;
use Illuminate\Support\Facades\Auth;

class SigninLivewire extends Component
{
    use AlertTrait;
    
    public $email;
    public $password;
    public $rememberme;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function render()
    {
        return view('livewire.auth.signin-livewire')->extends('layouts.blank');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    public function signin()
    {
        $credentials = $this->validate();

        if (Auth::attempt($credentials, $this->rememberme)) {
            return redirect()->intended('student');
        }

        $this->reset('password');
        $this->alert_error("Email and Password not match!");
    }
}
