<?php

namespace App\Http\Livewire\Role;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionLivewire extends Component
{
    use AuthorizesRequests;
    
    public $role_id;

    public function mount(Role $role)
    {
        $this->authorize('update', $role);
        $this->role_id = $role->id;
    }

    public function render()
    {
        $role = $this->getRole();

        return view('livewire.role.role-permission-livewire', [
            'role' => $role->load('permissions'),
            'permissions' => $this->getPermisions(),
        ])->extends('layouts.app', [
            'active_nav' => 'role',
            'title' => "Role Permissions",
            'breadcrumbs' => [
                [
                    'link' => route('role'),
                    'label' => 'Role',
                ], [
                    'link' => route('role.permission', [$role->id]),
                    'label' => $role->name
                ], [
                    'label' => 'Permission',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getRole()
    {
        return Role::find($this->role_id);
    }

    protected function getPermisions()
    {
        return Permission::query()
            ->orderBy('group')
            ->get();
    }

    public function toggle_permission($permission)
    {
        $role = $this->getRole();
        if (Gate::denies('update', $role) && !Permission::where('name', $permission)->exists()) {
            return;
        }

        $role->hasPermissionTo($permission)? $role->revokePermissionTo($permission): $role->givePermissionTo($permission);
    }
}
