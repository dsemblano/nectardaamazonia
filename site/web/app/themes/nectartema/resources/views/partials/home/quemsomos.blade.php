<section id="quem-somos" class="section-home  container h-fit">
    <div class="flex flex-col lg:flex-row gap-8 lg:gap-16">
        <div class="hero-text grow-0 shrink-1 w-full lg:w-3/5">
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
            <img src="{{ Vite::asset('resources/images/rf.webp') }}"
                alt="Melkiponário" class="rounded-xl">
        </picture>
    </div>
</section>

@include('partials.hr')
