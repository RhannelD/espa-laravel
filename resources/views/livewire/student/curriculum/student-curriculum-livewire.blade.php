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
                        <th scope="col" class="text-center" style="width: 5%; min-width: 40px;">Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($curriculum->courses->groupBy(['year', 'semester']) as $curriculum_courses_by_year)
                        @foreach ($curriculum_courses_by_year as $curriculum_courses_by_semester)
                            @foreach ($curriculum_courses_by_semester as $curriculum_course)
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
                                        @foreach ($curriculum_course->course->grades as $grade)
                                            @if (in_array($grade->grade, ['INC', 5]))
                                                <span class="text-danger">{{ $grade->grade }}</span>{{ !$loop->last? ',': '' }}
                                            @else
                                                {{ $grade->grade }}{{ !$loop->last? ',': '' }}
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                </tbody>
            </x-table.table>
        </x-card.card>
    @endforeach
</div>