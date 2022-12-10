<div>
    <div wire:ignore>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>
            This form has auto saved feature. Think before you click.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title pt-4 pb-0">
                <div class="w-100 btn btn-light text-start text-dark fw-semibold">
                    {{ $role->name }} > Permissions
                </div>
            </h4>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col" style="min-width: 50px; max-width: 50px;"></th>
                        <th scope="col">Group</th>
                        <th scope="col">Permission</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions->groupBy('group') as $permissions_group)
                        @foreach ($permissions_group as $permission)
                            <tr id="r-{{ $permission->id }}">
                                <th class="border-start text-center" style="min-width: 50px; width: 50px;">
                                    <div class="form-check form-switch px-0 me-0" style="width: 0;">
                                        <input wire:click="toggle_permission('{{ $permission->name }}')" class="form-check-input mx-0" type="checkbox" id="check-{{ $permission->id }}"
                                            {{ $role->permissions->where('name', $permission->name)->count()? 'checked': '' }}>
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
            </table>
        </div>
    </div>
</div>
