<div>
    <x-card.card>
        <form onsubmit="save_item(event)" class="row g-3">
            <div class="col-12">
                <div class="form-floating">
                    <input wire:model.lazy="college.college" type="text" class="form-control" id="college" placeholder="College">
                    <label for="college">College</label>
                    @error('college.college') <small class="text-danger"> {{ $message }} </small> @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input wire:model.lazy="college.abbreviation" type="text" class="form-control" id="abbreviation" placeholder="Abbreviation">
                    <label for="abbreviation">Abbreviation</label>
                    @error('college.abbreviation') <small class="text-danger"> {{ $message }} </small> @enderror
                </div>
            </div>
            <div class="text-end">
                <a href="{{ route('college') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </x-card.card>

    <script>
        function save_item(event) {
            event.preventDefault();
            swal({
                title: @this.college_id? 'Update the record?': 'Add a record?',
                text: @this.college_id? 'Your record will be modified': 'New record will be added',
                icon: 'warning',
                buttons: true,
                dangerMode: false,
                buttons: ['Cancel', @this.college_id? 'Yes, Update It': 'Yes, Add It'],
            }).then((agree) => {
                if (agree) {
                    @this.save();
                }
            });
        }
    </script>
</div>