<div>
    <x-card.card>
        <h4 class="card-title pt-0 pb-0">
            {{ $user->flname }}
        </h4>
        <div class="row">
            <div>
                {{ $user->sr_code }}
            </div>
            <div>
                {{ $user->email }}
            </div>
            <div class="text-capitalize">
                {{ $user->sex }}
            </div>
        </div>
    </x-card.card>

    @includeWhen($user->curriculum,'livewire.curriculum.curriculum-info', ['curriculum' => $user->curriculum])

    <hr>
    <x-card.card>
        <x-card.search/>

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
                        <td onclick="swal({
                                title: 'Set Curriculum',
                                text: '',
                                icon: 'warning',
                                buttons: true,
                                dangerMode: false,
                                buttons: ['Cancel', 'Save'],
                            }).then((agree) => {
                                if (agree) {
                                    @this.save({{ $curriculum->id }});
                                }
                            })" 
                            class="text-center py-1">
                            <button class="btn btn-sm my-0 btn-primary">
                                <i class="bi bi-check2-circle"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <x-slot name="bottom">
                {{ $curricula->links() }}
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