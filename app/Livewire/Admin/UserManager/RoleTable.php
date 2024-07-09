<?php

namespace App\Livewire\Admin\UserManager;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RoleTable extends Component
{
    use WithPagination;

    public $search;
    public $perPage = 15;
    public $sortColumn = 'name';
    public $sortDirection = 'asc';

    public $confirmingRoleDeletion = false;

    protected $listeners = [
        'refreshRoleTable' => '$refresh',
      ];

    public function render()
    {
        $roles = Role::orWhere('name', 'LIKE', '%' . $this->search . '%')->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);

        return view('livewire.admin.user-manager.role_table', compact('roles'));
    }

    public function sortBy($field)
    {
        if($this->sortColumn === $field)
        {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        }
        else {
            $this->sortColumn = $field;
        }
    }

    public function deleteRole($roleId)
    {
        $role = Role::find($roleId);
        $this->authorize('delete', $role);
        if($role->delete())
        {
            $this->dispatch('role-deleted', roleName: $role->name);
            $this->confirmingRoleDeletion = false;
        }
    }
}
