<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class DashboardLivewire extends Component
{
    use AuthorizesRequests;

    public function mount()
    {
        $this->authorize('viewAnyDashboard');
    }

    public function hydrate()
    {
        if (Gate::denies('viewAnyDashboard')) {
            return redirect(url()->previous());
        }
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-livewire');
    }
}
