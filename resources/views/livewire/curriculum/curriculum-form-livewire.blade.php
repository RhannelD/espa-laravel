<div>
    <div class="card">
        <div class="card-body pt-4">
            <form onsubmit="save_item(event)" class="row g-3">
                <div class="col-12">
                    <div class="form-floating">
                        <select wire:model.lazy="college_id" class="form-select" id="college_id" aria-label="College">
                            <option value="">Select College</option>
                            @foreach ($colleges as $college)
                                <option value="{{ $college->id }}">{{ $college->college }}</option>
                            @endforeach
                        </select>
                        <label for="college_id">College</label>
                        @error('college_id') <small class="text-danger"> {{ $message }} </small> @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <select wire:model.lazy="curriculum.program_id" class="form-select" id="program_id" aria-label="Program" {{ empty($college_id)? 'disabled': '' }}>
                            <option value="">Select Program</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->program }}</option>
                            @endforeach
                        </select>
                        <label for="program_id">Program</label>
                        @error('curriculum.program_id') <small class="text-danger"> {{ $message }} </small> @enderror
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-floating">
                        <input wire:model.lazy="curriculum.track" type="text" class="form-control" id="track" placeholder="Track">
                        <label for="curriculum">Track</label>
                        @error('curriculum.track') <small class="text-danger"> {{ $message }} </small> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input x-mask="9999" wire:model.lazy="curriculum.academic_year" type="text" class="form-control" id="academic_year" placeholder="Academic Year">
                        <label for="academic_year">Academic Year</label>
                        @error('curriculum.academic_year') <small class="text-danger"> {{ $message }} </small> @enderror
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ route('curriculum') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function save_item(event) {
            event.preventDefault();
            swal({
                title: @this.curriculum_id? 'Update the record?': 'Add a record?',
                text: @this.curriculum_id? 'Your record will be modified': 'New record will be added',
                icon: 'warning',
                buttons: true,
                dangerMode: false,
                buttons: ['Cancel', @this.curriculum_id? 'Yes, Update It': 'Yes, Add It'],
            }).then((agree) => {
                if (agree) {
                    @this.save();
                }
            });
        }
    </script>
</div>