@extends('layouts.app')

@section('content')
  @if (! is_front_page() && ! is_home() )
    @include('partials.page-header')
  @endif

  @if (! have_posts())
    <x-alert type="warning">
      {!! __('Sorry, no results were found.', 'sage') !!}
    </x-alert>

    {!! get_search_form(false) !!}
  @endif
  
  <div class="container grid grid-cols-2 md:grid-cols-3 prose prose-xl max-w-full gap-6 prose-a:no-underline prose-h3:text-xl prose-h2:mt-0 prose-picture:mt-0">
  @while(have_posts()) @php(the_post())
    @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
  @endwhile
  </div>

  {!! get_the_posts_navigation() !!}
@endsection

@section('sidebar')
  @include('sections.sidebar')
@endsection
