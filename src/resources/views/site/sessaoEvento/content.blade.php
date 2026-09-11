<main class="experience-main event-page">

    {{-- ================================================================
    1. HERO INTERNO — O EVENTO
    Dados dinâmicos: $evento
    ================================================================= --}}
    <section class="event-hero" @if(!empty($evento?->banner_evento))
    style="background-image: url('{{ asset('conexao360/img/' . $evento->banner_evento) }}')" @endif>
        <div class="event-hero-overlay"></div>

        <div class="experience-shell event-hero-shell">
            <div class="event-hero-copy">
                <p class="experience-eyebrow">Conexão 360º</p>

                <h1>
                    Mais que um evento.
                    <span>Um movimento para uma advocacia que evolui.</span>
                </h1>

                <p>
                    Conhecimento, posicionamento, conexões e experiências que provocam
                    novas ideias e ampliam possibilidades dentro da advocacia.
                </p>

                @if($evento)
                    <div class="event-hero-meta">
                        <div>
                            <span>Data</span>
                            <strong>{{ $evento->data_formatada ?? $evento->data_inicial_evento }}</strong>
                        </div>

                        <div>
                            <span>Local</span>
                            <strong>{{ $evento->endereco_evento }}</strong>
                        </div>
                    </div>
                @endif

                <div class="event-hero-actions">
                    <a href="#essencia" class="experience-primary-button">
                        Conheça o evento
                    </a>

                    <a href="#participar" class="event-secondary-button">
                        Quero participar
                    </a>
                </div>
            </div>
        </div>
    </section>


    {{-- ================================================================
    2. ESSÊNCIA / COMO NASCEU
    ================================================================= --}}
    <section class="event-origin event-section" id="essencia">
        <div class="experience-shell">

            <div class="event-section-heading">
                <div>
                    <p class="experience-eyebrow">A origem</p>
                    <h2>Uma ideia que nasceu para provocar movimento.</h2>
                </div>

                <p>
                    O Conexão 360 foi criado para reunir profissionais em torno de uma
                    experiência que une conhecimento, relacionamento e visão estratégica.
                </p>
            </div>

            <div class="event-origin-grid">

                <div class="event-origin-copy">
                    <p>
                        A proposta é simples: sair do formato passivo de evento e criar um
                        ambiente onde conteúdo, prática e conexões aconteçam ao mesmo tempo.
                    </p>

                    <p>
                        O objetivo não é apenas entregar informação, mas gerar repertório,
                        novas perspectivas e relações que possam continuar depois do encontro.
                    </p>

                    <div class="event-origin-quote">
                        <span>“</span>
                        <p>
                            Mais que assistir. Viver, conectar e transformar.
                        </p>
                    </div>
                </div>

                <div class="event-origin-image">
                    @if(!empty($dra?->foto_dra))
                        <img src="{{ asset('conexao360/img/' . $dra->foto_dra) }}"
                            alt="{{ $dra->titulo_dra ?? 'Idealizadora do Conexão 360' }}" loading="lazy" decoding="async">
                    @else
                        <div class="event-origin-image-fallback">
                            <i class="bi bi-stars"></i>
                        </div>
                    @endif

                    <div class="event-origin-caption">
                        <span>Idealização</span>
                        <strong>{{ $dra->titulo_dra ?? 'Conexão 360º' }}</strong>
                    </div>
                </div>

            </div>
        </div>
    </section>


    {{-- ================================================================
    3. PILARES
    ================================================================= --}}
    <section class="event-pillars event-section">
        <div class="experience-shell">

            <div class="event-section-heading event-section-heading--light">
                <div>
                    <p class="experience-eyebrow">Por que o Conexão 360 existe</p>
                    <h2>Quatro pilares. Uma experiência completa.</h2>
                </div>

                <p>
                    Cada parte do evento foi pensada para gerar valor antes, durante
                    e depois do encontro.
                </p>
            </div>

            <div class="event-pillars-grid">

                <article class="event-pillar-card">
                    <span>01</span>
                    <i class="bi bi-lightbulb"></i>
                    <h3>Conhecimento</h3>
                    <p>Conteúdo aplicável, repertório e novas formas de enxergar a advocacia.</p>
                </article>

                <article class="event-pillar-card">
                    <span>02</span>
                    <i class="bi bi-people"></i>
                    <h3>Conexões</h3>
                    <p>Relacionamentos profissionais que podem continuar muito além do evento.</p>
                </article>

                <article class="event-pillar-card">
                    <span>03</span>
                    <i class="bi bi-bullseye"></i>
                    <h3>Posicionamento</h3>
                    <p>Estratégia, visão de carreira e construção de autoridade profissional.</p>
                </article>

                <article class="event-pillar-card">
                    <span>04</span>
                    <i class="bi bi-graph-up-arrow"></i>
                    <h3>Oportunidades</h3>
                    <p>Novas ideias, parcerias e possibilidades a partir de pessoas e experiências.</p>
                </article>

            </div>
        </div>
    </section>


    {{-- ================================================================
    4. PARA QUEM É
    ================================================================= --}}
    <section class="event-audience event-section">
        <div class="experience-shell event-audience-grid">

            <div class="event-audience-copy">
                <p class="experience-eyebrow">Para quem é</p>

                <h2>
                    Para quem quer construir
                    uma advocacia com mais direção.
                </h2>

                <p>
                    O Conexão 360 é para profissionais que desejam ampliar repertório,
                    fortalecer posicionamento e criar novas conexões dentro do mercado jurídico.
                </p>
            </div>

            <div class="event-audience-list">
                <article>
                    <span>01</span>
                    <p>Advogados que querem sair do operacional e pensar estrategicamente.</p>
                </article>

                <article>
                    <span>02</span>
                    <p>Profissionais que buscam networking qualificado e novas oportunidades.</p>
                </article>

                <article>
                    <span>03</span>
                    <p>Quem quer acompanhar mudanças de mercado, tecnologia e comportamento.</p>
                </article>

                <article>
                    <span>04</span>
                    <p>Quem entende que carreira também é posicionamento, relacionamento e visão.</p>
                </article>
            </div>

        </div>
    </section>


    {{-- ================================================================
    5. DIFERENCIAL / EXPERIÊNCIA
    ================================================================= --}}
    <section class="event-difference event-section">
        <div class="experience-shell">

            <div class="event-section-heading event-section-heading--light">
                <div>
                    <p class="experience-eyebrow">O que torna diferente</p>
                    <h2>Não é só sentar, assistir e ir embora.</h2>
                </div>

                <p>
                    O Conexão 360 foi pensado como experiência: palco, pessoas,
                    troca, conteúdo e continuidade.
                </p>
            </div>

            <div class="event-difference-flow">
                <div>
                    <i class="bi bi-mic"></i>
                    <strong>Palco</strong>
                    <span>Conteúdo que provoca</span>
                </div>

                <b>+</b>

                <div>
                    <i class="bi bi-people"></i>
                    <strong>Networking</strong>
                    <span>Conexões reais</span>
                </div>

                <b>+</b>

                <div>
                    <i class="bi bi-stars"></i>
                    <strong>Experiência</strong>
                    <span>Momentos que marcam</span>
                </div>

                <b>+</b>

                <div>
                    <i class="bi bi-phone"></i>
                    <strong>Comunidade</strong>
                    <span>Continuidade digital</span>
                </div>
            </div>

        </div>
    </section>


    {{-- ================================================================
    6. ANTES / DURANTE / DEPOIS
    ================================================================= --}}
    <section class="event-journey event-section">
        <div class="experience-shell">

            <div class="event-section-heading">
                <div>
                    <p class="experience-eyebrow">Uma jornada completa</p>
                    <h2>Antes, durante e depois.</h2>
                </div>

                <p>
                    O evento é o ponto de encontro. A experiência começa antes
                    e pode continuar muito depois dele.
                </p>
            </div>

            <div class="event-journey-grid">

                <article>
                    <span>Antes</span>
                    <h3>Prepare-se</h3>
                    <p>
                        Conheça palestrantes, acompanhe novidades e descubra o que
                        você vai viver no Conexão 360.
                    </p>
                </article>

                <article class="event-journey-featured">
                    <span>Durante</span>
                    <h3>Viva</h3>
                    <p>
                        Conteúdo, networking, experiências e contato direto com
                        profissionais que estão construindo novos caminhos.
                    </p>
                </article>

                <article>
                    <span>Depois</span>
                    <h3>Continue</h3>
                    <p>
                        A comunidade mantém pessoas, conteúdos, fotos, vídeos e
                        novas oportunidades conectadas.
                    </p>
                </article>

            </div>
        </div>
    </section>


    {{-- ================================================================
    7. CONEXÕES COM O RESTANTE DO SITE
    ================================================================= --}}
    <section class="event-explore event-section">
        <div class="experience-shell">

            <div class="event-section-heading event-section-heading--light">
                <div>
                    <p class="experience-eyebrow">Explore o Conexão 360</p>
                    <h2>Conheça cada parte da experiência.</h2>
                </div>
            </div>

            <div class="event-explore-grid">

                <a href="{{ route('page-palestrantes') }}" class="event-explore-card">
                    <i class="bi bi-person-video3"></i>
                    <span>Palestrantes</span>
                    <strong>Grandes nomes. Grandes ideias.</strong>
                    <b>Conhecer →</b>
                </a>

                <a href="{{ route('page-app') }}" class="event-explore-card">
                    <i class="bi bi-phone"></i>
                    <span>Comunidade</span>
                    <strong>O evento termina. As conexões continuam.</strong>
                    <b>Conhecer →</b>
                </a>

                <a href="{{ route('page-noticias') }}" class="event-explore-card">
                    <i class="bi bi-newspaper"></i>
                    <span>Conexão Jurídica</span>
                    <strong>Informação para uma advocacia que evolui.</strong>
                    <b>Conhecer →</b>
                </a>

            </div>

        </div>
    </section>


    {{-- ================================================================
    8. EVENTO ATUAL / CTA
    ================================================================= --}}
    <section class="event-current" id="participar">
        <div class="event-current-glow"></div>

        <div class="experience-shell event-current-shell">
            <p class="experience-eyebrow">Próxima experiência</p>

            <h2>
                Faça parte do
                <span>Conexão 360.</span>
            </h2>

            @if($evento)
                <div class="event-current-meta">
                    <div>
                        <span>Evento</span>
                        <strong>{{ $evento->titulo_evento ?? 'Conexão 360º' }}</strong>
                    </div>

                    <div>
                        <span>Data</span>
                        <strong>{{ $evento->data_formatada ?? $evento->data_inicial_evento }}</strong>
                    </div>

                    <div>
                        <span>Local</span>
                        <strong>{{ $evento->endereco_evento }}</strong>
                    </div>
                </div>
            @endif

            <a href="{{ $evento->url_evento ?? url('/#ingressos') }}" class="experience-primary-button"
                @if(!empty($evento?->url_evento)) target="_blank" rel="noopener noreferrer" @endif>
                Quero participar
            </a>
        </div>
    </section>

</main>