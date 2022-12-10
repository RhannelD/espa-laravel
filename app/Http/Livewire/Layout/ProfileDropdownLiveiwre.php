<?php

namespace App\Http\Livewire\Layout;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProfileDropdownLiveiwre extends Component
{
    protected $listeners = [
        'refresh_profile_header' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.layout.profile-dropdown-liveiwre', [
            'user' => $this->getUser(),
        ]);
    }

    protected function getUser()
    {
        return Auth::user();
    }

    public function signout()
    {
        Auth::logout(); 
        redirect()->route('index');
    }
}
