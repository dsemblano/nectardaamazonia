<header class="banner w-full z-50 bg-fundo top-0 left-0">
    <div class="flex flex-row lg:flex-col lg:text-2xl text-p container py-4 gap-4">
        @include('partials.logo')
        @if (has_nav_menu('primary_navigation'))
            <nav class="nav-primary bg-red-400" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
                {{-- {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'echo' => false]) !!} --}}
                @include('partials.menu')
            </nav>
        @endif
    </div>
</header>
