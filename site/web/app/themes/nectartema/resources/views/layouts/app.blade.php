<!doctype html>
<html @php(language_attributes())>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php(do_action('get_header'))
    @php(wp_head())

    <!-- Add forwarding event for Google Tag Manager -->
    {{-- <script>
        partytown = {
            forward: ['dataLayer.push'],
        };
    </script> --}}

    <link rel="preload" fetchpriority="high" as="image"
        href="{{ Vite::asset('resources/images/meliponario-1024x576-1.webp') }}" type="image/webp">
    @if (is_front_page() || is_home())
        <link rel="preload" fetchpriority="high" as="image"
            href="{{ Vite::asset('resources/images/mobile-meliponario.webp') }}" type="image/webp">
        <link rel="preload" fetchpriority="high" as="image"
            href="{{ Vite::asset('resources/images/meliponario-1024x576-1.webp') }}" type="image/webp">
    @endif

    @if (!is_front_page() && !is_home())
        <link rel="preload" as="image" href="{{ Vite::asset('resources/images/bg/bg-mobile.webp') }}"
            imagesrcset="{{ Vite::asset('resources/images/bg/bg-mobile.webp') }} 768w, {{ Vite::asset('resources/images/bg/bg-desktop.webp') }} 1600w"
            imagesizes="100vw" />
    @endif

    <link rel="preload" href="{{ Vite::asset('resources/fonts/Poppins/Poppins-Regular.ttf') }}" as="font"
        type="font/ttf" crossorigin>
    <link rel="author" type="text/plain" href="{{ Vite::asset('resources/fonts/humans.txt') }}" />
    {{-- @include('partials.gtag') --}}
    {{-- @include('partials.partytown')
    @include('partials.gtm') --}}

    {{-- <script type="text/partytown" src="https://www.googletagmanager.com/gtag/js?GTM-TXS3QB8L">
    </script>
    <script type="text/partytown">
    window.dataLayer = window.dataLayer || [];
    window.gtag = function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    
    gtag('config', 'GTM-TXS3QB8L');
    </script> --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body @php(body_class())>
    {{-- @include('partials.gtmbody') --}}
    @php(wp_body_open())

    <div id="app">
        <a class="sr-only focus:not-sr-only" href="#main">
            {{ __('Skip to content', 'sage') }}
        </a>

        @include('sections.header')

        <main id="main" class="main">
            @yield('content')
        </main>

        @hasSection('sidebar')
            <aside class="sidebar">
                @yield('sidebar')
            </aside>
        @endif

        @include('sections.footer')
    </div>
    @include('partials/arrowcdtop')

    @php(do_action('get_footer'))
    @php(wp_footer())
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const observerOptions = {
                threshold: 0.15 // Dispara quando 15% da seção estiver visível
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("is-visible");
                        // Para de observar após a animação (ganho de performance)
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Seleciona todas as seções que devem animar
            document.querySelectorAll(".reveal-on-scroll").forEach((section) => {
                observer.observe(section);
            });
        });
    </script>
</body>

</html>
