<div>
    <x-action-message class="rounded-lg bg-gray-50 dark:bg-gray-800 me-3 py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400" on="permission-deleted">
        {{ __('Deleted.') }}
    </x-action-message>

    <x-action-message class="rounded-lg bg-gray-50 dark:bg-gray-800 me-3 py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400" on="permission-restored">
        {{ __('Restored.') }}
    </x-action-message>

    <x-action-message class="rounded-lg bg-gray-50 dark:bg-gray-800 me-3 py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400" on="permission-created">
        {{ __('Created.') }}
    </x-action-message>

    <x-action-message class="rounded-lg bg-gray-50 dark:bg-gray-800 me-3 py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400" on="permission-updated">
        {{ __('Updated.') }}
    </x-action-message>

    <section class="container px-4 mx-auto">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-x-3">
                    <h2 class="text-lg font-medium text-gray-800 dark:text-white">{{ __('Permission Manager') }}</h2>

                    <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{ $permissions->total() }} @choice('permission|permissions', $permissions->total())</span>
                </div>

                <!--p class="mt-1 text-sm text-gray-500 dark:text-gray-300">These companies have purchased in the last 12 months.</p-->
            </div>

            <div class="flex items-center mt-4 gap-x-3">
                <button wire:click="$dispatchTo('admin.user-manager.permission-modal-form', 'clickCreateNewPermissionButton')" class="flex items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                    <span>{{ __('Add Permission') }}</span>
                </button>
            </div>
        </div>

        <div class="mt-6 md:flex md:items-center md:justify-between">
            <div class="relative flex items-center mt-4 md:mt-0">
                <span class="absolute">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </span>

                <input wire:model.live="search" type="text" placeholder="Search" class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
            </div>
        </div>

        <div class="flex flex-col mt-6">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <button class="flex items-center gap-x-3 focus:outline-none" wire:click='sortBy("name")'>
                                            <span>{{ __('Permission') }}</span>

                                            <svg class="h-3" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                                <path d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                                <path d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z" fill="currentColor" stroke="currentColor" stroke-width="0.3" />
                                            </svg>
                                        </button>
                                    </th>

                                    <th scope="col" class="relative py-3.5 px-4">
                                        <span class="sr-only">__('Action')</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                    @foreach ($permissions as $permission)
                                        <tr wire:key="{{ $permission->id }}">
                                            <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                                <div>
                                                    <h2 class="font-medium text-gray-800 dark:text-white ">{{ $permission->name }}</h2>
                                                    <p class="text-sm font-normal text-gray-600 dark:text-gray-400">{{ $permission->id }} | {{ $permission->guard_name }}</p>
                                                </div>
                                            </td>

                                            <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                                                <div class="flex items-center justify-end gap-x-3">
                                                    @can('update', $permission)
                                                        <button wire:click="$dispatchTo('admin.user-manager.permission-modal-form', 'clickEditPermissionButton', { permission: {{ $permission->id }} })" class="px-3 py-2 text-sm font-normal text-white transition-colors duration-200 rounded-lg bg-blue-500/80 hover:bg-blue-400/80 dark:bg-blue-700/80 dark:hover:bg-blue-600/80">{{ __('Edit') }}</button>
                                                    @endcan

                                                    @can('delete', $permission)
                                                        <button wire:click="$set('confirmingPermissionDeletion', {{ $permission->id }})" class="px-3 py-2 text-sm font-normal text-white transition-colors duration-200 rounded-lg bg-red-500/80 hover:bg-red-400/80 dark:bg-red-700/80 dark:hover:bg-red-600/80">{{ __('Delete') }}</button>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{ $permissions->links('livewire.global.simple-pagination') }}
    </section>



    <!-- Delete Token Confirmation Modal -->
    <x-confirmation-modal wire:model.live="confirmingPermissionDeletion">
        <x-slot name="title">
            {{ __('Delete Permission') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete the Permission :i ?', ['i' =>  $confirmingPermissionDeletion ]) }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingPermissionDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="deletePermission({{ $confirmingPermissionDeletion }})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    @livewire('admin.user-manager.permission-modal-form')
</div>
