<!doctype html>
<html @php(language_attributes())>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php(do_action('get_header'))
    @php(wp_head())

    <!-- 1. Partytown Config & Path Mapping -->
    <script>
        window.partytown = {
            forward: ['dataLayer.push', 'gtag'],
            // Points Partytown to Vite's asset folder mapping
            lib: '/wp-content/themes/nectartema/public/partytown/'
        };
    </script>

    <!-- 2. Load Core Partytown File via Vite Directives -->
    <script src="/wp-content/themes/nectartema/public/partytown/partytown.js"></script>

    <!-- 3. Google Tag (gtag.js) intercepted by Partytown -->
    <!-- Ensure you route this via your Trellis reverse proxy to avoid CORS errors -->
    <script type="text/partytown" src="/gtm-proxy/gtag/js?id=G-4RDPL3WYS9"></script>
    <script type="text/partytown">
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-4RDPL3WYS9');
  </script>

    @if (is_front_page() || is_home())
        <link rel="preload" fetchpriority="high" as="image" href="{{ Vite::asset('resources/images/loja.webp') }}"
            type="image/webp" imagesizes="(max-width: 768px) 100vw, 65vw">
        <link rel="preload" fetchpriority="high" as="image" href="{{ Vite::asset('resources/images/loja.avif') }}"
            type="image/webp" imagesizes="(max-width: 576px) 100vw, 100vw">
    @endif

    <link rel="preload" href="{{ Vite::asset('resources/fonts/Poppins/Poppins-Regular.ttf') }}" as="font"
        type="font/ttf" crossorigin>
    <link rel="author" type="text/plain" href="{{ Vite::asset('resources/fonts/humans.txt') }}" />


    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body @php(body_class())>
    {{-- @include('partials.gtmbody') --}}
    @php(wp_body_open())

    <div id="app">
        <a class="sr-only focus:not-sr-only" href="#main">
            {{ __('Pular para o conteúdo', 'sage') }}
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


    <svg width="0" height="0" style="position: absolute; pointer-events: none;" aria-hidden="true">
        <defs>
            <clipPath id="favo-arredondado-plugin" clipPathUnits="objectBoundingBox">
                <path d="
        M 0.44 0.03
        Q 0.50 0.00, 0.56 0.03
        L 0.95 0.22
        Q 1.00 0.25, 0.98 0.31
        L 0.98 0.69
        Q 1.00 0.75, 0.95 0.78
        L 0.56 0.97
        Q 0.50 1.00, 0.44 0.97
        L 0.05 0.78
        Q 0.00 0.75, 0.02 0.69
        L 0.02 0.31
        Q 0.00 0.25, 0.05 0.22
        Z" />
            </clipPath>
        </defs>
    </svg>

</body>

</html>
