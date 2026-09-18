<div class="text-4xl md:text-6xl prose-h1:mt-8 page-header">
    <h1 class="{{ !is_woocommerce() && !is_cart() && !is_checkout() ? ' container' : '' }}">{!! $title !!}</h1>
</div>

@if (is_author())
    <section class="author container max-w-none prose lg:prose-lg mt-6">
        <div class="author__bio">
            {{ get_the_author_meta('description') }}
        </div>
    </section>
    {{-- {!! do_shortcode('[tsf_breadcrumb sep="⬢"]') !!} --}}

@endif
