<div>
    <x-card.card>
        <x-card.search>
            <x-card.search-right>
                @can('isStudent', \App\Models\User::class)
                    <a href="{{ route('request.form') }}" type="button" class="btn btn-success">
                        <i class="bi bi-plus-circle-fill"></i>
                        Create
                    </a>
                @else
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filter">
                        <i class="bi bi-funnel"></i>
                    </button>
                @endcan
            </x-card.search-right>
        </x-card.search>

        @cannot('isStudent', \App\Models\User::class)
            @includeWhen(isset($filter_colleges) && isset($filter_programs), 'livewire.filter.filter')
            @includeWhen(count($filters), 'livewire.filter.filter-list', ['filters' => $filters])
        @endcannot

        <x-table.table>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    @cannot('isStudent', \App\Models\User::class)
                        <th scope="col">SR-Code</th>
                        <th scope="col">Student</th>
                        <th scope="col">College</th>
                        <th scope="col">Program</th>
                    @else
                        <th scope="col">Message</th>
                    @endcannot
                    <th scope="col">Date</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)
                    <tr id="r-{{ $request->id }}">
                        <th scope="row">
                            {{ ( ($loop->index + 1) + ( ($showRow * $page ) - $showRow) ) }}
                        </th>
                        @cannot('isStudent', \App\Models\User::class)
                            <td>
                                {{ $request->user->sr_code }}
                            </td>
                            <td>
                                <a href="{{ route('student.curriculum', ['user' => $request->user_id]) }}">
                                    {{ $request->user->flname }}
                                </a>
                            </td>
                            <td>
                                {{ $request->program->college->abbreviation }}
                            </td>
                            <td>
                                {{ $request->program->abbreviation }}
                            </td>
                        @else
                            <td>
                                {{ $request->message }}
                            </td>
                        @endcannot
                        <td>
                            {{ $request->updated_at->shortRelativeDiffForHumans() }}
                        </td>
                        <td class="text-center py-1">
                            @can('delete', $request)
                                <button onclick="delete_record({{ $request->id }})" type="button" class="btn btn-sm my-0 btn-danger">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <x-slot name="bottom">
                {{ $requests->links() }}
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