<div>
    <x-card.card>
        <x-card.search>
            @can('createOfficer', \App\Models\User::class)
                <x-card.search-right>
                    <a href="{{ route('officer.form') }}" type="button" class="btn btn-success">
                        <i class="bi bi-plus-circle-fill"></i>
                        Create
                    </a>
                </x-card.search-right>
            @endcan
        </x-card.search>

        <x-table.table>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Sex</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($officers as $officer)
                    <tr id="r-{{ $officer->id }}">
                        <th scope="row">
                            {{ ( ($loop->index + 1) + ( ($showRow * $page ) - $showRow) ) }}
                        </th>
                        <td>
                            {{ $officer->flname }}
                        </td>
                        <td>
                            {{ $officer->email }}
                        </td>
                        <td>
                            {{ $officer->roles->implode('name', ', ') }}
                        </td>
                        <td class="text-capitalize">
                            {{ $officer->sex }}
                        </td>
                        <td class="text-center py-1">
                            @can('update', $officer)
                                <a href="{{ route('officer.form', [$officer->id]) }}" class="btn btn-sm my-0 btn-primary">
                                    <i class="bi bi-pen-fill"></i>
                                </a>
                            @endcan
                            @can('updateOfficerRoleAccess', $officer)
                                <a href="{{ route('officer.role.permission', [$officer->id]) }}" class="btn btn-sm my-0 btn-primary">
                                    <i class="bi bi-code"></i>
                                </a>
                            @endcan
                            @can('updateOfficerPassword', $officer)
                                <button wire:click="$emitTo('officer.officer-password-livewire', 'edit', {{ $officer->id }})" type="button" class="btn btn-sm my-0 btn-dark">
                                    <i class="bi bi-key-fill"></i>
                                </button>
                            @endcan
                            @can('deleteOfficer', $officer)
                                <button onclick="delete_record({{ $officer->id }})" type="button" class="btn btn-sm my-0 btn-danger">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <x-slot name="bottom">
                {{ $officers->links() }}
            </x-slot>
        </x-table.table>
    </x-card.card>

    <div id="div-modals">
        @livewire('officer.officer-password-livewire', key('officer-password-livewire'))
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