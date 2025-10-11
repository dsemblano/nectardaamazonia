<section class="home-wrapper" id="hero-section">
    <div class="container flex flex-col lg:flex-row items-center gap-8 lg:gap-16 py-12 lg:py-24">
        {{-- <picture class="grow-0 shrink-1 w-full lg:w-3/5">

            <source srcset="{{ Vite::asset('resources/images/mobile-meliponario.webp') }}" media="(max-width: 767px)">
            <source srcset="{{ Vite::asset('resources/images/desktop-meliponario.webp') }}" media="(min-width: 768px)">
            <img src="{{ Vite::asset('resources/images/desktop-meliponario.webp') }}" alt="Meliponário" class="rounded-xl"> --}}
        </picture>
        <div class="hero-text grow-0 shrink-1 w-full lg:w-2/5 prose lg:prose-lg max-w-none prose-a:no-underline">
            <h1>Néctar da Amazônia</h1>
            <p>
                Na Néctar da Amazônia produzimos mel nativo e artesanal de abelhas sem ferrão no Estado do Amapá. Unimos
                meliponicultura, conservação e bioeconomia para gerar renda local, e transformar a produção do mel
                amazônico em impacto real.
            </p>
            <a href="/loja" class="btn btn-primary">Compre mel agora!</a>
        </div>
    </div>
</section>

<section id="quem-somos" class="bg-melescuro prose lg:prose-2xl max-w-none prose-a:no-underline prose-h2:text-white prose-p:text-white">
    <div class="container flex flex-col lg:flex-row items-center gap-8 lg:gap-16 py-12 lg:py-24">
        <div class="hero-text grow-0 shrink-1 w-full lg:w-3/5">
            <h2>Quem somos</h2>
            <p>
                Na Néctar da Amazônia, nosso objetivo vai além da produção de mel. Sob a liderança de Richardson Frazão,
                biólogo e CEO com 25 anos de experiência, desenvolvemos soluções sustentáveis, unindo meliponicultura e
                preservação ambiental, com foco nos ODS e diretrizes ESG.
            </p>
            <p>
                Francisco Junior, graduando em História e com experiência de 15 anos em projetos ambientais,
                supervisiona as operações diárias, garantindo que todas as atividades impactem positivamente o meio
                ambiente e as comunidades locais.
            </p>
            <p>
                Julio Avelar, graduando em Ciências Ambientais pela Universidade Federal do Amapá, técnico agropecuário
                em formação, presidente da cooperativa de apicultores do Amapá e membro da equipe Néctar da Amazônia.
            </p>
            <a href="/quem-somos">Mais sobre nós</a>
        </div>
        {{-- <picture class="grow-0 shrink-1 w-full lg:w-2/5">
            <img src="{{ Vite::asset('resources/images/home-Melipona-fulva-TIW-Expedicao-nov2023.webp') }}" alt="Melkiponário" class="rounded-xl">
        </picture> --}}
    </div>
</section>
