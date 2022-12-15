<div>
    <div wire:ignore>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>
            This form has auto saved feature. Think before you click.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <x-card.card>
        <h4 class="card-title pt-0 pb-0">
            Officer Information
        </h4>
        <x-table.table class="table-borderless">
            <tbody>
                <tr>
                    <td class="pe-2" style="width: 10px;">Officer: </td>
                    <td class="fw-semibold">{{ $officer->flname }}</td>
                </tr>
                <tr>
                    <td class="pe-2">Email: </td>
                    <td class="fw-semibold">{{ $officer->email }}</td>
                </tr>
                <tr>
                    <td class="pe-2">Sex: </td>
                    <td class="fw-semibold text-capitalize">{{ $officer->sex }}</td>
                </tr>
            </tbody>
        </x-table.table>
        <h4 class="card-title pt-0 pb-0">
            Role
        </h4>
        <div>
            <select wire:model="role_id" class="form-select">
                <option value="">No Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role_id') <small class="text-danger"> {{ $message }} </small> @enderror
        </div>
    </x-card.card>

    <x-card.card>
        <h4 class="card-title pt-0 pb-0">
            Permissions
        </h4>
        <x-table.table>
            <thead>
                <tr>
                    <th scope="col" style="min-width: 50px; max-width: 50px;"></th>
                    <th scope="col">Group</th>
                    <th scope="col">Permission</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $role = $officer->roles->first();
                @endphp
                @foreach ($permissions->groupBy('group') as $permissions_group)
                    @foreach ($permissions_group as $permission)
                        <tr id="r-{{ $permission->id }}">
                            <th class="border-start text-center" style="min-width: 50px; width: 50px;">
                                <div class="form-check form-switch px-0 me-0" style="width: 0;">
                                    <input wire:click="toggle_permission('{{ $permission->name }}')" class="form-check-input mx-0" type="checkbox" id="check-{{ $permission->id }}"
                                        {{ (isset($role) && $role->permissions->where('name', $permission->name)->count())? 'checked disabled': ($officer->hasPermissionTo($permission->name)? 'checked': '') }}>
                                </div>
                            </th>
                            @if ($loop->first)
                                <td rowspan="{{ $permissions_group->count() }}" class="align-middle border-start border-end">
                                    {{ $permission->group }}
                                </td>
                            @endif
                            <td class="border-end">
                                {{ $permission->name }}
                            </td>
                        </tr>
                    @endforeach
                @endforeach
        </x-table.table>
    </x-card.card>
</div>