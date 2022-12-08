<div>
    @include('livewire.curriculum.curriculum-info')
    <div wire:ignore>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>
            This is a auto saved form. Think before you click
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <hr>
    <div class="text-end">
        <a href="{{ route('curriculum.course', ['curriculum'=>$curriculum_id]) }}" class="btn btn-secondary">
            <i class="bi bi-backspace"></i>
            Back
        </a>
        <button wire:click="$emitTo('curriculum.form.curriculum-course-clone-other-livewire', 'open_other_clone_selection')" class="btn btn-dark">
            <i class="bi bi-files"></i>
            Clone Other
        </button>
        <button onclick="empty_curriculum()" class="btn btn-danger">
            <i class="bi bi-file-x"></i>
            Empty Curriculum
        </button>
    </div>
    <hr>
    <div wire:key="curriculum_semester">
        @foreach (\App\Models\CurriculumCourse::NUMBERTOSTRINGORDINALS as $year => $value)
            @for ($semester = 1; $semester <= 3; $semester++)
                @livewire('curriculum.form.curriculum-course-semester-livewire', [
                    'curriculum_id' => $curriculum_id,
                    'year' => $year,
                    'semester' => $semester,
                ], key("semester_course-{$curriculum_id}_{$year}_{$semester}"))
            @endfor
        @endforeach
    </div>

    @livewire('curriculum.form.curriculum-course-add-modal-livewire', ['curriculum_id' => $curriculum_id], key('curriculum-course-add-modal-livewire'))
    @livewire('curriculum.form.curriculum-course-clone-other-livewire', ['curriculum_id' => $curriculum_id], key('curriculum.form.curriculum-course-clone-other-livewire'))

    <script>
        function empty_curriculum() {
            swal({
				title: 'Empty this curriculum\'s courses?',
				text: 'You will not be able to recover it',
				icon: 'warning',
				buttons: true,
				dangerMode: true,
                buttons: ['Cancel', 'Yes, Delete It'],
            }).then((agree) => {
				if (agree) {
                    @this.emptyCurriculum();
				}
            });
        }
    </script>
</div>