<section id="quem-somos" class="section-home">
    <div class="container flex flex-col lg:flex-row items-center gap-8 lg:gap-16 py-12 lg:py-24">
        <div class="hero-text grow-0 shrink-1 w-full lg:w-3/5 prose lg:prose-2xl max-w-none prose-a:no-underline">
            <h2 class="text-verde">Quem somos</h2>
            <p class="text-verde">
                Na Néctar da Amazônia, nosso objetivo vai além da produção de mel. Sob a liderança de Richardson Frazão,
                biólogo e CEO com 25 anos de experiência, desenvolvemos soluções sustentáveis, unindo meliponicultura e
                preservação ambiental, com foco nos ODS e diretrizes ESG.
            </p>
            <a class="px-4 py-4 rounded-lg text-xl font-semibold transition bg-melescuro hover:bg-primary text-white"
                href="/quem-somos">Mais sobre nós</a>
        </div>
        <picture class="grow-0 shrink-1 w-full lg:w-2/5">
            <img src="{{ Vite::asset('resources/images/home-Melipona-fulva-TIW-Expedicao-nov2023.webp') }}"
                alt="Melkiponário" class="rounded-xl">
        </picture>
    </div>
</section>

@include('partials.hr')
