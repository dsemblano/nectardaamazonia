{{-- 1. Check & Inline Critical CSS --}}
    @php
      $template = is_front_page() ? 'home' : (is_shop() || is_product_category() ? 'shop' : 'default');
      $critical_path = public_path("css/critical-{$template}.css");
    @endphp

    @if (file_exists($critical_path))
      <style>
        {!! file_get_contents($critical_path) !!}
      </style>
    @endif