<?php

namespace App\Livewire\Admin\UserManager;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class UserTable extends Component
{
    use WithPagination;

    public $search;
    public $perPage = 15;
    public $sortColumn = 'created_at';
    public $sortDirection = 'asc';

    public $confirmingUserDeletion = false;

    protected $listeners = [
        'refreshUserTable' => '$refresh',
      ];

    public function render()
    {
        $users = User::withTrashed()->with('roles')->filter(['search' => $this->search])->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);

        return view('livewire.admin.user-manager.user_table', compact('users'));
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

    public function deleteUser($userId)
    {
        $user = User::find($userId);
        $this->authorize('delete', $user);
        if($user->delete())
        {
            $this->dispatch('user-deleted', userName: $user->name);
            $this->confirmingUserDeletion = false;
        }
    }

    public function restoreUser($userId)
    {
        $user = User::withTrashed()->find($userId);
        $this->authorize('restore', $user);
        if($user->restore())
        {
            $this->dispatch('user-restored', userName: $user->name);
        }
    }
}
