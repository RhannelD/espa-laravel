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
            </div>

            <table class="table table-hover">
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
            </table>

            <div>
                {{ $permissions->links() }}
            </div>
        </div>
    </div>
</div>