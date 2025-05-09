<article class="container prose prose-xl max-w-full mt-12" @php(post_class('h-entry'))>
  <header>
    <h1 class="p-name text-secondary">
      {!! $title !!}
    </h1>

    <p class="my-3 excerpt">
      {{ get_the_excerpt() }}
    </p>

    @include('partials.entry-meta')
  </header>

  <div class="e-content">
    @php(the_content())
  </div>

  @if ($pagination())
    <footer>
      <nav class="page-nav" aria-label="Page">
        {!! $pagination !!}
      </nav>
    </footer>
  @endif

  {{-- @php(comments_template()) --}}
</article>
