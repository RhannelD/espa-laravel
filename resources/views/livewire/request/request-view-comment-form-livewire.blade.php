<div class="mb-3">
    <form wire:submit.prevent="comment()" class="input-group">
        <input wire:model.defer="comment.comment" type="text" class="form-control rounded me-1" placeholder="Comment" aria-describedby="comment-button">
        <button wire:loading.attr="disabled" class="btn btn-primary rounded" type="submit" id="comment-button">
            <i class="bi bi-send-fill"></i>
        </button>
    </form>
    @error('comment.comment') <small class="text-danger"> {{ $message }} </small> @enderror
</div>