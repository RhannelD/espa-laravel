@isset($filters['college_id'])
    <div class="border border-secondary rounded pt-0 pb-1 px-1 mb-2">
        <span class="badge bg-primary">
            {{ $filter_colleges->firstWhere('id', $filters['college_id'])->college }}
        </span>

        @isset($filters['program_id'])
            <span class="badge bg-primary">
                {{ $filter_programs->firstWhere('id', $filters['program_id'])->program }}
            </span>
        @endisset
    </div>
@endisset