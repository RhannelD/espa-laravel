<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-3">
            <input wire:model.debounce.2000ms="search" type="text" class="form-control" placeholder="Search"
                aria-label="Search" aria-describedby="search">
            <button wire:click="$emitSelf('searching')" class="btn btn-primary" type="button" id="search">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div>
    {{ $slot }}
</div>