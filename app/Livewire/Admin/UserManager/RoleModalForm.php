<?php

namespace App\Livewire\Admin\UserManager;

use Livewire\Component;
use Faker\Factory as Faker;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class RoleModalForm extends Component
{
    protected $currentRoleDefault = ['id' => false, 'name' => '', 'guard_name' => 'web', 'permissions' => []];
    public $currentRole = []; //$this->currentRoleDefault;
    public $permissionsAssegnable = [];
    public $showRoleModalForm = false;

    public function __construct()
    {
        $this->currentRole = $this->currentRoleDefault;
        $this->permissionsAssegnable = Permission::all()->pluck('name');
    }

    protected $listeners = [
        'clickCreateNewRoleButton',
        'clickEditRoleButton'
    ];

    public function render()
    {
        return view('livewire.admin.user-manager.role_modal_form');
    }

    public function clickCreateNewRoleButton()
    {
        $this->currentRole = $this->currentRoleDefault;
        $this->openModal();
    }

    public function clickEditRoleButton(Role $role)
    {
        $this->currentRole = [
                'id' => $role->id,
                'name' => $role->name,
                'guard_name' => $role->guard_name,
                'permissions' => $role->getPermissionNames(),
        ];
        $this->openModal();
    }

    public function openModal()
    {
        $this->showRoleModalForm = true;
    }

    public function closeModal()
    {
        $this->showRoleModalForm = false;
    }

    public function rules()
    {
        return [
            'currentRole.name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($this->currentRole['id'], 'id'),
            ],
        ];
    }

    public function saveRole()
    {
        if($this->currentRole['id'] !== false)
        {
            $role = Role::find($this->currentRole['id']);
            $this->updateRole($role);
        }
        else
        {
            $this->createRole();
        }
    }

    public function createRole()
    {
        $this->authorize('create', Role::class);

        // Validazione dei dati del nuovo utente
        $this->validate();

        // Salvataggio dell'utente nel database
        $role = Role::create([
            'name' => $this->currentRole['name'],
            'guard_name' => $this->currentRole['guard_name'],
        ]);

        if( count($this->currentRole['permissions']) > 0)
        {
            $role->syncPermissions($this->currentRole['permissions']);
        }

        if($role)
        {
            // Chiusura del modal
            $this->closeModal();

            // Aggiornamento della lista degli utenti
            $this->dispatch('role-created');
            $this->dispatch('refreshRoleTable');


            // Reset dei dati del utente corrente
            $this->currentRole = $this->currentRoleDefault;
        }

    }

    public function updateRole(Role $role)
    {
        $this->authorize('update', auth()->user(), $this->currentRole['id']);
        // Validazione dei dati del nuovo utente
        $this->validate();

        // Salvataggio dell'utente nel database
        $res = $role->update([
            'name' => $this->currentRole['name'],
            'guard_name' => $this->currentRole['guard_name'],
        ]);

        if( count($this->currentRole['permissions']) > 0)
        {
            $role->syncPermissions($this->currentRole['permissions']);
        }

        if($res)
        {
            // Chiusura del modal
            $this->closeModal();

            // Aggiornamento della lista degli utenti
            $this->dispatch('role-updated');
            $this->dispatch('refreshRoleTable');


            // Reset dei dati del utente corrente
            $this->currentRole = $this->currentRoleDefault;
        }

    }
}
