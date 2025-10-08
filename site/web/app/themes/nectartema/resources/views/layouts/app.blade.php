<!doctype html>
<html @php(language_attributes())>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php(do_action('get_header'))
    @php(wp_head())
    <link rel="preload" fetchpriority="high" as="image" href="{{ Vite::asset('resources/images/logonectarnovo.webp') }}" type="image/webp">
    @if (is_front_page() || is_home() )
    <link rel="preload" fetchpriority="high" as="image" loading="eager" href="/app/uploads/2024/11/PNG-Mel-home-nectar-da-amazonia.webp" type="image/webp">
    @endif
    <link rel="preload" href="{{ Vite::asset('resources/fonts/Poppins/Poppins-Regular.ttf') }}" as="font" type="font/ttf" crossorigin>
    <link rel="author" type="text/plain" href="{{ Vite::asset('resources/fonts/humans.txt') }}" />
    @include('partials.gtag')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body @php(body_class())>
    @php(wp_body_open())

    <div id="app">
      <a class="sr-only focus:not-sr-only" href="#main">
        {{ __('Skip to content', 'sage') }}
      </a>

      @include('sections.header')

      <main id="main" class="main flex-1">
        @yield('content')
      </main>

      @hasSection('sidebar')
        <aside class="sidebar">
          @yield('sidebar')
        </aside>
      @endif

      @include('sections.footer')
    </div>
    {{-- @include('partials/arrowcdtop') --}}

    @php(do_action('get_footer'))
    @php(wp_footer())
  </body>
</html>
