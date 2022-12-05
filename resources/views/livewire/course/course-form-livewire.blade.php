<div>
    <div class="card">
        <div class="card-body pt-4">
            <form onsubmit="save_item(event)" class="row g-3">
                <div class="col-md-3">
                    <div class="form-floating">
                        <input wire:model.lazy="course.code" type="text" class="form-control" id="code" placeholder="Code">
                        <label for="code">Code</label>
                        @error('course.code') <small class="text-danger"> {{ $message }} </small> @enderror
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-floating">
                        <input wire:model.lazy="course.course" type="text" class="form-control" id="course" placeholder="Course">
                        <label for="course">Course</label>
                        @error('course.course') <small class="text-danger"> {{ $message }} </small> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input wire:model.lazy="course.unit" type="number" class="form-control" id="unit" placeholder="Unit">
                        <label for="unit">Unit</label>
                        @error('course.unit') <small class="text-danger"> {{ $message }} </small> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input wire:model.lazy="course.lecture" type="number" class="form-control" id="lecture" placeholder="Lecture">
                        <label for="lecture">Lecture</label>
                        @error('course.lecture') <small class="text-danger"> {{ $message }} </small> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input wire:model.lazy="course.laboratory" type="number" class="form-control" id="laboratory" placeholder="Laboratory">
                        <label for="laboratory">Laboratory</label>
                        @error('course.laboratory') <small class="text-danger"> {{ $message }} </small> @enderror
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ route('course') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function save_item(event) {
            event.preventDefault();
            swal({
                title: @this.course_id? 'Update the record?': 'Add a record?',
                text: @this.course_id? 'Your record will be modified': 'New record will be added',
                icon: 'warning',
                buttons: true,
                dangerMode: false,
                buttons: ['Cancel', @this.course_id? 'Yes, Update It': 'Yes, Add It'],
            }).then((agree) => {
                if (agree) {
                    @this.save();
                }
            });
        }
    </script>
</div>