<?php

namespace App\Http\Livewire\Request;

use App\Models\Request;
use App\Traits\AlertTrait;
use App\Traits\FilterTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class RequestLivewire extends Component
{
    use AuthorizesRequests;
    use AlertTrait;
    use FilterTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search, $showRow = 10;

    protected $listeners = [
        'searching' => '$refresh',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'showRow' => ['except' => 10, 'as' => 'row'],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->authorize('viewAny', Request::class);
    }

    public function hydrate()
    {
        if (Gate::denies('viewAny', Request::class)) {
            return redirect(url()->previous());
        }
    }

    public function render()
    {
        return view('livewire.request.request-livewire', [
            'requests' => $this->getRequests(),
            'filter_colleges' => $this->getFilterColleges(),
            'filter_programs' => $this->getFilterPrograms(),
        ])->extends('layouts.app', [
            'active_nav' => 'request',
            'title' => 'Request',
            'breadcrumbs' => [
                [
                    'link' => route('request'),
                    'label' => 'Request',
                ], [
                    'label' => 'List',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getRequests()
    {
        $filters = $this->filters;

        return Request::query()
            ->search($this->search, Request::SEARCHFILTERS + [
                'user' => ['sr_code', 'firstname', 'lastname'],
                'program' => ['abbreviation', 'college' => ['abbreviation']],
            ])
            ->when(!empty($filters['program_id']), function ($query) use ($filters) {
                $query->where('program_id', $filters['program_id']);
            }, function ($query) use ($filters) {
                $query->when(!empty($filters['college_id']), function ($query) use ($filters) {
                    $query->whereHas('program', function ($query) use ($filters) {
                        $query->where('college_id', $filters['college_id']);
                    });
                });
            })
            ->paginate($this->showRow);
    }

    public function delete($id)
    {
        $request = Request::find($id);
        if (Gate::allows('delete', $request) && $request->delete()) {
            $this->alert_success('Record Deleted!');
        }
    }
}
