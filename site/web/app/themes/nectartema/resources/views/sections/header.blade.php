<header class="banner flex w-full z-50 top-0 left-0 bg-fundo shadow-md">
    <div class="flex flex-row lg:flex-col text-p container justify-between">
        @include('partials.logo')
        @if (has_nav_menu('primary_navigation'))
            <nav class="nav-primary" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
                @include('partials.menu')
            </nav>
        @endif
    </div>
</header>
