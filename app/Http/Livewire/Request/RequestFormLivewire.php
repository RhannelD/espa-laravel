<?php

namespace App\Http\Livewire\Request;

use App\Models\Request;
use App\Traits\AlertTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithFileUploads;

class RequestFormLivewire extends Component
{
    use AuthorizesRequests;
    use AlertTrait;
    use WithFileUploads;

    public $request;
    public $files = [];
    public $filesUploaded = [];

    protected $validationAttributes = [
        'files.*' => 'file',
        'filesUploaded.*' => 'file',
    ];

    protected function rules()
    {
        return [
            'request.message' => "required",
            'files.*' => "file|max:2048",
            'filesUploaded.*' => "file|max:2048",
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

    public function updated($property, $value)
    {
        $this->validateOnly($property);
    }

    public function updatedFiles($value)
    {
        $this->resetErrorBag();
        $this->validateOnly('files.*');
        $this->filesUploaded = array_merge($value, $this->filesUploaded);
        $this->files = [];
    }

    public function deleteFile($key)
    {
        $this->resetErrorBag();
        $this->filesUploaded[$key]->delete();
        unset($this->filesUploaded[$key]);
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
            foreach ($data['filesUploaded'] ?? [] as $key => $file) {
                $newfilename = "req-{$request->id}-{$request->user_id}-{$request->created_at->format("Y-m-d\TH-i-s")}-{$key}.{$file->guessExtension()}";
                $request->files()->create([
                    'origname' => $file->getClientOriginalName(),
                    'filename' => $newfilename,
                ]);
                $file->storeAs('', $newfilename, 'files');
            }

            $this->session_flash_alert_info('Success!', 'Request has been successfully added');
            return redirect()->route('request');
        }
    }
}
