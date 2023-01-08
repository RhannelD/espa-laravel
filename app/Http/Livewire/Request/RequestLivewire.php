<?php

namespace App\Http\Livewire\Request;

use App\Models\Request;
use App\Traits\AlertTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class RequestLivewire extends Component
{
    use AuthorizesRequests;
    use AlertTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search, $showRow = 10;

    protected $listeners = [
        'searching' => '$refresh'
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
        return Request::query()
            ->search($this->search, Request::SEARCHFILTERS + ['user' => ['sr_code', 'firstname', 'lastname']])
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
