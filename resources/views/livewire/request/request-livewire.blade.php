<div>
    <x-card.card>
        <x-card.search>
            <x-card.search-right>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filter">
                    <i class="bi bi-funnel"></i>
                </button>
            </x-card.search-right>
        </x-card.search>

        <x-table.table>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">SR-Code</th>
                    <th scope="col">Student</th>
                    <th scope="col">College</th>
                    <th scope="col">Program</th>
                    <th scope="col">Message</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)
                    <tr id="r-{{ $request->id }}">
                        <th scope="row">
                            {{ ( ($loop->index + 1) + ( ($showRow * $page ) - $showRow) ) }}
                        </th>
                        <td>
                            {{ $request->user->sr_code }}
                        </td>
                        <td>
                            {{ $request->user->flname }}
                        </td>
                        <td>
                            {{ $request->program->college->abbreviation }}
                        </td>
                        <td>
                            {{ $request->program->abbreviation }}
                        </td>
                        <td>
                            {{ $request->message }}
                        </td>
                        <td class="text-center py-1">
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <x-slot name="bottom">
                {{ $requests->links() }}
            </x-slot>
        </x-table.table>
    </x-card.card>

    @include('livewire.filter.filter')
</div>