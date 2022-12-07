<div wire:ignore.self class="modal fade" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="{{ $modal_id }}-label" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-md-down">
        <div class="modal-content h-100">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modal_id }}-label">Course Selection</h5>
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
                    <div class="col-md-6 pb-3">
                        @if (session()->has('successful'))
                            <div class="w-100 h-100 bg-success-light rounded px-3 pt-2 pb-2">
                                {{ session('successful') }}
                            </div>
                        @endif
                    </div>
                </div>

                <table class="table table-hover">
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
                                <button wire:click="addCourse({{ $course->id }})" class="btn btn-sm my-0 btn-primary">
                                    <i class="bi bi-plus-circle"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
    
                <div>
                    {{ $courses->links() }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>