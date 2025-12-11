@php
  $theme_uri = get_stylesheet_directory_uri(); // or get_template_directory_uri()
@endphp

<!-- Partytown forward configuration -->
<script>
  partytown = {
    lib: "{{ $theme_uri }}/public/~partytown/"
    forward: ['dataLayer.push']
  };
</script>

<script src="{{ $theme_uri }}/public/~partytown/partytown.js" async></script>

