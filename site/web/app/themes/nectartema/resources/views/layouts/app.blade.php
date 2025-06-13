<!doctype html>
<html @php(language_attributes())>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php(do_action('get_header'))
    @php(wp_head())
    <link rel="preload" fetchpriority="high" as="image" href="{{ Vite::asset('images/logonectarnovo.webp')}}" type="image/webp">
    <link rel="preload" href="@asset('fonts/Poppins/Poppins-Regular.ttf')" as="font" type="font/ttf" crossorigin>
    <link rel="author" type="text/plain" href="{{ Vite::asset('humans.txt') }}" />
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

    @php(do_action('get_footer'))
    @php(wp_footer())
  </body>
</html>
