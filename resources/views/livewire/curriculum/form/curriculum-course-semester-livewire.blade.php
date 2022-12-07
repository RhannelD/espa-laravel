<div class="card">
    <div class="card-body overflow-auto ">
        <h4 class="card-title pt-4 pb-0">
            <div class="d-flex">
                <div class="flex-grow-1 pe-1">
                    <div class="w-100 btn btn-light text-start text-dark fw-semibold">
                        {{ \App\Models\CurriculumCourse::getYearString($year) }} > {{ \App\Models\CurriculumCourse::getSemesterString($semester) }}
                    </div>
                </div>
                <button wire:click="$emitTo('curriculum.form.curriculum-course-add-modal-livewire', 'open_selection', {{ $year }}, {{ $semester }})" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i>
                    Course
                </button>
            </div>
        </h4>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" style="width: 10%; min-width: 100px;">Code</th>
                    <th scope="col" style="width: 40%; min-width: 400px;">Course</th>
                    <th scope="col" class="text-center" style="width: 5%; min-width: 40px;">Unit</th>
                    <th scope="col" class="text-center" style="width: 5%; min-width: 40px;">Lec</th>
                    <th scope="col" class="text-center" style="width: 5%; min-width: 40px;">Lab</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($curriculum_courses as $curriculum_course)
                    <tr id="r-{{ $curriculum_course->id }}">
                        <td scope="row">
                            {{ $curriculum_course->course->code }}
                        </td>
                        <td scope="row">
                            {{ $curriculum_course->course->course }}
                        </td>
                        <td scope="row" class="text-center">
                            {{ $curriculum_course->course->unit }}
                        </td>
                        <td scope="row" class="text-center">
                            {{ $curriculum_course->course->lecture }}
                        </td>
                        <td scope="row" class="text-center">
                            {{ $curriculum_course->course->laboratory }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>