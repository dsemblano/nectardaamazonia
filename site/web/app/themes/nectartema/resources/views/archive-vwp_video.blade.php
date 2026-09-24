@extends('layouts.app')

@section('content')

  <div class="container mx-auto px-4 py-12">

    <header class="mb-10">
      <h1 class="text-4xl font-bold">
        Vídeos
      </h1>

      <p class="mt-3 max-w-2xl text-lg text-gray-600">
        Página dedicada aos vídeos da Néctar da Amazônia onde estão nas matérias. Notícias, entrevistas e conteúdos sobre abelhas nativas,
        meliponicultura e sustentabilidade na Amazônia.
      </p>
    </header>

    @if (have_posts())

      <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">

        @while (have_posts())

          @php(the_post())

          @php($video_id = get_the_ID())
          @php($thumbnail = get_post_meta($video_id, '_vwp_thumbnail_url', true))
          @php($description = get_post_meta($video_id, '_vwp_description', true))

          @if (!$thumbnail)
            @php($thumbnail = get_the_post_thumbnail_url($video_id, 'large'))
          @endif

          @if (!$description)
            @php($description = get_the_excerpt())
          @endif

          <article class="group overflow-hidden p-7 rounded-3xl shadow-lg mb-4  bg-white ring-1 ring-gray-200">

            <a
              href="{{ get_permalink() }}"
              class="block"
            >

              @if ($thumbnail)

                <div class="aspect-video overflow-hidden bg-gray-100">

                  <img
                    src="{{ esc_url($thumbnail) }}"
                    alt="{{ esc_attr(get_the_title()) }}"
                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                    loading="lazy"
                  >

                </div>

              @else

                <div class="flex aspect-video items-center justify-center bg-gray-100">
                  <span class="text-gray-500">
                    Vídeo
                  </span>
                </div>

              @endif

            </a>

            <div class="p-6">

              <p class="mb-2 text-sm text-gray-500">
                {{ get_the_date() }}
              </p>

              <h2 class="text-xl font-semibold leading-tight">
                <a
                  href="{{ get_permalink() }}"
                  class="hover:underline"
                >
                  {{ get_the_title() }}
                </a>
              </h2>

              @if ($description)

                <p class="mt-3 text-gray-600">
                  {{ wp_trim_words(wp_strip_all_tags($description), 25, '…') }}
                </p>

              @endif

              <a
                href="{{ get_permalink() }}"
                class="mt-5 inline-flex items-center font-semibold"
              >
                Assistir vídeo
                <span class="ml-2" aria-hidden="true">→</span>
              </a>

            </div>

          </article>

        @endwhile

      </div>

      <div class="mt-12">
        {!! paginate_links([
          'type'      => 'list',
          'prev_text' => '← Anterior',
          'next_text' => 'Próxima →',
        ]) !!}
      </div>

    @else

      <p>Nenhum vídeo encontrado.</p>

    @endif

  </div>

@endsection