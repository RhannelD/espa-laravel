<div>
    <x-card.card>
        <form onsubmit="save_item(event)" class="row g-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <input wire:model.lazy="user.firstname" type="text" class="form-control" id="firstname" placeholder="First Name">
                    <label for="firstname">First Name</label>
                    @error('user.firstname') <small class="text-danger"> {{ $message }} </small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <input wire:model.lazy="user.lastname" type="text" class="form-control" id="lastname" placeholder="Last Name">
                    <label for="lastname">Last Name</label>
                    @error('user.lastname') <small class="text-danger"> {{ $message }} </small> @enderror
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-floating">
                    <input wire:model.lazy="user.email" type="email" class="form-control" id="email" placeholder="Email">
                    <label for="email">Email</label>
                    @error('user.email') <small class="text-danger"> {{ $message }} </small> @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <select wire:model.lazy="user.sex" class="form-select" id="sex" aria-label="Sex">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <label for="sex">Sex</label>
                    @error('user.sex') <small class="text-danger"> {{ $message }} </small> @enderror
                </div>
            </div>
            <div class="text-end">
                <a href="{{ route('officer') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </x-card.card>

    <script>
        function save_item(event) {
            event.preventDefault();
            swal({
                title: @this.user_id? 'Update the record?': 'Add a record?',
                text: @this.user_id? 'Your record will be modified': 'New record will be added',
                icon: 'warning',
                buttons: true,
                dangerMode: false,
                buttons: ['Cancel', @this.user_id? 'Yes, Update It': 'Yes, Add It'],
            }).then((agree) => {
                if (agree) {
                    @this.save();
                }
            });
        }
    </script>
</div>