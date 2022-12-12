<x-card.card>
    <x-card.search>
    </x-card.search>

    <x-table.table>
        <thead>
            <tr>
                <th scope="col" style="width: 10%">#</th>
                <th scope="col" style="width: 30%">Permission Group</th>
                <th scope="col" style="width: 60%">Permission Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
            <tr id="r-{{ $permission->id }}">
                <th scope="row">
                    {{ ( ($loop->index + 1) + ( ($showRow * $page ) - $showRow) ) }}
                </th>
                <td>
                    {{ $permission->group }}
                </td>
                <td>
                    {{ $permission->name }}
                </td>
            </tr>
            @endforeach
        </tbody>

        <x-slot name="bottom">
            {{ $permissions->links() }}
        </x-slot>
    </x-table.table>
</x-card.card>