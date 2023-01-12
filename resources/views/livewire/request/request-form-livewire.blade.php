<div>
    <x-card.card>
        <form onsubmit="save_item(event)" class="row g-3">
            <div class="col-12">
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea wire:model="request.message" class="form-control" id="message" rows="3"></textarea>
                    @error('request.message') <small class="text-danger"> {{ $message }} </small> @enderror
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('course') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </x-card.card>

    <script>
        function save_item(event) {
            event.preventDefault();
            swal({
                title: "Create Request?",
                text: 'New record will be added',
                icon: 'warning',
                buttons: true,
                dangerMode: false,
                buttons: ['Cancel', 'Create'],
            }).then((agree) => {
                if (agree) {
                    @this.save();
                }
            });
        }
    </script>
</div>