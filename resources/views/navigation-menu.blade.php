<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 dark:bg-gray-800 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <x-desktop-menu :items="$items" />

            <x-hamburger-menu />
        </div>
    </div>

    <x-mobile-menu :items="$items"/>
</nav>
