<?php

namespace App\Http\Livewire\College;

use App\Models\College;
use Livewire\Component;
use App\Traits\AlertTrait;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CollegeLivewire extends Component
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
        $this->authorize('viewAny', College::class);
    }

    public function hydrate()
    {
        if (Gate::denies('viewAny', College::class)) {
            return redirect(url()->previous());
        }
    }

    public function render()
    {
        return view('livewire.college.college-livewire', [
            'colleges' => $this->getColleges(),
        ])->extends('layouts.app', [
            'active_nav' => 'college',
            'title' => 'College',
            'breadcrumbs' => [
                [
                    'link' => route('college'),
                    'label' => 'College',
                ], [
                    'label' => 'List',
                    'active' => true,
                ],
            ],
        ]);
    }

    protected function getColleges()
    {
        return College::query()
            ->search($this->search)
            ->paginate($this->showRow);
    }

    public function delete($id)
    {
        $college = College::find($id);
        if (Gate::allows('delete', $college) && $college->delete()) {
            $this->alert_success('Record Deleted!');
        }
    }
}
