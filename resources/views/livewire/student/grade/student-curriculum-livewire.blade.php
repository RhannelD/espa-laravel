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

    <hr>
    <div class="text-end">
        <a href="{{ route('student.curriculum', [$user_id]) }}" class="btn btn-secondary">
            <i class="bi bi-backspace"></i>
            Back
        </a>
    </div>
    <hr>

    @foreach ($curriculum->courses->groupBy(['year', 'semester']) as $curriculum_courses_by_year)
        @foreach ($curriculum_courses_by_year as $curriculum_courses_by_semester)
            <x-card.card>
                <h4 class="card-title pt-0 pb-0">
                    {{ $curriculum_courses_by_semester->first()->yearString }} > {{$curriculum_courses_by_semester->first()->semesterString }}
                </h4>

                <x-table.table>
                    <thead>
                        <tr>
                            <th scope="col" class="text-center" style="width: 8%; min-width: 40px;">Grade</th>
                            <th scope="col" style="width: 10%; min-width: 100px;">Code</th>
                            <th scope="col" style="width: 40%; min-width: 400px;">Course</th>
                            <th scope="col" class="text-center" style="width: 5%; min-width: 40px;">Unit</th>
                            <th scope="col" class="text-center" style="width: 5%; min-width: 40px;">Lec</th>
                            <th scope="col" class="text-center" style="width: 5%; min-width: 40px;">Lab</th>
                            <th scope="col" class="text-center" style="width: 5%; min-width: 40px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($curriculum_courses_by_semester as $curriculum_course)
                            @foreach ($curriculum_course->course->grades as $grade)
                                @livewire('student.grade.grade-view-livewire', ['grade_id' => $grade->id], key("grade-view-{$grade->id}"))
                            @endforeach
                            @if (!$curriculum_course->course->grades->whereBetween('grade', [1,3])->count())
                                @livewire('student.grade.grade-form-livewire', ['course_id' => $curriculum_course->course_id, 'user_id' => $user_id], key("grade-form-{$curriculum_course->course_id}"))
                            @endif
                        @endforeach
                    </tbody>
                </x-table.table>
            </x-card.card>
        @endforeach
    @endforeach
    

    <script>
        function delete_grade(grade_id) {
            swal({
				title: 'Delete the record?',
				text: 'You will not be able to recover it',
				icon: 'warning',
				buttons: true,
				dangerMode: true,
                buttons: ['Cancel', 'Yes, Delete It'],
            }).then((agree) => {
				if (agree) {
                    @this.delete(grade_id);
				}
            });
        }
    </script>
</div>