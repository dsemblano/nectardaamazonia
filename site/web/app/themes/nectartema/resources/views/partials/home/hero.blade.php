<section id="hero" class="section-home text-white relative overflow-hidden">
<picture class="hero-bg-img" class="w-full h-full block">
    <!-- 1. Mobile devices (under 576px) -->
    <source media="(max-width: 576px)" srcset="{{ Vite::asset('resources/images/meliponarios-mobile.avif') }}" type="image/avif">
    <source media="(max-width: 576px)" srcset="{{ Vite::asset('resources/images/meliponarios-mobile.webp') }}" type="image/webp">
    
    <!-- 2. Desktop/Tablet devices -->
    <source srcset="{{ Vite::asset('resources/images/meliponarios.avif') }}" type="image/avif">
    <source srcset="{{ Vite::asset('resources/images/meliponarios.webp') }}" type="image/webp">
    
    <!-- 3. Native fallback (This is where your layout classes MUST sit) -->
    <img id="hero-img" 
         src="{{ Vite::asset('resources/images/meliponarios.webp') }}" 
         data-opt-lazy-loaded="false"
         fetchpriority="high"
         class="hero-bg-img no-lazy w-full object-cover optml-skip"
         alt="Logo Néctar da Amazônia">
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
                <a href="/loja" class="hero-cta w-fit">Garantir meu Mel Puro 🍯 </a>
                <a href="/orcamento-instalacao-de-meliponarios" class="hero-colmeia w-fit">Ter meu Meliponário 🏡🐝</a>
            </div>
        </div>
    </div>
</section>
