<article @php(post_class('bg-white p-7 rounded-3xl shadow-lg mb-4'))>
    <header>
        <h2 class="entry-title text-2xl font-bold">
            <a class="no-underline hover:underline" href="{{ get_permalink() }}">
                {!! $title !!}
            </a>
        </h2>

        @include('partials.entry-meta')
    </header>

    @if (has_post_thumbnail())
        <a href="{{ get_permalink() }}" class="block aspect-video overflow-hidden">
            {!! get_the_post_thumbnail(get_the_ID(), 'medium_large', [
                'class' => 'w-full h-full object-cover transition-transform duration-300 hover:scale-105 rounded-xl hover:rounded-xl',
                'alt' => get_the_title(),
                'loading' => 'lazy',
            ]) !!}
        </a>
    @endif

    <div class="entry-summary text-base">
        @php(the_excerpt())
    </div>
</article>
