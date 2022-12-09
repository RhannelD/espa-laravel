<?php

namespace App\Http\Livewire\Role;

use App\Traits\AlertTrait;
use App\Traits\ModalTrait;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleFormLivewire extends Component
{
    use AlertTrait;
    use ModalTrait;
    public $modal_id = 'role-form-modal';
    
    public $role_id;
    public $role;

    protected function rules()
    {
        return [
            'role.name' => "required|unique:roles,name,{$this->role_id},id",
        ];
    }
    
    protected $validationAttributes = [
        'role.name' => 'role name',
    ];

    protected $listeners = [
        'create' => 'create',
        'edit' => 'edit',
    ];

    public function create()
    {
        $this->role_id = null;
        $this->role = new Role;
        $this->show_modal($this->modal_id);
    }

    public function edit($role_id)
    {
        $role = Role::find($role_id);
        if ($role) {
            $this->role_id = $role_id;
            $this->role = $role->replicate();
            $this->show_modal($this->modal_id);
        }
    }

    public function render()
    {
        return view('livewire.role.role-form-livewire');
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function save()
    {
        $data = $this->validate();

        $sucess = isset($this->role_id)
            ? $this->update($data)
            : $this->store($data);

        if ($sucess) {
            $this->hide_modal($this->modal_id);
            $this->emitUp('refresh');
        }
    }

    protected function store($data)
    {
        if (Gate::denies('create', Role::class)) {
            return;
        }
        
        $role = Role::create($data['role']);
    
        if ($role->wasRecentlyCreated) {
            $this->alert_success('Success!', 'Record has been successfully created');
            return true;
        }
    }

    protected function update($data)
    {
        $role = Role::find($this->role_id);
        if (Gate::allows('update', $role) && $role->update($data['role'])) {
            $this->alert_success('Success!', 'Record has been successfully updated');
            return true;
        }
    }
}
