<?php

namespace App\Http\Livewire\Program;

use App\Models\Program;
use Livewire\Component;
use App\Traits\AlertTrait;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProgramLivewire extends Component
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
        $this->authorize('viewAny', Program::class);
    }

    public function hydrate()
    {
        if (Gate::denies('viewAny', Program::class)) {
            return redirect(url()->previous());
        }
    }

    public function render()
    {
        return view('livewire.program.program-livewire', [
            'programs' => $this->getPrograms(),
        ])->extends('layouts.app', [
            'active_nav' => 'program',
            'title' => 'Program',
            'breadcrumbs' => [
                [
                    'link' => route('program'),
                    'label' => 'Program',
                ], [
                    'label' => 'List',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getPrograms()
    {
        return Program::query()
            ->with('college')
            ->search($this->search)
            ->paginate($this->showRow);
    }

    public function delete($id)
    {
        $program = Program::find($id);
        if (Gate::allows('delete', $program) && $program->delete()) {
            $this->alert_success('Record Deleted!');
        }
    }
}
