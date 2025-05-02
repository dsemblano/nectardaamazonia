@if (! is_front_page() && ! is_home() )

  <div class="container mx-auto">
      <div class="section-page prose prose-xl max-w-full">
        @php(the_content())
      </div>
  </div>

@else
  @php(the_content())
@endif

@if ($pagination())
  <nav class="page-nav" aria-label="Page">
    {!! $pagination !!}
  </nav>
@endif
