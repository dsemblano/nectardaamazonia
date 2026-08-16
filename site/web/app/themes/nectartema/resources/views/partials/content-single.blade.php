<div class="breadcrumb bg-footer">
  <div class="breadcrumb-inner h-28 max-w-xs md:max-w-4xl mx-auto px-7 pb-10 pt-4 text-xs md:text-base">
    {!! do_shortcode('[tsf_breadcrumb sep="⬢"]') !!}
    {{-- {!! do_shortcode('[tsf_breadcrumb sep="🐝"]') !!} --}}
  </div>
</div>
<div class="article-wrapper bg-white max-w-xs md:max-w-4xl mx-auto rounded-3xl p-7 relative bottom-8 md:bottom-14 shadow-lg">
    <article class="mx-auto prose lg:prose-lg prose-a:no-underline prose-h3:text-xl prose-h2:mt-0 prose-picture:mt-0 pt-0 md:pt-8"
        @php(post_class('h-entry'))>
        <header>
            <h1 class="p-name text-secondary">
                {!! $title !!}
            </h1>

            <p class="my-3 excerpt">
                {{ wp_trim_words(get_the_excerpt(), 40, '...') }}
            </p>

            @include('partials.entry-meta')
        </header>

        <hr class="h-0.5 my-4 bg-gray-400 border-0">

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

        @php(comments_template())
    </article>

</div>
