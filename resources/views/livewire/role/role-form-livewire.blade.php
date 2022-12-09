<div wire:ignore.self class="modal fade" id="{{ $modal_id }}" tabindex="-1">
    <div class="modal-dialog">
        <form wire:submit.prevent="save" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ empty($role_id)? 'Create': 'Update'  }} Role
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label for="rolename" class="form-label">Role Name</label>
                        <input wire:model.lazy="role.name" type="text" class="form-control" id="rolename">
                        @error('role.name') <small class="text-danger"> {{ $message }} </small> @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">{{ empty($role_id)? 'Create': 'Update'  }}</button>
            </div>
        </form>
    </div>
</div>