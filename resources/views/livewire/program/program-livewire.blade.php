<div>
    <x-card.card>
        <x-card.search>
            @can('create', \App\Models\Program::class)
                <x-card.search-right>
                    <a href="{{ route('program.form') }}" type="button" class="btn btn-success">
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

            <x-slot name="bottom">
                {{ $programs->links() }}
            </x-slot>
        </x-table.table>
    </x-card.card>

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