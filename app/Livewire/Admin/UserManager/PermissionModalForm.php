<?php

namespace App\Livewire\Admin\UserManager;

use Livewire\Component;
use Faker\Factory as Faker;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class PermissionModalForm extends Component
{
    protected $currentPermissionDefault = ['id' => false, 'name' => '', 'guard_name' => 'web', 'roles' => []];
    public $currentPermission = []; //$this->currentPermissionDefault;
    public $rolesAssegnable = [];
    public $showPermissionModalForm = false;

    public function __construct()
    {
        $this->currentPermission = $this->currentPermissionDefault;
        $this->rolesAssegnable = Role::all()->pluck('name');
    }

    protected $listeners = [
        'clickCreateNewPermissionButton',
        'clickEditPermissionButton'
    ];

    public function render()
    {
        return view('livewire.admin.user-manager.permission_modal_form');
    }

    public function clickCreateNewPermissionButton()
    {
        $this->currentPermission = $this->currentPermissionDefault;
        $this->openModal();
    }

    public function clickEditPermissionButton(Permission $permission)
    {

        $this->currentPermission = [
                'id' => $permission->id,
                'name' => $permission->name,
                'guard_name' => $permission->guard_name,
                'roles' => $permission->getRoleNames(),
        ];
        $this->openModal();
    }

    public function openModal()
    {
        $this->showPermissionModalForm = true;
    }

    public function closeModal()
    {
        $this->showPermissionModalForm = false;
    }

    public function rules()
    {
        return [
            'currentPermission.name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions', 'name')->ignore($this->currentPermission['id'], 'id'),
            ],
        ];
    }

    public function savePermission()
    {
        if($this->currentPermission['id'] !== false)
        {
            $permission = Permission::find($this->currentPermission['id']);
            $this->updatePermission($permission);
        }
        else
        {
            $this->createPermission();
        }
    }

    public function createPermission()
    {
        $this->authorize('create', Permission::class);

        // Validazione dei dati
        $this->validate();

        $permission = Permission::create([
            'name' => $this->currentPermission['name'],
            'guard_name' => $this->currentPermission['guard_name'],
        ]);

        $permission->syncRoles($this->currentPermission['roles']);

        if($permission)
        {
            // Chiusura del modal
            $this->closeModal();

            // Aggiornamento della lista degli utenti
            $this->dispatch('permission-created');
            $this->dispatch('refreshPermissionTable');


            // Reset dei dati del utente corrente
            $this->currentPermission = $this->currentPermissionDefault;
        }

    }

    public function updatePermission(Permission $permission)
    {
        $this->authorize('update', auth()->user(), $this->currentPermission['id']);
        // Validazione dei dati del nuovo utente
        $this->validate();

        // Salvataggio dell'utente nel database
        $res = $permission->update([
            'name' => $this->currentPermission['name'],
            'guard_name' => $this->currentPermission['guard_name'],
        ]);

        $permission->syncRoles($this->currentPermission['roles']);

        if($res)
        {
            // Chiusura del modal
            $this->closeModal();

            // Aggiornamento della lista degli utenti
            $this->dispatch('permission-updated');
            $this->dispatch('refreshPermissionTable');


            // Reset dei dati del utente corrente
            $this->currentPermission = $this->currentPermissionDefault;
        }

    }
}
