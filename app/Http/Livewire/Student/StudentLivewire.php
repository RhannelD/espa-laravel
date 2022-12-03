<?php

namespace App\Http\Livewire\Student;

use Livewire\Component;

class StudentLivewire extends Component
{
    public function render()
    {
        return view('livewire.student.student-livewire')->extends('layouts.app');
    }
}
