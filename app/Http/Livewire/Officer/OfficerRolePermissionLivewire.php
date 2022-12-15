<?php

namespace App\Http\Livewire\Officer;

use App\Models\User;
use App\Traits\AlertTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class OfficerRolePermissionLivewire extends Component
{
    use AuthorizesRequests;
    use AlertTrait;

    public $user_id;
    public $role_id;

    public $rules = [
        'role_id' => 'nullable|exists:roles,id',
    ];

    public $validationAttributes = [
        'role_id' => 'role',
    ];

    public function mount(User $user)
    {
        $this->authorize('updateOfficerRoleAccess', $user);
        $this->user_id = $user->id;

        $role = $user->roles()->first();
        $this->role_id = is_null($role) ? null : $role->id;
    }

    public function render()
    {
        return view('livewire.officer.officer-role-permission-livewire', [
            'officer' => $this->getOfficer()->load('roles.permissions'),
            'roles' => $this->getRoles(),
            'permissions' => $this->getPermissions(),
        ])->extends('layouts.app', [
            'active_nav' => 'officer',
            'title' => 'Officer Role and Permission',
            'breadcrumbs' => [
                [
                    'link' => route('officer'),
                    'label' => 'Officer',
                ], [
                    'label' => 'Role and Permission',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getOfficer()
    {
        return User::find($this->user_id);
    }

    protected function getRoles()
    {
        return Role::query()
            ->where('name', '!=', 'Super Admin')
            ->toBase()
            ->get();
    }

    protected function getPermissions()
    {
        return Permission::query()
            ->toBase()
            ->get();
    }

    public function updatedRoleId($value)
    {
        $this->validateOnly('role_id');

        $officer = $this->getOfficer();
        if (Gate::denies('updateOfficerRoleAccess', $officer)) {
            return;
        }

        if (empty($value)) {
            $officer->syncRoles([]);
            return;
        }

        $role = Role::find($value);
        if ($officer->hasRole($role->name)) {
            return;
        }

        $officer->syncRoles([]);
        $officer->assignRole($role->name);
    }

    public function toggle_permission($permission)
    {
        if (!Permission::where('name', $permission)->exists()) {
            return;
        }

        $officer = $this->getOfficer();
        if (Gate::denies('updateOfficerRoleAccess', $officer)) {
            return;
        }
        $officer = $officer->load('roles.permissions:name');

        foreach ($officer->roles as $role) {
            $existOnRole = $role->permissions->where('name', $permission)->count();
            if ($existOnRole) {
                return;
            }
        }

        $officer->hasPermissionTo($permission) ? $officer->revokePermissionTo($permission) : $officer->givePermissionTo($permission);
    }
}
