@php
  $glyphs = ['❄', '❅', '❆'];
@endphp

<div class="snowfall" aria-hidden="true">
  @for ($i = 0; $i < 40; $i++)
    @php
      $duration = random_int(8, 20);
      $delay = random_int(0, $duration);
    @endphp

    <span
      class="snowfall__flake"
      style="
        --left: {{ random_int(0, 100) }}%;
        --size: {{ random_int(10, 20) }}px;
        --duration: {{ $duration }}s;
        --delay: -{{ $delay }}s;
        --drift: {{ random_int(-80, 80) }}px;
      "
    >{{ $glyphs[array_rand($glyphs)] }}</span>
  @endfor
</div>