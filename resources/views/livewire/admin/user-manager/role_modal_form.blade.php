<x-dialog-modal wire:model.live="showRoleModalForm">
    <x-slot name="title">
        @if ($currentRole['id'])
            {{ __('Edit Role') }}
        @else
            {{ __('Create Role') }}
        @endif
        <form wire:submit.prevent="saveRole">
    </x-slot>

    <x-slot name="content">
        <x-action-message class="me-3" on="roleCreated">
            {{ __('Role Saved.') }}
        </x-action-message>
        <x-action-message class="me-3" on="roleUpdated">
            {{ __('Role Updated.') }}
        </x-action-message>
        <div class="col-span-6 mb-4 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="block w-full mt-1" wire:model="currentRole.name" autocomplete="current-name" />
            <x-input-error for="currentRole.name" class="mt-2" />
        </div>

        <div class="col-span-6 mb-4 backdrop:sm:col-span-4">
            <x-label for="permissions" value="{{ __('Permissions') }}" />
            <div class="grid grid-cols-1 gap-4 mt-2 mb-2 md:grid-cols-2">
                @foreach ($permissionsAssegnable as $permission)
                    <label class="flex items-center">
                        <x-checkbox wire:model="currentRole.permissions" :value="$permission"/>
                        <span class="text-sm text-gray-600 ms-2 dark:text-gray-400">{{ __($permission) }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <x-input-error for="currentRole.permissions" class="mt-2" />

    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="$set('showRoleModalForm', false)" wire:loading.attr="disabled">
            {{ __('Close') }}
        </x-secondary-button>
        <x-button class="ms-3" wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-button>
        </form>
    </x-slot>
</x-dialog-modal>
