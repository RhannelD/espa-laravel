<div>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title pt-4 pb-0">
                {{ $curriculum->program->program }}
                @if (!empty($curriculum->track))
                    > {{ $curriculum->track }}
                @endif
            </h4>
            <div class="row">
                <div>
                    {{ $curriculum->program->college->college }}
                </div>
                <div>
                    {{ $curriculum->references->pluck('reference')->implode(', ') }}
                </div>
                <div>
                    AY: {{ $curriculum->academic_years }}
                </div>
            </div>
        </div>
    </div>
    <hr>
    @foreach ($curriculum->courses as $course)
        <div class="card">
            <div class="card-body">
                <h4 class="card-title pt-4 pb-0">
                    {{ $course->yearString }} > {{$course->semesterString }}
                </h4>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Code</th>
                            <th scope="col">Course</th>
                            <th scope="col" class="text-center">Unit</th>
                            <th scope="col" class="text-center">Lec</th>
                            <th scope="col" class="text-center">Lab</th>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>