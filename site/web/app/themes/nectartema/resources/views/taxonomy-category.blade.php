{{-- resources/views/taxonomy-category.blade.php --}}

@extends('layouts.app')

@section('content')

  <section class="prose mx-auto mb-10">
    <h1 class="text-4xl font-bold">
      {{ single_cat_title('', false) }}
    </h1>

    @if (category_description())
      <p class="text-lg text-gray-600">
        {!! category_description() !!}
      </p>
    @endif
  </section>

  <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 container mx-auto">
    @if ($posts->have_posts())
      @while ($posts->have_posts()) @php($posts->the_post())
        <article class="bg-white rounded-2xl shadow p-5 hover:shadow-lg transition">
          <a href="{{ get_permalink() }}" class="block">
            @if (has_post_thumbnail())
              <img 
                src="{{ get_the_post_thumbnail_url(null, 'medium_large') }}"
                alt="{{ get_the_title() }}"
                class="rounded-xl mb-4 w-full h-48 object-cover"
              >
            @endif

            <h2 class="text-xl font-semibold mb-2">
              {{ get_the_title() }}
            </h2>

            <p class="text-gray-600 mb-3">
              {{ get_the_excerpt() }}
            </p>

            <span class="text-blue-600 font-medium">Read more →</span>
          </a>
        </article>
      @endwhile
    @else
      <p class="prose mx-auto text-center">No posts found in this category.</p>
    @endif
  </section>

  <section class="mt-12 flex justify-center">
    {!! get_the_posts_pagination([
      'mid_size'  => 2,
      'prev_text' => '← Previous',
      'next_text' => 'Next →',
    ]) !!}
  </section>

@endsection
