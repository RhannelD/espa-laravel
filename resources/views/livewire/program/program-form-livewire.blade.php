<div>
    <x-card.card>
        <form onsubmit="save_item(event)" class="row g-3">
            <div class="col-12">
                <div class="form-floating">
                    <select wire:model.lazy="program.college_id" class="form-select" id="college_id" aria-label="College">
                        <option value="">Select College</option>
                        @foreach ($colleges as $college)
                            <option value="{{ $college->id }}">{{ $college->college }}</option>
                        @endforeach
                    </select>
                    <label for="college_id">College</label>
                    @error('program.college_id') <small class="text-danger"> {{ $message }} </small> @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input wire:model.lazy="program.program" type="text" class="form-control" id="program" placeholder="Program">
                    <label for="program">Program</label>
                    @error('program.program') <small class="text-danger"> {{ $message }} </small> @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input wire:model.lazy="program.abbreviation" type="text" class="form-control" id="abbreviation" placeholder="Abbreviation">
                    <label for="abbreviation">Abbreviation</label>
                    @error('program.abbreviation') <small class="text-danger"> {{ $message }} </small> @enderror
                </div>
            </div>
            <div class="text-end">
                <a href="{{ route('program') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </x-card.card>

    <script>
        function save_item(event) {
            event.preventDefault();
            swal({
                title: @this.program_id? 'Update the record?': 'Add a record?',
                text: @this.program_id? 'Your record will be modified': 'New record will be added',
                icon: 'warning',
                buttons: true,
                dangerMode: false,
                buttons: ['Cancel', @this.program_id? 'Yes, Update It': 'Yes, Add It'],
            }).then((agree) => {
                if (agree) {
                    @this.save();
                }
            });
        }
    </script>
</div>