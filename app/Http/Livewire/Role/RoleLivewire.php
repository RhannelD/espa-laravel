<?php

namespace App\Http\Livewire\Role;

use App\Traits\AlertTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RoleLivewire extends Component
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

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function mount()
    {
        $this->authorize('viewAny', Role::class);
    }

    public function hydrate()
    {
        if (Gate::denies('viewAny', Role::class)) {
            return redirect(url()->previous());
        }
    }

    public function render()
    {
        return view('livewire.role.role-livewire', [
            'roles' => $this->getRoles(),
        ])->extends('layouts.app', [
            'active_nav' => 'role',
            'title' => 'Role',
            'breadcrumbs' => [
                [
                    'link' => route('role'),
                    'label' => 'Role',
                ], [
                    'label' => 'List',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getRoles()
    {
        return Role::query()
            ->withCount('permissions')
            ->with([
                'permissions' => function ($query) {
                    $query->limit(6);
                },
            ])
            ->where('name', 'like', "%$this->search%")
            ->paginate($this->showRow);
    }

    public function delete($id)
    {
        $role = Role::find($id);
        if (Gate::allows('delete', $role) && $role->delete()) {
            $this->alert_success('Record Deleted!');
        }
    }
}
