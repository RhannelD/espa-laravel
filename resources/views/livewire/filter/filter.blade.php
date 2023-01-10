<x-modal.modal modal-id="filter" title="Filter">
    <div class="row g-3">
        <div class="col-12">
            <label for="college-filter" class="form-label">College</label>
            <select wire:model="filters.college_id" id="college-filter" class="form-select">
                <option selected value="">Select College</option>
                @foreach ($filter_colleges as $college)
                    <option value="{{ $college->id }}">{{ $college->college }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <label for="program-filter" class="form-label">Program</label>
            <select wire:model="filters.program_id" id="program-filter" class="form-select" {{ empty($filters['college_id'])? 'disabled': '' }}>
                <option selected value="">Select Program</option>
                @foreach ($filter_programs as $program)
                    <option value="{{ $program->id }}">{{ $program->program }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <x-slot name="buttons">
        <button wire:click="clear_filter()" type="button" class="btn btn-dark">
            Clear Filter
        </button>
    </x-slot>
</x-modal.modal>    