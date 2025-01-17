<!-- Responsive Navigation Menu -->
<div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
        @foreach ($items as $label => $route)
            @if(is_array($route))
                {{-- <x-responsive-nav-link href="#" :active="request()->routeIs($route)">
                    {{ $label }}
                </x-responsive-nav-link> --}}
                <x-responsive-nav-link href="#" :active="request()->routeIs($route['activeRoute'])">
                    {{$label}}
                </x-responsive-nav-link>
                @foreach ($route['subRoutes'] as $key => $val)
                    <x-responsive-nav-link href="{{ route($val) }}" :active="request()->routeIs($val)" class="pl-7">
                        > {{ $key }}
                    </x-responsive-nav-link>
                @endforeach

            @else
                <x-responsive-nav-link href="{{ route($route) }}" :active="request()->routeIs($route)">
                    {{ $label }}
                </x-responsive-nav-link>
            @endif
        @endforeach
    </div>

    <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
        <div class="flex items-center px-4">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div class="shrink-0 me-3">
                    <img class="object-cover w-10 h-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                </div>
            @endif

            <div>
                <div class="text-base font-medium text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
            </div>
        </div>

        <div class="mt-3 space-y-1">
            <!-- Account Management -->
            <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                {{ __('Profile') }}
            </x-responsive-nav-link>

            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                    {{ __('API Tokens') }}
                </x-responsive-nav-link>
            @endif

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf

                <x-responsive-nav-link href="{{ route('logout') }}"
                               @click.prevent="$root.submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>

            <!-- Team Management -->
            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="border-t border-gray-200 dark:border-gray-600"></div>

                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Manage Team') }}
                </div>

                <!-- Team Settings -->
                <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                    {{ __('Team Settings') }}
                </x-responsive-nav-link>

                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                    <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                        {{ __('Create New Team') }}
                    </x-responsive-nav-link>
                @endcan

                <!-- Team Switcher -->
                @if (Auth::user()->allTeams()->count() > 1)
                    <div class="border-t border-gray-200 dark:border-gray-600"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-switchable-team :team="$team" component="responsive-nav-link" />
                    @endforeach
                @endif
            @endif
        </div>
    </div>
</div>
