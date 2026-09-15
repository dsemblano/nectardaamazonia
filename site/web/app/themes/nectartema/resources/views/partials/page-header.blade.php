<div
    class="text-4xl md:text-6xl prose-h1:mt-8 page-header">
    <h1 class="{{ !is_woocommerce() && !is_cart() && !is_checkout() ? ' container' : '' }}">{!! $title !!}</h1>
</div>

@if (is_author())
    @php
        $author = get_queried_object();
    @endphp
    <section class="author container max-w-none prose lg:prose-lg">
        @if (!empty($author->description))
            <div class="author__bio">
                {!! wpautop(wp_kses_post($author->description)) !!}
            </div>
        @endif
    </section>
@endif
