<div wire:ignore.self class="modal fade" id="duplicate-modal" tabindex="-1" aria-labelledby="duplicate-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" wire:submit.prevent='duplicateCurriculum'>
            <div class="modal-header">
                <h5 class="modal-title" id="duplicate-modal-label">Duplicate Curriculum</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="form-floating">
                        <input x-mask="9999" wire:model.lazy="academic_year" type="numeric" class="form-control" id="academic_year" placeholder="Academic Year">
                        <label for="academic_year">Academic Year</label>
                        @error('academic_year') <small class="text-danger"> {{ $message }} </small> @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Duplicate</button>
            </div>
        </form>
    </div>
</div>