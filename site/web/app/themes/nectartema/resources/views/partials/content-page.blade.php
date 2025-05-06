{{-- @if (! is_front_page() && ! is_home() ) --}}

@php(the_content())

@if ($pagination())
  <nav class="page-nav" aria-label="Page">
    {!! $pagination !!}
  </nav>
@endif
