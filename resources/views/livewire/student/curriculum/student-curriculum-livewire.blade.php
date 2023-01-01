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
    
    @include('livewire.curriculum.curriculum-info')

    @foreach ($curriculum->courses as $course)
        <x-card.card>
            <h4 class="card-title pt-0 pb-0">
                {{ $course->yearString }} > {{$course->semesterString }}
            </h4>

            <x-table.table>
                <thead>
                    <tr>
                        <th scope="col" style="width: 10%; min-width: 100px;">Code</th>
                        <th scope="col" style="width: 40%; min-width: 400px;">Course</th>
                        <th scope="col" class="text-center" style="width: 5%; min-width: 40px;">Unit</th>
                        <th scope="col" class="text-center" style="width: 5%; min-width: 40px;">Lec</th>
                        <th scope="col" class="text-center" style="width: 5%; min-width: 40px;">Lab</th>
                        <th scope="col" class="text-center" style="width: 5%; min-width: 180px;">Pre-Requisite/s</th>
                        <th scope="col" class="text-center" style="width: 5%; min-width: 180px;">Co-Requisite/s</th>
                        <th scope="col" class="text-center" style="width: 5%; min-width: 180px;">Requisite Standing</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($curriculum->courses()->where('year', $course->year)->where('semester', $course->semester)->get() as $curriculum_course)
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
                            <td scope="row" class="text-center">
                                {{ $curriculum_course->prerequisite_curriculum_courses->pluck('course.code')->implode(', ') }}
                            </td>
                            <td scope="row" class="text-center">
                                {{ $curriculum_course->corequisite_curriculum_courses->pluck('course.code')->implode(', ') }}
                            </td>
                            <td scope="row">
                                {{ $curriculum_course->requisite_standing }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-table.table>
        </x-card.card>
    @endforeach
</div>
