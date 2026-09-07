<section id="hero" class="section-home text-white relative overflow-hidden">
    <picture id="hero-bg-img" class="hero-bg-img" class="w-full h-full block">
        <!-- 1. Mobile devices (under 576px) -->
        <source media="(max-width: 576px)" srcset="{{ Vite::asset('resources/images/loja.avif') }}"
            type="image/avif">
        <source media="(max-width: 576px)" srcset="{{ Vite::asset('resources/images/loja.webp') }}"
            type="image/webp">

        <!-- 2. Desktop/Tablet devices -->
        <source srcset="{{ Vite::asset('resources/images/loja.avif') }}" type="image/avif">
        <source srcset="{{ Vite::asset('resources/images/loja.webp') }}" type="image/webp">

        <!-- 3. Native fallback (This is where your layout classes MUST sit) -->
        <img src="{{ Vite::asset('resources/images/loja.webp') }}" data-opt-lazy-loaded="false"
            fetchpriority="high" class="hero-bg-img no-lazy w-full object-cover optml-skip"
            alt="">
    </picture>
    <div class="hero-bg-overlay"></div>

    <div class="container h-dvh relative z-10">
        <div
            class="prose lg:prose-lg prose-a:no-underline text-left h-dvh md:w-dvh md:h-full leading-loose flex flex-col justify-center pb-16">
            <p class="hero_eyebrow text-mel font-bold not-prose mb-2">Néctar da Amazônia</p>
            <h1 class="text-white text-3xl md:text-4xl lg:text-5xl">O sabor da floresta em cada gota.</h1>
            <p class="hero_description text-white font-normal text-xl md:text-3xl mb-10">
                Mel autêntico de abelhas sem ferrão da Amazônia para uma experiência única de sabor e natureza.
            </p>
            <div class="flex flex-col md:flex-row gap-4">
                <a href="/loja" class="hero-cta w-fit">Explore nossos méis 🍯</a>
                <a href="/orcamento-instalacao-de-meliponarios" class="hero-colmeia w-fit">Quero meu Meliponário 🏡🐝</a>
            </div>
        </div>
    </div>
</section>
