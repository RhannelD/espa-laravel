<?php

namespace App\Http\Livewire\Request;

use App\Models\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class RequestViewLivewire extends Component
{
    use AuthorizesRequests;

    public $request_id;

    public function mount(Request $request)
    {
        $this->authorize('view', $request);
        $this->request_id = $request->id;
    }

    public function render()
    {
        return view('livewire.request.request-view-livewire', [
            'request' => $this->getRequest(),
        ])->extends('layouts.app', [
            'active_nav' => 'request',
            'title' => 'Request View',
            'breadcrumbs' => [
                [
                    'link' => route('request'),
                    'label' => 'Request',
                ], [
                    'link' => route('request.view', ['request' => $this->request_id]),
                    'label' => 'Request',
                ], [
                    'label' => 'View',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getRequest()
    {
        return Request::find($this->request_id);
    }
}
