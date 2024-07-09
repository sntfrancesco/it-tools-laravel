<?php

namespace App\Livewire\Admin\UserManager;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionTable extends Component
{
    use WithPagination;

    public $search;
    public $perPage = 15;
    public $sortColumn = 'id';
    public $sortDirection = 'asc';

    public $confirmingPermissionDeletion = false;

    protected $listeners = [
        'refreshPermissionTable' => '$refresh',
      ];

    public function render()
    {
        $permissions = Permission::orWhere('name', 'LIKE', '%' . $this->search . '%')->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);

        return view('livewire.admin.user-manager.permission_table', compact('permissions'));
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

    public function deletePermission($permissionId)
    {
        $permission = Permission::find($permissionId);
        $this->authorize('delete', $permission);
        if($permission->delete())
        {
            $this->dispatch('permission-deleted', permissionName: $permission->name);
            $this->confirmingPermissionDeletion = false;
        }
    }

    public function restorePermission($permissionId)
    {
        $permission = Permission::withTrashed()->find($permissionId);
        $this->authorize('restore', $permission);
        if($permission->restore())
        {
            $this->dispatch('permission-restored', permissionName: $permission->name);
        }
    }
}
