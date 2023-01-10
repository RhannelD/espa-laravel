<div>
    <x-card.card>
        <x-card.search>
            <x-card.search-right>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filter">
                    <i class="bi bi-funnel"></i>
                </button>
                <a href="{{ route('student.form') }}" type="button" class="btn btn-success">
                    <i class="bi bi-plus-circle-fill"></i>
                    Create
                </a>
            </x-card.search-right>
        </x-card.search>

        @includeWhen(count($filters), 'livewire.filter.filter-list', ['filters' => $filters])

        <x-table.table>
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
                            @can('viewStudentCurriculum', $student)
                                <a href="{{ $student->has_curriculum? route('student.curriculum', ['user' => $student->id]): route('student.curriculum.form', ['user' => $student->id]) }}" 
                                    class="btn btn-sm my-0 btn-primary">
                                    <i class="bi bi-file-medical"></i>
                                </a>
                            @endcan
                            <button wire:click="$emitTo('student.student-password-livewire', 'edit', {{ $student->id }})" type="button" class="btn btn-sm my-0 btn-dark">
                                <i class="bi bi-key-fill"></i>
                            </button>
                            <button onclick="delete_record({{ $student->id }})" type="button" class="btn btn-sm my-0 btn-danger">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            
            <x-slot name="bottom">
                {{ $students->links() }}
            </x-slot>
        </x-table.table>
    </x-card.card>

    <div id="div-modals">
        @livewire('student.student-password-livewire', key('student-password-livewire'))
    </div>

    @include('livewire.filter.filter')

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