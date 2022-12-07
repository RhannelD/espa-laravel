<div class="card">
    <div class="card-body">
        <h4 class="card-title pt-4 pb-0">
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
    </div>
</div>