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
                <div class="col-md-6 text-end">
                    <a href="{{ route('student.form') }}" type="button" class="btn btn-success">
                        <i class="bi bi-plus-circle-fill"></i>
                        Create
                    </a>
                </div>
            </div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">SR-Code</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Sex</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr id="r-{{ $student->id }}">
                            <th scope="row">
                                {{ ( ($loop->index + 1) + ( ($showRow * $page ) - $showRow) ) }}
                            </th>
                            <td>
                                {{ $student->sr_code }}
                            </td>
                            <td>
                                {{ $student->flname }}
                            </td>
                            <td>
                                {{ $student->email }}
                            </td>
                            <td class="text-capitalize">
                                {{ $student->sex }}
                            </td>
                            <td class="text-center py-1">
                                <a href="{{ route('student.form', [$student->id]) }}" class="btn btn-sm my-0 btn-primary">
                                    <i class="bi bi-pen-fill"></i>
                                </a>
                                <button onclick="delete_record({{ $student->id }})" type="button" class="btn btn-sm my-0 btn-danger">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div>
                {{ $students->links() }}
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