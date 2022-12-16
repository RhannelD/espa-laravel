<x-card.card class="card">
    <h4 class="card-title pt-0 pb-0">
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

    <x-table.table>
        <thead>
            <tr>
                <th scope="col" style="width: 10%; min-width: 100px;">Code</th>
                <th scope="col" style="width: 40%; min-width: 400px;">Course</th>
                <th scope="col" class="text-center" style="width: 5%; min-width: 40px;">Unit</th>
                <th scope="col" class="text-center" style="width: 5%; min-width: 40px;">Lec</th>
                <th scope="col" class="text-center" style="width: 5%; min-width: 40px;">Lab</th>
                <th scope="col" class="text-center" style="width: 5%; min-width: 180px;">Requisite Standing</th>
                <th scope="col" class="text-center" style="width: 5%; min-width: 40px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($curriculum_courses as $curriculum_course)
                @livewire('curriculum.form.curriculum-course-semester-course-livewire', ['curriculum_course' => $curriculum_course->id], key("curriculum-course-semester-course-livewire-{$curriculum_course->id}"))
            @endforeach
        </tbody>
    </x-table.table>
</x-card.card>