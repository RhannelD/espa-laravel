<x-card.card>
    <h4 class="card-title pt-0 pb-0">
        {{ $curriculum->program->program }}
        @if (!empty($curriculum->track))
            > {{ $curriculum->track }}
        @endif
    </h4>
    <div class="row">
        <div>
            {{ $curriculum->program->college->college }}
        </div>
        <div>
            {{ $curriculum->references->pluck('reference')->implode(', ') }}
        </div>
        <div>
            AY: {{ $curriculum->academic_years }}
        </div>
    </div>
</x-card.card>