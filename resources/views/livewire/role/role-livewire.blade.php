<div>
    <div class="card">
        <div class="card-body pt-4 overflow-auto">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <input wire:model.debounce.2000ms="search" type="text" class="form-control" placeholder="Search"
                            aria-label="Search" aria-describedby="search">
                        <button class="btn btn-primary" type="button" id="search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                @can('create', \Spatie\Permission\Models\Role::class)
                    <div class="col-md-6 text-end">
                        <button wire:click="$emit('create')" type="button" class="btn btn-success">
                            <i class="bi bi-plus-circle-fill"></i>
                            Create
                        </button>
                    </div>
                @endcan
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col" style="width: 10%; min-width: 19px;">#</th>
                        <th scope="col" style="width: 30%; min-width: 150px;">Role Name</th>
                        <th scope="col" style="width: 60%; min-width: 400px;">Permissions</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr id="r-{{ $role->id }}">
                        <th scope="row">
                            {{ ( ($loop->index + 1) + ( ($showRow * $page ) - $showRow) ) }}
                        </th>
                        <td>
                            {{ $role->name }}
                        </td>
                        <td>
                            @if ($role->name == 'Super Admin')
                                All Permission
                            @else
                                {{ $role->permissions()->limit(3)->get()->implode('name', ', ') }}{{ ($role->permissions_count>3)? ', ...': '' }}
                            @endif
                        </td>
                        <td class="text-center py-1 text-nowrap">
                            @can('update', $role)
                                <a wire:click="$emit('edit', {{ $role->id }})" 
                                    class="btn btn-sm my-0 btn-primary">
                                    <i class="bi bi-pen-fill"></i>
                                </a>
                            @endcan
                            @can('update', $role)
                                <a href="{{ route('role.permission', ['role'=>$role->id]) }}" 
                                    class="btn btn-sm my-0 btn-primary">
                                    <i class="bi bi-key-fill"></i>
                                </a>
                            @endcan
                            @can('delete', $role)
                                <button onclick="delete_record({{ $role->id }})" type="button"
                                    class="btn btn-sm my-0 btn-danger">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div>
                {{ $roles->links() }}
            </div>
        </div>
    </div>

    <div id="div-modals">
        @livewire('role.role-form-livewire', key('role-form-livewire'))
    </div>

    <script>
        function delete_record(id) {
            swal({
				title: 'Delete the record?',
				text: 'You will not be able to recover it',
				icon: 'warning',
				buttons: true,
				dangerMode: true,
                buttons: ['Cancel', 'Yes, Delete It'],
            }).then((agree) => {
				if (agree) {
                    @this.delete(id);
				}
            });
        }
    </script>
</div>