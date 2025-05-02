<!doctype html>
<html @php(language_attributes())>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php(do_action('get_header'))
    @php(wp_head())

    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body @php(body_class())>
    @php(wp_body_open())

    <div id="app">
      <a class="sr-only focus:not-sr-only" href="#main">
        {{ __('Skip to content', 'sage') }}
      </a>

      @include('sections.header')

      <main id="main" class="main mt-24 lg:pt-6 flex-1">
        {{-- Só para as págins Woocommerce --}}
        @if (is_woocommerce() || is_cart() || is_checkout() || is_account_page())
        <div class="container woocommerce-wrapper">
          @yield('content')
        </div>
            
        {{-- Quando for páginas menos a home --}}
        @elseif (! is_front_page() && ! is_home())
        {{-- <div class="page-wrapper bg-green-400"> --}}
          @yield('content')
        {{-- </div> --}}

        @else
        {{-- Só para a home --}}
        <div class="home-wrapper bg-red-400">
          @yield('content')
        </div>
        @endif

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
