<x-dialog-modal wire:model.live="showPermissionModalForm">
    <x-slot name="title">
        @if ($currentPermission['id'])
            {{ __('Edit Permission') }}
        @else
            {{ __('Create Permission') }}
        @endif
        <form wire:submit.prevent="savePermission">
    </x-slot>

    <x-slot name="content">
        <x-action-message class="me-3" on="roleCreated">
            {{ __('Permission Saved.') }}
        </x-action-message>
        <x-action-message class="me-3" on="roleUpdated">
            {{ __('Permission Updated.') }}
        </x-action-message>
        <div class="col-span-6 mb-4 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="block w-full mt-1" wire:model="currentPermission.name" autocomplete="current-name" />
            <x-input-error for="currentPermission.name" class="mt-2" />
        </div>

        <div class="col-span-6 mb-4 backdrop:sm:col-span-4">
            <x-label for="roles" value="{{ __('Roles') }}" />
            <div class="grid grid-cols-1 gap-4 mt-2 mb-2 md:grid-cols-2">
                @foreach ($rolesAssegnable as $role)
                    <label class="flex items-center">
                        <x-checkbox wire:model="currentPermission.roles" :value="$role"/>
                        <span class="text-sm text-gray-600 ms-2 dark:text-gray-400">{{ __($role) }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <x-input-error for="currentPermission.roles" class="mt-2" />

    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="$set('showPermissionModalForm', false)" wire:loading.attr="disabled">
            {{ __('Close') }}
        </x-secondary-button>
        <x-button class="ms-3" wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-button>
        </form>
    </x-slot>
</x-dialog-modal>
