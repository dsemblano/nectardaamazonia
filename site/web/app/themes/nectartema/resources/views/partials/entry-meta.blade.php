<time class="dt-published" datetime="{{ get_post_time('c', true) }}">
  <div class="text-base leading-6 text-p">
      <span>Postado em {{ the_time('j F Y') }}<br></span>
      @if ( get_the_modified_time( 'U' ) > get_the_time( 'U' ) )
        <span>Atualizada em {{ the_modified_time('j F Y') }}</span>
      @endif
  </div>
</time>

{{-- <p>
  <span>{{ __('By', 'sage') }}</span>
  <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" class="p-author h-card">
    {{ get_the_author() }}
  </a>
</p> --}}
