<section id="hero" class="section-home text-white relative overflow-hidden">

    {{-- <img id="hero-img"
        src="{{ Vite::asset('resources/images/meliponarios.webp') }}"
        fetchpriority="high" 
        class="hero-bg-img no-lazy" 
        alt="Meliponários da Amazônia"
    > --}}

    <img id="hero-img" 
     src="{{ Vite::asset('resources/images/meliponarios.webp') }}"
     srcset="{{ Vite::asset('resources/images/meliponarios-mobile.webp') }} 324w, {{ Vite::asset('resources/images/meliponarios.webp') }} 1920w"
     sizes="(max-width: 576px) 100vw, 100vw"
     fetchpriority="high" 
     class="hero-bg-img no-lazy" 
     alt="Logo Néctar da Amazônia">

    <picture class="hero-bg-img no-lazy">
        <source srcset="{{ Vite::asset('resources/images/meliponar.avif') }}" type="image/avif">
        <source srcset="{{ Vite::asset('resources/images/meliponar.webp') }}" type="image/webp">
        <img id="hero-img" src="{{ Vite::asset('resources/images/meliponar.webp') }}" fetchpriority="high"
            alt="Meliponários da Amazônia">
    </picture>

    <div class="hero-bg-overlay"></div>

    <div class="container h-dvh relative z-10">
        <div
            class="prose lg:prose-lg prose-a:no-underline text-left h-dvh md:w-dvh md:h-full leading-loose flex flex-col justify-center">
            <h1 class="text-white text-4xl md:text-6xl lg:text-7xl">Mel Sustentável da Amazônia</h1>
            <p class="text-white font-normal text-2xl md:text-3xl mb-10">
                Néctar da Amazônia: O mais puro mel de abelhas sem ferrão,
                <span class="ticker-container block md:inline-block text-mel">
                    <span class="ticker-wrapper text-mel">
                        <span class="item">rico em antioxidantes</span>
                        <span class="item">do Amapá para o mundo</span>
                        <span class="item">fortalecendo a bioeconomia</span>
                        <span class="item">rico em antioxidantes</span>
                    </span>
                </span>
            </p>
            <div class="flex flex-col md:flex-row gap-4">
                <a href="/loja" class="hero-cta w-fit">Garantir meu Mel Puro</a>
                <a href="/orcamento-instalacao-de-meliponarios" class="hero-colmeia w-fit">Orçamento meliponários</a>
            </div>
        </div>
    </div>
</section>
