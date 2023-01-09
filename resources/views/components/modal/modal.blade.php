@props([
    'buttons',
])

<div wire:ignore.self class="modal fade" id="{{ $modalId }}" tabindex="-1">
    <div {{ $attributes->class(['modal-dialog']) }}>
        <form wire:submit.prevent="save" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                {{ $buttons ?? '' }}
            </div>
        </form>
    </div>
</div>