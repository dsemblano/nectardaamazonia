<section id="servicos" class="section-home container gap-8 mt-8 mb-8 lg:mt-10">
    <h2 class="text-center font-bold mb-8">Serviços</h2>
    <div class="flex flex-col md:flex-row">
        <div class="servicos-info">
            <img width="188" height="215"
                src="{{ Vite::asset('resources/images/servicos/Icone-Consultoria-tecnica.webp') }}"
                alt="Ícone Consultoria para o Desenvolvimento da produção de mel" class="rounded-xl">
            <h3>Consultoria para o Desenvolvimento da produção de mel</h3>
            <p>Fazemos diagnósticos detalhados, elaboramos projetos e gerimos meliponários, garantindo o sucesso e a
                sustentabilidade na criação de abelhas e produção de mel.</p>
        </div>
        <div class="servicos-info">
            <img width="188" height="215"
                src="{{ Vite::asset('resources/images/servicos/icone-estudos-socioambientais.webp') }}"
                alt="Ícone Diagnósticos Socioambientais com Comunidades" class="rounded-xl">
            <h3>Diagnósticos Socioambientais
                com Comunidades</h3>
            <p>Apoiamos comunidades locais, incluindo quilombolas, na implementação de práticas de meliponicultura
                como
                estratégia de geração de renda e inclusão.</p>
        </div>
        <div class="servicos-info">
            <img width="188" height="215"
                src="{{ Vite::asset('resources/images/servicos/Icone-estudos-ambientais.webp') }}"
                alt="Ícone Implantação de Biofábricas de Abelhas" class="rounded-xl">
            <h3>Implantação de
                Biofábricas de Abelhas</h3>
            <p>Desenvolvemos soluções inovadoras para enfrentar o déficit global de polinizadores, com foco na
                preservação e expansão das abelhas nativas.</p>
        </div>
        <div class="servicos-info">
            <img width="188" height="215" src="{{ Vite::asset('resources/images/servicos/icone-eventos.webp') }}"
                alt="Ícone Eventos Sustentabilidade com Abelhas
" class="rounded-xl">
            <h3>Eventos
                Sustentabilidade
                com Abelhas </h3>
            <p>Facilitamos palestras, workshops e eventos educativos que destacam a importância das abelhas para o
                meio
                ambiente e a sociedade. Disseminamos conhecimento!</p>
        </div>
    </div>


</section>

@include('partials.hr')
