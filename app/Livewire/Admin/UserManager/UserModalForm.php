<?php

namespace App\Livewire\Admin\UserManager;

use App\Models\User;
use Livewire\Component;
use Faker\Factory as Faker;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserModalForm extends Component
{
    protected $currentUserDefault = ['id' => false, 'name' => '', 'email' => '', 'permissions' => [], 'roles' => []];
    public $currentUser = []; //$this->currentUserDefault;
    public $rolesAssegnable = [];
    public $permissionsAssegnable = [];
    public $showUserModalForm = false;

    public function __construct()
    {
        $this->currentUser = $this->currentUserDefault;
        $this->rolesAssegnable = Role::all()->pluck('name');
        $this->permissionsAssegnable = Permission::all()->pluck('name');
    }

    protected $listeners = [
        'clickCreateNewUserButton',
        'clickEditUserButton'
    ];

    public function render()
    {
        return view('livewire.admin.user-manager.user_modal_form');
    }

    public function clickCreateNewUserButton()
    {
        $this->currentUser = $this->currentUserDefault;
        $this->openModal();
    }

    public function clickEditUserButton(User $user)
    {
        $this->currentUser = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'permissions' => $user->getPermissionNames(),
                'roles' => $user->getRoleNames()
        ];
        $this->openModal();
    }

    public function openModal()
    {
        $this->showUserModalForm = true;
    }

    public function closeModal()
    {
        $this->showUserModalForm = false;
    }

    public function rules()
    {
        return [
            'currentUser.name' => [
                'required',
                'string',
                'max:255',
            ],
            'currentUser.email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->currentUser['id'], 'id'),
            ],
            // 'currentUser.roles' => [
            //     'required',
            // ]
        ];
    }

    public function saveUser()
    {
        if($this->currentUser['id'] !== false)
        {
            $user = User::find($this->currentUser['id']);
            $this->updateUser($user);
        }
        else
        {
            $this->createUser();
        }
    }

    public function createUser()
    {
        $this->authorize('create', User::class);

        // Validazione dei dati del nuovo utente
        $this->validate();

        $faker = Faker::create();
        $password = $faker->password(8, 20);

        // Salvataggio dell'utente nel database
        $user = User::create([
            'name' => $this->currentUser['name'],
            'email' => $this->currentUser['email'],
            'password' => Hash::make($password),
        ]);

        if( count($this->currentUser['roles'])>0)
        {
            $user->syncRoles($this->currentUser['roles']);
        }

        if( count($this->currentUser['permissions']) > 0)
        {
            $user->syncPermissions($this->currentUser['permissions']);
        }

        if($user)
        {
            // Chiusura del modal
            $this->closeModal();

            // Aggiornamento della lista degli utenti
            $this->dispatch('user-created');
            $this->dispatch('refreshUserTable');


            // Reset dei dati del utente corrente
            $this->currentUser = $this->currentUserDefault;
        }

    }

    public function updateUser(User $user)
    {
        $this->authorize('update', auth()->user(), $this->currentUser['id']);
        // Validazione dei dati del nuovo utente
        $this->validate();

        // Salvataggio dell'utente nel database
        $res = $user->update([
            'name' => $this->currentUser['name'],
            'email' => $this->currentUser['email'],
        ]);

        if( count($this->currentUser['roles'])>0)
        {
            $user->syncRoles($this->currentUser['roles']);
        }

        if( count($this->currentUser['permissions']) > 0)
        {
            $user->syncPermissions($this->currentUser['permissions']);
        }

        if($res)
        {
            // Chiusura del modal
            $this->closeModal();

            // Aggiornamento della lista degli utenti
            $this->dispatch('user-updated');
            $this->dispatch('refreshUserTable');


            // Reset dei dati del utente corrente
            $this->currentUser = $this->currentUserDefault;
        }

    }
}
