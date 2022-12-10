<div>
    <div class="card">
        <div class="card-body pt-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <input wire:model.debounce.2000ms="search" type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="search">
                        <button class="btn btn-primary" type="button" id="search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                @can('createOfficer', \App\Models\User::class)
                    <div class="col-md-6 text-end">
                        <a href="{{ route('officer.form') }}" type="button" class="btn btn-success">
                            <i class="bi bi-plus-circle-fill"></i>
                            Create
                        </a>
                    </div>
                @endcan
            </div>

            <table class="table table-hover">
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
            </table>

            <div>
                {{ $officers->links() }}
            </div>
        </div>
    </div>

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