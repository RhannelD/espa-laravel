<div>
    <div class="row">
        <div class="col-md-5">
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
        </div>
        <div class="col-md-7">
            @include('livewire.curriculum.curriculum-info', ['curriculum'=>$user->curriculum])
        </div>
    </div>

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-evaluation-tab" data-bs-toggle="tab" data-bs-target="#nav-evaluation" type="button" role="tab" aria-controls="nav-evaluation" aria-selected="true">
                Evaluation
            </button>
            <button class="nav-link" id="nav-courses-tab" data-bs-toggle="tab" data-bs-target="#nav-courses" type="button" role="tab" aria-controls="nav-courses" aria-selected="false">
                Courses
            </button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-evaluation" role="tabpanel" aria-labelledby="nav-evaluation-tab">
            <x-card.card class="rounded-0 rounded-bottom">
                <h4 class="card-title pt-0 pb-0">
                    Student Evaluation
                </h4>
                <div class="row">
                    <div class="col-lg-3 order-lg-last">
                        <div class="input-group">
                            <div class="btn btn-dark">Unit/s:</div>
                            <div class="form-control">18</div>
                            <div class="btn btn-secondary">/21</div>
                        </div>
                        <hr>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="button"><i class="bi bi-plus-circle-fill"></i> Add Courses</button>
                            <button class="btn btn-primary" type="button"><i class="bi bi-bar-chart-steps"></i> Auto Load Courses</button>
                            <button onclick="remove_courses()" class="btn btn-danger" type="button">
                                <i class="bi bi-x-circle-fill"></i> 
                                Remove Courses
                            </button>
                        </div>
                        <hr>
                        <div class="d-grid gap-2">
                            <button class="btn btn-success" type="button"><i class="bi bi-file-earmark-pdf-fill"></i> Print</button>
                            <button class="btn btn-success" type="button"><i class="bi bi-send-fill"></i> Send</button>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <x-table.table class="table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center" style="width: 2%;">#</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Course</th>
                                    <th scope="col" class="text-center">Units</th>
                                    <th scope="col" class="text-center">Lec</th>
                                    <th scope="col" class="text-center">Lab</th>
                                    <th scope="col" class="text-center" style="width: 2%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($selected_courses as $selected_course)
                                    <tr id="row-sc-{{ $selected_course->id }}">
                                        <td class="text-center">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $selected_course->code }}
                                        </td>
                                        <td>
                                            {{ $selected_course->course }}
                                        </td>
                                        <td class="text-center">
                                            {{ $selected_course->unit }}
                                        </td>
                                        <td class="text-center">
                                            {{ $selected_course->lecture }}
                                        </td>
                                        <td class="text-center">
                                            {{ $selected_course->laboratory }}
                                        </td>
                                        <td class="text-center py-0">
                                            <button wire:click="removeCourse({{ $selected_course->id }})" type="button" class="btn btn-danger btn-sm">
                                                <i class="bi bi-dash-circle-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="row-sc-none">
                                       <td colspan="7" class="text-white">
                                            -
                                        </td> 
                                    </tr>
                                @endforelse
                            </tbody>
                            @if ($selected_courses->count())
                                <tfoot>
                                    <tr class="fw-bold bg-light" id="row-sc-total">
                                        <td colspan="3" class="text-end">
                                            Total: 
                                        </td>
                                        <td class="text-center">
                                            {{ $selected_courses->sum('unit') }}
                                        </td>
                                        <td class="text-center">
                                            {{ $selected_courses->sum('lecture') }}
                                        </td>
                                        <td class="text-center">
                                            {{ $selected_courses->sum('laboratory') }}
                                        </td>
                                        <td class="text-center"></td>
                                    </tr>
                                </tfoot>
                            @endif
                        </x-table.table>
                    </div>
                </div>
            </x-card.card>
        </div>
        <div class="tab-pane fade" id="nav-courses" role="tabpanel" aria-labelledby="nav-courses-tab">
            <x-card.card class="rounded-0 rounded-bottom">
            </x-card.card>
        </div>
    </div>

    <script>
        function remove_courses() {
            swal({
				title: 'Remove all Courses?',
				text: '',
				icon: 'warning',
				buttons: true,
				dangerMode: true,
                buttons: ['Cancel', 'Yes, Remove All'],
            }).then((agree) => {
				if (agree) {
                    @this.removeCourses();
				}
            });
        }
    </script>
</div>
