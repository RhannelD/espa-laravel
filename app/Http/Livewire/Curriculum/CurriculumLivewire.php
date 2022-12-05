<?php

namespace App\Http\Livewire\Curriculum;

use App\Models\Curriculum;
use App\Traits\AlertTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class CurriculumLivewire extends Component
{
    use AuthorizesRequests;
    use AlertTrait;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search, $showRow = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'showRow' => ['except' => 10, 'as' => 'row'],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->authorize('viewAny', Curriculum::class);
    }

    public function hydrate()
    {
        if (Gate::denies('viewAny', Curriculum::class)) {
            return redirect(url()->previous());
        }
    }

    public function render()
    {
        return view('livewire.curriculum.curriculum-livewire', [
            'curricula' => $this->getCurricula(),
        ])->extends('layouts.app', [
            'active_nav' => 'curriculum',
            'title' => 'Curriculum',
            'breadcrumbs' => [
                [
                    'link' => route('curriculum'),
                    'label' => 'Curriculum',
                ], [
                    'label' => 'List',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getCurricula()
    {
        return Curriculum::query()
            ->with([
                'program' => function ($query) {
                    $query->with('college');
                },
            ])
            ->search($this->search, Curriculum::SEARCHFILTERS + ['program' => ['abbreviation', 'college' => ['abbreviation']]])
            ->paginate($this->showRow);
    }

    public function delete($id)
    {
        $curriculum = Curriculum::find($id);
        if (Gate::allows('delete', $curriculum) && $curriculum->delete()) {
            $this->alert_success('Record Deleted!');
        }
    }
}
