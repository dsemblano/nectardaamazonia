<!doctype html>
<html @php(language_attributes())>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php(do_action('get_header'))

    <!-- 1. Partytown Config -->
    <script>
        window.partytown = {
            forward: ['dataLayer.push', 'gtag'],
            lib: '/app/themes/nectartema/public/partytown/',
            resolveUrl: function(url, location, type) {
                if (url.hostname.indexOf('googletagmanager.com') > -1) {
                    return new URL('https://nectardaamazonia.com.br/gtm-proxy' + url.pathname + url.search);
                }
                if (url.hostname.indexOf('google-analytics.com') > -1) {
                    return new URL('https://nectardaamazonia.com.br/ga-proxy' + url.pathname + url.search);
                }
                return url;
            }
        };
    </script>

    <!-- 2. Partytown Loader -->
    <script>
        /*!! Partytown v0.10.x - MIT builder.io */ ! function(w, d, s, u, p, j, a, b, k, l, f, g) {
            function m() {
                g || (g = 1, "/" === (a = (p.lib || "/~partytown/") + (p.debug ? "debug/" : ""))[0] && (k = d
                    .querySelectorAll('script[type="text/partytown"]'), u === w ? (f = function() {
                        var e = d.createElement("iframe");
                        e.dataset.partytown = "sandbox", e.style.display = "none", d.body.appendChild(e)
                    }) : u.dispatchEvent(new CustomEvent("pt1")), k.length > 0 && (b = d.createElement("script"), b
                        .src = a + "partytown.js?v=0.10.2", b.dataset.pt = 1, d.head.appendChild(b))))
            }
            p = w.partytown || {}, u === w && (p.forward || []).forEach((function(e) {
                l = w, e.split(".").forEach((function(e, n, i) {
                    l = l[i[n]] = n < i.length - 1 ? l[i[n]] || {} : function() {
                        (w._ptf = w._ptf || []).push(i, arguments)
                    }
                }))
            })), "complete" === d.readyState ? m() : (w.addEventListener("DOMContentLoaded", m), w.addEventListener(
                "load", m))
        }(window, document, 0, window);
    </script>

    <!-- 3. Clean GA4 Initialization -->
    <script type="text/partytown" src="https://www.googletagmanager.com/gtag/js?id=G-4RDPL3WYS9"></script>
    <script type="text/partytown">
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-4RDPL3WYS9', {
        'allow_google_signals': false,
        'allow_ad_personalization_signals': false,
        'restricted_data_processing': true
    });
</script>
    @php(wp_head())


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
