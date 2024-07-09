<x-dialog-modal wire:model.live="showUserModalForm">
    <x-slot name="title">
        {{ __('User Manager') }}
        <form wire:submit.prevent="saveUser">
    </x-slot>

    <x-slot name="content">
        <x-action-message class="me-3" on="userCreated">
            {{ __('User Saved.') }}
        </x-action-message>
        <x-action-message class="me-3" on="userUpdated">
            {{ __('User Updated.') }}
        </x-action-message>
        <div class="col-span-6 mb-4 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="block w-full mt-1" wire:model="currentUser.name" autocomplete="current-name" />
            <x-input-error for="currentUser.name" class="mt-2" />
        </div>

        <div class="col-span-6 mb-4 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="block w-full mt-1" wire:model="currentUser.email" autocomplete="current-email" />
            <x-input-error for="currentUser.email" class="mt-2" />
        </div>

        <div class="col-span-6 mb-4 sm:col-span-4">
            <x-label for="roles" value="{{ __('Roles') }}" />
            <div class="grid grid-cols-1 gap-4 mt-2 mb-2 md:grid-cols-2">
                @foreach ($rolesAssegnable as $role)
                    <label class="flex items-center">
                        <x-checkbox wire:model="currentUser.roles" :value="$role"/>
                        <span class="text-sm text-gray-600 ms-2 dark:text-gray-400">{{ __($role) }}</span>
                    </label>
                @endforeach
            </div>
            <x-input-error for="currentUser.roles" class="mt-2" />
        </div>

        <div class="col-span-6 mb-4 backdrop:sm:col-span-4">
            <x-label for="permissions" value="{{ __('Permissions') }}" />
            <div class="grid grid-cols-1 gap-4 mt-2 mb-2 md:grid-cols-2">
                @foreach ($permissionsAssegnable as $permission)
                    <label class="flex items-center">
                        <x-checkbox wire:model="currentUser.permissions" :value="$permission"/>
                        <span class="text-sm text-gray-600 ms-2 dark:text-gray-400">{{ __($permission) }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <x-input-error for="currentUser.permissions" class="mt-2" />
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="$set('showUserModalForm', false)" wire:loading.attr="disabled">
            {{ __('Close') }}
        </x-secondary-button>
        <x-button class="ms-3" wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-button>
        </form>
    </x-slot>
</x-dialog-modal>
