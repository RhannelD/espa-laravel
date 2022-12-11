<div>
    <x-card.card>
        <x-card.search>
            @can('create', \App\Models\Course::class)
                <x-card.search-right>
                    <a href="{{ route('course.form') }}" type="button" class="btn btn-success">
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
                    <th scope="col">Code</th>
                    <th scope="col">Course</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Lecture</th>
                    <th scope="col">Laboratory</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                <tr id="r-{{ $course->id }}">
                    <th scope="row">
                        {{ ( ($loop->index + 1) + ( ($showRow * $page ) - $showRow) ) }}
                    </th>
                    <td>
                        {{ $course->code }}
                    </td>
                    <td>
                        {{ $course->course }}
                    </td>
                    <td>
                        {{ $course->unit }}
                    </td>
                    <td>
                        {{ $course->lecture }}
                    </td>
                    <td>
                        {{ $course->laboratory }}
                    </td>
                    <td class="text-center py-1">
                        @can('update', $course)
                            <a href="{{ route('course.form', [$course->id]) }}"
                                class="btn btn-sm my-0 btn-primary">
                                <i class="bi bi-pen-fill"></i>
                            </a>
                        @endcan
                        @can('delete', $course)
                            <button onclick="delete_record({{ $course->id }})" type="button"
                                class="btn btn-sm my-0 btn-danger">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
    
            <x-slot name="bottom">
                {{ $courses->links() }}
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