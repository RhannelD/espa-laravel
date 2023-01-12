<div>
    <x-card.card>
        <form onsubmit="save_item(event)" class="row g-3">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea wire:model="request.message" class="form-control" id="message" rows="5"></textarea>
                    @error('request.message') <small class="text-danger"> {{ $message }} </small> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="files" class="form-label">File/s</label>
                    <input wire:model="files" class="form-control" type="file" id="files" name="files" multiple>
                    @error('files.*') <small class="text-danger"> {{ $message }} </small> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Uploaded</label>
                    @forelse ($filesUploaded as $key => $file)
                        <div class="mb-1" id="{{ $file->getFilename() }}">
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $file->getClientOriginalName() }}" readonly>
                                <button wire:click="deleteFile({{ $key }})" class="btn btn-dark" type="button" wire:loading.attr="disabled">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                            @error("files.{$key}") <small class="text-danger"> {{ $message }} </small> @enderror
                        </div>
                    @empty 
                        <div class="form-control" id="none">
                            None
                        </div>
                    @endforelse

                    @error('filesUploaded.*') <small class="text-danger mt-3"> {{ $message }} </small> @enderror
                </div>
            </div>

            <div class="text-end">
                <button onclick="history.back()" type="button" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Submit</button>
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