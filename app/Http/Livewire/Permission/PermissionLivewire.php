<?php

namespace App\Http\Livewire\Permission;

use App\Traits\AlertTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class PermissionLivewire extends Component
{
    use AuthorizesRequests;
    use AlertTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search, $showRow = 10;

    protected $listeners = [
        'searching' => '$refresh',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'showRow' => ['except' => 10, 'as' => 'row'],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->authorize('viewAny', Permission::class);
    }

    public function hydrate()
    {
        if (Gate::denies('viewAny', Permission::class)) {
            return redirect(url()->previous());
        }
    }

    public function render()
    {
        return view('livewire.permission.permission-livewire', [
            'permissions' => $this->getPermissions(),
        ])->extends('layouts.app', [
            'active_nav' => 'permission',
            'title' => 'Permission',
            'breadcrumbs' => [
                [
                    'link' => route('permission'),
                    'label' => 'Permission',
                ], [
                    'label' => 'List',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getPermissions()
    {
        return Permission::query()
            ->where('name', 'like', "%$this->search%")
            ->paginate($this->showRow);
    }
}
