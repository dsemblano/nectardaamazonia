<div>
  <div class="container mt-10 grid grid-cols-1 md:grid-cols-3 prose prose-xl max-w-full gap-6 prose-a:no-underline prose-h3:text-xl prose-h2:mt-0">
    @while($query->have_posts()) @php($query->the_post())
      @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
    @endwhile
  </div>

  @if ($pagination)
    {!! $pagination !!}
  @endif
</div>