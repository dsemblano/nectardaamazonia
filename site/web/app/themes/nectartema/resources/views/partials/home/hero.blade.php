<section id="hero" class="section-home text-white container h-fit">
    <div class="py-16 text-left prose  prose-a:no-underline">
        <h1 class="text-white text-4xl md:text-6xl">Mel Sustentável da Amazônia</h1>
        <h2 class="text-white font-normal text-sm md:text-xl mb-10">Néctar da Amazônia: mel 100% puro de abelhas sem
            ferrão,
            artesanal, no Amapá e alinhado à bioeconomia e ao desenvolvimento sustentável.</h2>
        <a href="/loja"
            class="px-4 py-4 rounded-lg text-xl font-semibold transition bg-melescuro hover:bg-primary text-white">Compre
            mel agora!</a>
    </div>
</section>


<div id="o-time" class="max-w-5xl mx-auto px-4 py-12 flex flex-col items-center container">
  <h3 class="text-2xl md:text-3xl font-light text-center mb-10">O time</h3>

  <!-- ROW 1 (odd) -->
  <div class="flex justify-center gap-4 md:gap-6 mb-[-2.5rem]">
    <!-- Hex 1 -->
    <div class="w-40 md:w-48 flex justify-center">
      <div class="relative">
        <!-- your SVG (keep clipPath/image inside) -->
        <svg width="256" viewBox="0 0 31 29" xmlns="http://www.w3.org/2000/svg" class="block">
          <defs>
            <clipPath id="hexClip1" clipPathUnits="userSpaceOnUse">
              <path d="M9.00035 7.55536L2.02871 11.4285C1.39378 11.7812 1 12.4505 1 13.1768V21.8232C1 22.5495 1.39378 23.2188 2.02871 23.5715L9.00035 27.4446C9.61973 27.7887 10.3749 27.7794 10.9857 27.4202L17.514 23.58C18.1249 23.2206 18.5 22.5648 18.5 21.8561V13.1439C18.5 12.4352 18.1249 11.7794 17.514 11.42L10.9857 7.57981C10.375 7.22056 9.61973 7.21126 9.00035 7.55536Z" />
            </clipPath>
          </defs>

          <g transform="translate(6 -3)">
            <image href="{{ Vite::asset('resources/images/bee.webp') }}"
                   x="-4" y="-2" width="40" height="40"
                   preserveAspectRatio="xMidYMid meet"
                   clip-path="url(#hexClip1)" />
            <!-- optional strokes/overlays -->
            <path d="M10,12.5A5,5 0 0 1 10,22.5A5,5 0 0 1 10,12.5"
                  fill="none" stroke="#cab" stroke-dasharray="0 62.84" stroke-width="10" clip-path="url(#hexClip1)"/>
          </g>
        </svg>

        <div class="absolute inset-x-0 bottom-0 px-2 py-2 text-black text-xs uppercase text-center">
          Richardson Frazão
        </div>
      </div>
    </div>

    <!-- Hex 2 -->
    <div class="w-40 md:w-48 flex justify-center">
      <div class="relative">
        <svg width="256" viewBox="0 0 31 29" xmlns="http://www.w3.org/2000/svg" class="block">
          <defs>
            <clipPath id="hexClip2" clipPathUnits="userSpaceOnUse">
              <path d="M9.00035 7.55536L2.02871 11.4285C1.39378 11.7812 1 12.4505 1 13.1768V21.8232C1 22.5495 1.39378 23.2188 2.02871 23.5715L9.00035 27.4446C9.61973 27.7887 10.3749 27.7794 10.9857 27.4202L17.514 23.58C18.1249 23.2206 18.5 22.5648 18.5 21.8561V13.1439C18.5 12.4352 18.1249 11.7794 17.514 11.42L10.9857 7.57981C10.375 7.22056 9.61973 7.21126 9.00035 7.55536Z" />
            </clipPath>
          </defs>

          <g transform="translate(6 -3)">
            <image href="{{ Vite::asset('resources/images/bee.webp') }}"
                   x="-4" y="-2" width="40" height="40"
                   preserveAspectRatio="xMidYMid meet"
                   clip-path="url(#hexClip2)" />
            <path d="M10,12.5A5,5 0 0 1 10,22.5A5,5 0 0 1 10,12.5"
                  fill="none" stroke="#cab" stroke-dasharray="0 62.84" stroke-width="10" clip-path="url(#hexClip2)"/>
          </g>
        </svg>

        <div class="absolute inset-x-0 bottom-0 px-2 py-2 text-black text-xs uppercase text-center">
          Ana Laura Frazão
        </div>
      </div>
    </div>

    <!-- Hex 3 (hidden on mobile to keep 2-per-row) -->
    <div class="w-40 md:w-48 hidden md:flex justify-center">
      <div class="relative">
        <svg width="256" viewBox="0 0 31 29" xmlns="http://www.w3.org/2000/svg" class="block">
          <defs>
            <clipPath id="hexClip3" clipPathUnits="userSpaceOnUse">
              <path d="M9.00035 7.55536L2.02871 11.4285C1.39378 11.7812 1 12.4505 1 13.1768V21.8232C1 22.5495 1.39378 23.2188 2.02871 23.5715L9.00035 27.4446C9.61973 27.7887 10.3749 27.7794 10.9857 27.4202L17.514 23.58C18.1249 23.2206 18.5 22.5648 18.5 21.8561V13.1439C18.5 12.4352 18.1249 11.7794 17.514 11.42L10.9857 7.57981C10.375 7.22056 9.61973 7.21126 9.00035 7.55536Z" />
            </clipPath>
          </defs>

          <g transform="translate(6 -3)">
            <image href="{{ Vite::asset('resources/images/bee.webp') }}"
                   x="-4" y="-2" width="40" height="40"
                   preserveAspectRatio="xMidYMid meet"
                   clip-path="url(#hexClip3)" />
            <path d="M10,12.5A5,5 0 0 1 10,22.5A5,5 0 0 1 10,12.5"
                  fill="none" stroke="#cab" stroke-dasharray="0 62.84" stroke-width="10" clip-path="url(#hexClip3)"/>
          </g>
        </svg>

        <div class="absolute inset-x-0 bottom-0 px-2 py-2 text-black text-xs uppercase text-center">
          Francisco Junior
        </div>
      </div>
    </div>
  </div>

  <!-- ROW 2 (even / offset) -->
  <!-- note: md:translate-x-[24px] creates the half-step offset on desktop; tweak this value if you change w-* classes -->
  <div class="flex justify-center gap-4 md:gap-6 md:translate-x-[24px] mb-[-2.5rem]">
    <div class="w-40 md:w-48 flex justify-center">
      <div class="relative">
        <svg width="256" viewBox="0 0 31 29" xmlns="http://www.w3.org/2000/svg" class="block">
          <defs>
            <clipPath id="hexClip4" clipPathUnits="userSpaceOnUse">
              <path d="M9.00035 7.55536L2.02871 11.4285C1.39378 11.7812 1 12.4505 1 13.1768V21.8232C1 22.5495 1.39378 23.2188 2.02871 23.5715L9.00035 27.4446C9.61973 27.7887 10.3749 27.7794 10.9857 27.4202L17.514 23.58C18.1249 23.2206 18.5 22.5648 18.5 21.8561V13.1439C18.5 12.4352 18.1249 11.7794 17.514 11.42L10.9857 7.57981C10.375 7.22056 9.61973 7.21126 9.00035 7.55536Z" />
            </clipPath>
          </defs>

          <g transform="translate(6 -3)">
            <image href="{{ Vite::asset('resources/images/bee.webp') }}"
                   x="-4" y="-2" width="40" height="40"
                   preserveAspectRatio="xMidYMid meet"
                   clip-path="url(#hexClip4)" />
            <path d="M10,12.5A5,5 0 0 1 10,22.5A5,5 0 0 1 10,12.5"
                  fill="none" stroke="#cab" stroke-dasharray="0 62.84" stroke-width="10" clip-path="url(#hexClip4)"/>
          </g>
        </svg>

        <div class="absolute inset-x-0 bottom-0 px-2 py-2 text-black text-xs uppercase text-center">
          Júlio Avelar
        </div>
      </div>
    </div>

    <div class="w-40 md:w-48 flex justify-center">
      <div class="relative">
        <svg width="256" viewBox="0 0 31 29" xmlns="http://www.w3.org/2000/svg" class="block">
          <defs>
            <clipPath id="hexClip5" clipPathUnits="userSpaceOnUse">
              <path d="M9.00035 7.55536L2.02871 11.4285C1.39378 11.7812 1 12.4505 1 13.1768V21.8232C1 22.5495 1.39378 23.2188 2.02871 23.5715L9.00035 27.4446C9.61973 27.7887 10.3749 27.7794 10.9857 27.4202L17.514 23.58C18.1249 23.2206 18.5 22.5648 18.5 21.8561V13.1439C18.5 12.4352 18.1249 11.7794 17.514 11.42L10.9857 7.57981C10.375 7.22056 9.61973 7.21126 9.00035 7.55536Z" />
            </clipPath>
          </defs>

          <g transform="translate(6 -3)">
            <image href="{{ Vite::asset('resources/images/bee.webp') }}"
                   x="-4" y="-2" width="40" height="40"
                   preserveAspectRatio="xMidYMid meet"
                   clip-path="url(#hexClip5)" />
            <path d="M10,12.5A5,5 0 0 1 10,22.5A5,5 0 0 1 10,12.5"
                  fill="none" stroke="#cab" stroke-dasharray="0 62.84" stroke-width="10" clip-path="url(#hexClip5)"/>
          </g>
        </svg>

        <div class="absolute inset-x-0 bottom-0 px-2 py-2 text-black text-xs uppercase text-center">
          Arnaldo Francisco
        </div>
      </div>
    </div>

    <!-- hidden on mobile -->
    <div class="w-40 md:w-48 hidden md:flex justify-center">
      <div class="relative">
        <svg width="256" viewBox="0 0 31 29" xmlns="http://www.w3.org/2000/svg" class="block">
          <defs>
            <clipPath id="hexClip6" clipPathUnits="userSpaceOnUse">
              <path d="M9.00035 7.55536L2.02871 11.4285C1.39378 11.7812 1 12.4505 1 13.1768V21.8232C1 22.5495 1.39378 23.2188 2.02871 23.5715L9.00035 27.4446C9.61973 27.7887 10.3749 27.7794 10.9857 27.4202L17.514 23.58C18.1249 23.2206 18.5 22.5648 18.5 21.8561V13.1439C18.5 12.4352 18.1249 11.7794 17.514 11.42L10.9857 7.57981C10.375 7.22056 9.61973 7.21126 9.00035 7.55536Z" />
            </clipPath>
          </defs>

          <g transform="translate(6 -3)">
            <image href="{{ Vite::asset('resources/images/bee.webp') }}"
                   x="-4" y="-2" width="40" height="40"
                   preserveAspectRatio="xMidYMid meet"
                   clip-path="url(#hexClip6)" />
            <path d="M10,12.5A5,5 0 0 1 10,22.5A5,5 0 0 1 10,12.5"
                  fill="none" stroke="#cab" stroke-dasharray="0 62.84" stroke-width="10" clip-path="url(#hexClip6)"/>
          </g>
        </svg>

        <div class="absolute inset-x-0 bottom-0 px-2 py-2 text-black text-xs uppercase text-center">
          Daniel Semblano
        </div>
      </div>
    </div>
  </div>
</div>
