<article @php(post_class('bg-white p-7 rounded-3xl shadow-lg mb-4'))>
    <header>
        <h2 class="entry-title">
            <a class="no-underline hover:underline" href="{{ get_permalink() }}">
                {!! $title !!}
            </a>
        </h2>

        @include('partials.entry-meta')
    </header>

    <div class="entry-summary">
        @php(the_excerpt())
    </div>
</article>
