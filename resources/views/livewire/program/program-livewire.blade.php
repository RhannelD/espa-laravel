<div>
    <div class="card">
        <div class="card-body pt-4">
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
                @can('create', \App\Models\Program::class)
                    <div class="col-md-6 text-end">
                        <a href="{{ route('program.form') }}" type="button" class="btn btn-success">
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
                        <th scope="col">Abbreviation</th>
                        <th scope="col">Program</th>
                        <th scope="col">College</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($programs as $program)
                    <tr id="r-{{ $program->id }}">
                        <th scope="row">
                            {{ ( ($loop->index + 1) + ( ($showRow * $page ) - $showRow) ) }}
                        </th>
                        <td>
                            {{ $program->abbreviation }}
                        </td>
                        <td>
                            {{ $program->program }}
                        </td>
                        <td>
                            {{ $program->college->abbreviation }}
                        </td>
                        <td class="text-center py-1">
                            @can('update', $program)
                                <a href="{{ route('program.form', [$program->id]) }}"
                                    class="btn btn-sm my-0 btn-primary">
                                    <i class="bi bi-pen-fill"></i>
                                </a>
                            @endcan
                            @can('delete', $program)
                                <button onclick="delete_record({{ $program->id }})" type="button"
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
                {{ $programs->links() }}
            </div>
        </div>
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