<div>
    <x-card.card>
        <x-card.search>
            @can('create', \App\Models\Curriculum::class)
                <x-card.search-right>
                    <a href="{{ route('curriculum.form') }}" type="button" class="btn btn-success">
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
                    <th scope="col">College</th>
                    <th scope="col">Program</th>
                    <th scope="col">Curriculum</th>
                    <th scope="col" class="text-center">Academic Year</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($curricula as $curriculum)
                <tr id="r-{{ $curriculum->id }}">
                    <th scope="row">
                        {{ ( ($loop->index + 1) + ( ($showRow * $page ) - $showRow) ) }}
                    </th>
                    <td>
                        {{ $curriculum->program->college->abbreviation }}
                    </td>
                    <td>
                        {{ $curriculum->program->abbreviation }}
                    </td>
                    <td>
                        {{ $curriculum->track }}
                    </td>
                    <td class="text-center">
                        {{ $curriculum->academic_year }}
                    </td>
                    <td class="text-center py-1">
                        @can('update', $curriculum)
                            <a href="{{ route('curriculum.form', [$curriculum->id]) }}"
                                class="btn btn-sm my-0 btn-primary">
                                <i class="bi bi-pen-fill"></i>
                            </a>
                        @endcan
                        @can('view', $curriculum)
                            <a href="{{ route('curriculum.course', [$curriculum->id]) }}"
                                class="btn btn-sm my-0 btn-primary">
                                <i class="bi bi-file-medical"></i>
                            </a>
                        @endcan
                        @can('duplicate', $curriculum)
                            <a wire:click="$emit('duplicate', {{ $curriculum->id }})"
                                class="btn btn-sm my-0 btn-dark">
                                <i class="bi bi-files"></i>
                            </a>
                        @endcan
                        @can('delete', $curriculum)
                            <button onclick="delete_record({{ $curriculum->id }})" type="button"
                                class="btn btn-sm my-0 btn-danger">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>

            <x-slot name="bottom">
                {{ $curricula->links() }}
            </x-slot>
        </x-table.table>
    </x-card.card>

    <div id="div-modals">
        @livewire('curriculum.curriculum-duplicate-livewire', key('curriculum-duplicate-livewire'))
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