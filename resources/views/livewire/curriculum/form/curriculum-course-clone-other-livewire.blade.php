<div wire:ignore.self class="modal fade" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="{{ $modal_id }}-label" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-md-down">
        <div class="modal-content h-100">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modal_id }}-label">Clone Other Curriculum's Courses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                                <button onclick="duplicate_other_courses({{ $curriculum->id }})"
                                    class="btn btn-sm my-0 btn-dark">
                                    <i class="bi bi-files"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
    
                <div>
                    {{ $curricula->links() }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

    <script>
        function duplicate_other_courses(id) {
            swal({
				title: 'Duplicate this Curriculum\'s Courses?',
				text: 'This will replace all your progress',
				icon: 'warning',
				buttons: true,
				dangerMode: true,
                buttons: ['Cancel', 'Yes, Duplicate It'],
            }).then((agree) => {
				if (agree) {
                    @this.duplicate(id);
				}
            });
        }
    </script>
</div>