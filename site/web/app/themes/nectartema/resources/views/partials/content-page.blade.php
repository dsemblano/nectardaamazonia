<section class="container bg-purple-400">
  @php(the_content())
</section>

@if ($pagination())
  <nav class="page-nav" aria-label="Page">
    {!! $pagination !!}
  </nav>
@endif
