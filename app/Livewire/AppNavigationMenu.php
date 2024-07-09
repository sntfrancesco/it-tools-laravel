<?php
    namespace App\Livewire;

    use Laravel\Jetstream\Http\Livewire\NavigationMenu;

    class AppNavigationMenu extends NavigationMenu
    {

        /**
         * Define the list of items to go in the navigation as 'Label' => 'route',
         * or to create a dropdown: 'Dropdown Label' => ['Label' => 'route']
         *
         */
        public $items = array (
            'Dashboard' => 'dashboard',
        );

        public function __construct()
        {
            if(auth()->user()->can('admin_user_management'))
            {
                $this->items['User Manager'] = array(
                    'activeRoute' => 'admin.users_manager.*',
                    'subRoutes' => []
                );

                if( auth()->user()->can('admin_user_index') )
                {
                    $this->items['User Manager']['subRoutes']['Users'] = 'admin.users_manager.users';
                }

                if( auth()->user()->can('admin_roles_index') )
                {
                    $this->items['User Manager']['subRoutes']['Roles'] = 'admin.users_manager.roles';
                }

                if( auth()->user()->can('admin_permissions_index') )
                {
                    $this->items['User Manager']['subRoutes']['Permissions'] = 'admin.users_manager.permissions';
                }

                $this->items['Tools'] = array(
                    'activeRoute' => 'admin.tools.logs_viewer.*',
                    'subRoutes' => []
                );
                if( auth()->user()->can('admin_permissions_index') )
                {
                    $this->items['Tools']['subRoutes']['LogsViewer'] = 'admin.tools.logs_viewer';
                }
            }
        }
    }
