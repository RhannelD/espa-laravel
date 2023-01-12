<?php

namespace App\Http\Livewire\Request;

use App\Models\Request;
use App\Traits\AlertTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class RequestFormLivewire extends Component
{
    use AuthorizesRequests;
    use AlertTrait;

    public $request;

    protected function rules()
    {
        return [
            'request.message' => "required",
        ];
    }

    public function mount()
    {
        $this->authorize('create', Request::class);
        $this->request = new Request;
    }

    public function render()
    {
        return view('livewire.request.request-form-livewire')->extends('layouts.app', [
            'active_nav' => 'request',
            'title' => 'Request',
            'breadcrumbs' => [
                [
                    'link' => route('request'),
                    'label' => 'Request',
                ], [
                    'label' => 'Create',
                    'active' => true,
                ],
            ],
        ]);
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function save()
    {
        $data = $this->validate();

        $this->store($data);
    }

    protected function store($data)
    {
        if (Gate::denies('create', Request::class)) {
            return;
        }

        $request = Request::create($data['request'] + [
            'user_id' => Auth::id(),
            'program_id' => Auth::user()->student->curriculum->program_id,
        ]);

        if ($request->wasRecentlyCreated) {
            $this->session_flash_alert_info('Success!', 'Request has been successfully added');

            return redirect()->route('request');
        }
    }
}
