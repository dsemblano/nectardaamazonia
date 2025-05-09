<article class="container prose prose-xl max-w-full prose-h1:text-4xl mt-12" @php(post_class('h-entry'))>
  <header>
    <h1 class="p-name text-secondary">
      {!! $title !!}
    </h1>

    <p class="my-3 excerpt">
      {{ get_the_excerpt() }}
    </p>

    @include('partials.entry-meta')
  </header>

  <hr class="h-0.5 my-8 bg-gray-500 border-0">

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
