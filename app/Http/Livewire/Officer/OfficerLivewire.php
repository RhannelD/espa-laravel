<?php

namespace App\Http\Livewire\Officer;

use App\Models\User;
use App\Traits\AlertTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class OfficerLivewire extends Component
{
    use AuthorizesRequests;
    use AlertTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search, $showRow = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'showRow' => ['except' => 10, 'as' => 'row'],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->authorize('viewAnyOfficer', User::class);
    }

    public function hydrate()
    {
        if (Gate::denies('viewAnyOfficer', User::class)) {
            return redirect(url()->previous());
        }
    }

    public function render()
    {
        return view('livewire.officer.officer-livewire', [
            'officers' => $this->getOfficers(),
        ])->extends('layouts.app', [
            'active_nav' => 'officer',
            'title' => 'Officer',
            'breadcrumbs' => [
                [
                    'link' => route('officer'),
                    'label' => 'Officer',
                ], [
                    'label' => 'List',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getOfficers()
    {
        return User::query()
            ->search($this->search)
            ->isOfficer()
            ->paginate($this->showRow);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (Gate::allows('deleteOfficer', $user) && $user->delete()) {
            $this->alert_success('Record Deleted!');
        }
    }
}
