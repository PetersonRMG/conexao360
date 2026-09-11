<main class="experience-main">

    {{-- ================================================================
    1. HERO — CARROSSEL DINÂMICO
    Exibe no máximo 3 banners ativos cadastrados no dashboard.
    ================================================================= --}}
    <section id="inicio" class="experience-hero-stage" aria-label="Destaques do Conexão 360">
        <div class="experience-hero-carousel" id="heroCarousel">
            @foreach ($hero->take(3) as $item)
                <article class="header-advocacia experience-hero experience-hero-slide"
                    style="background-image: url('{{ asset('conexao360/img/' . $item->foto_banner) }}')">

                    <div class="experience-hero-overlay"></div>

                    <div class="experience-shell experience-hero-shell">

                        <div class="tds-header experience-hero-content">
                            <p class="tit-header experience-eyebrow">
                                {{ $item->tagline_hero }}
                            </p>

                            <h1 class="sub-tit experience-hero-title">
                                {{ $item->titulo_hero }}
                            </h1>

                            <p class="descricao-header experience-hero-description">
                                {{ $item->subtitulo_hero }}
                            </p>

                            <div class="experience-event-meta">
                                <div class="experience-meta-item">
                                    <img src="{{ asset('conexao360/img/icones_adv (8).svg') }}" alt="" aria-hidden="true">
                                    <div>
                                        <span>Data e Horário</span>
                                        <strong>{{ $evento->data_formatada }}</strong>
                                    </div>
                                </div>

                                <div class="experience-meta-item">
                                    <img src="{{ asset('conexao360/img/icones_adv (9).svg') }}" alt="" aria-hidden="true">
                                    <div>
                                        <span>Localização Evento</span>
                                        <strong>{{ $evento->endereco_evento }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="experience-hero-actions">
                                <a href="{{ $item->link_botao_hero }}"
                                    class="cta-header experience-primary-button"
                                    target="_blank"
                                    rel="noopener noreferrer">
                                    {{ $item->texto_botao_hero }}
                                </a>

                                <a href="#mente-criativa" class="experience-secondary-button">
                                    Conheça o evento
                                </a>
                            </div>
                        </div>

                        <aside class="experience-hero-signature" aria-label="Conceito do Conexão 360">
                            <p>
                                Mais que um evento.<br>
                                <em>É um movimento.</em>
                            </p>

                            <span class="experience-signature-line"></span>

                            <div class="experience-signature-brand">
                                <strong>CONEXÃO 360°</strong>
                                <small>PESSOAS</small>
                                <small>IDEIAS</small>
                                <small>RESULTADOS</small>
                            </div>
                        </aside>

                    </div>
                </article>
            @endforeach
        </div>
    </section>


    {{-- ================================================================
    2. DRA. — A MENTE CRIATIVA
    Mantém os dados dinâmicos já existentes e aumenta o respiro vertical.
    ================================================================= --}}
    <section id="mente-criativa" class="sobre experience-speakers experience-section-spaced">
        <div class="experience-shell">
            <div class="experience-section-heading experience-section-heading--dark">
                <p class="experience-eyebrow">Idealizadora do Conexão 360°</p>
                <h2 class="titulo">A Mente Criativa por Trás do Conexão 360°</h2>
            </div>

            <div class="experience-speaker-grid">
                @foreach ($dra as $item)
                    <article class="sobre-tds experience-speaker-card">
                        <div class="ajst-img experience-speaker-image">
                            <img src="{{ asset('conexao360/img/' . $item->foto_dra) }}"
                                alt="{{ $item->titulo_dra }}"
                                loading="lazy"
                                decoding="async">
                        </div>

                        <div class="sobre-info experience-speaker-info">
                            <p class="experience-eyebrow">A mente que provoca mudança</p>
                            <h3>{{ $item->titulo_dra }}</h3>
                            <h4>{{ $item->sub_titulo_dra }}</h4>
                            <p>{{ $item->descricao_dra }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>


    {{-- ================================================================
    3. TEMAS / O QUE SERÁ ATIVADO
    Mantido visualmente, com novo padrão de espaçamento entre seções.
    ================================================================= --}}
    <section class="abordagem experience-topics experience-section-spaced">
        <div class="experience-shell">
            <div class="experience-section-heading experience-section-heading--light">
                <p class="experience-eyebrow">Conexão 360º</p>
                <h2 class="title">O que você vai ativar no Conexão 360°</h2>
                <h3 class="sub-title">( Não é conteúdo. É virada de chave )</h3>
            </div>

            <div class="experience-topic-grid">
                @foreach ($temas as $item)
                    <article class="experience-topic-card" id="tema-{{ $item->id_tema }}">
                        <div class="experience-topic-image">
                            <img src="{{ asset('conexao360/img/' . $item->foto_tema) }}"
                                alt="{{ $item->titulo_tema }}"
                                loading="lazy"
                                decoding="async">
                        </div>

                        <div class="experience-topic-content">
                            <span class="experience-topic-number">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </span>

                            <h3>{{ $item->titulo_tema }}</h3>
                            <h4>{{ $item->subtitulo_tema }}</h4>
                            <p>{{ $item->breve_descricao_tema }}.</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>


    {{-- ================================================================
    4. PALESTRANTES EM DESTAQUE
    Dados dinâmicos: $palestrantes (tbl_usuarios / perfil palestrante).
    ================================================================= --}}
    @if ($palestrantes->isNotEmpty())
        <section id="palestrantes" class="experience-featured-speakers experience-section-spaced">
            <div class="experience-shell">

                <div class="experience-featured-speakers-heading">
                    <div>
                        <p class="experience-eyebrow">Palestrantes em destaque</p>
                        <h2>Grandes nomes. Grandes ideias.</h2>
                    </div>

                    <a href="{{ route('page-palestrantes') }}" class="experience-text-link">
                        Ver todos os palestrantes
                        <span aria-hidden="true">→</span>
                    </a>
                </div>

                <div class="experience-featured-speakers-grid">
                    @foreach ($palestrantes as $palestrante)
                        @php
                            $fotoPalestrante = !empty($palestrante->foto_usuario)
                                ? 'dash/assets/img/' . $palestrante->foto_usuario
                                : null;

                            $fotoPalestranteExiste = $fotoPalestrante
                                && file_exists(public_path($fotoPalestrante));

                            $iniciaisPalestrante = collect(preg_split('/\s+/', trim($palestrante->nome_usuario)))
                                ->filter()
                                ->take(2)
                                ->map(fn ($parte) => mb_strtoupper(mb_substr($parte, 0, 1)))
                                ->implode('');
                        @endphp

                        <article class="experience-featured-speaker-card">
                            <div class="experience-featured-speaker-media">
                                @if ($fotoPalestranteExiste)
                                    <img src="{{ asset($fotoPalestrante) }}"
                                        alt="{{ $palestrante->nome_usuario }}"
                                        loading="lazy"
                                        decoding="async">
                                @else
                                    <div class="experience-featured-speaker-fallback"
                                        aria-label="{{ $palestrante->nome_usuario }}">
                                        {{ $iniciaisPalestrante }}
                                    </div>
                                @endif

                                <div class="experience-featured-speaker-overlay"></div>

                                <div class="experience-featured-speaker-summary">
                                    <h3>{{ $palestrante->nome_usuario }}</h3>
                                    <p>{{ $palestrante->area_atuacao_usuario }}</p>
                                </div>

                                <a href="{{ url('/palestrantes') }}"
                                    class="experience-featured-speaker-arrow"
                                    aria-label="Conhecer {{ $palestrante->nome_usuario }}">
                                    →
                                </a>
                            </div>

                            @if (!empty($palestrante->sobre_usuario))
                                <p class="experience-featured-speaker-about">
                                    {{ \Illuminate\Support\Str::limit($palestrante->sobre_usuario, 105) }}
                                </p>
                            @endif
                        </article>
                    @endforeach
                </div>

            </div>
        </section>
    @endif


    {{-- ================================================================
    5. DEPOIMENTOS
    Mantém estrutura e dados atuais.
    ================================================================= --}}
    <section id="depoimento" class="depoimentos experience-testimonials experience-section-spaced">
        <div class="experience-shell">
            <div class="experience-section-heading experience-section-heading--light experience-section-heading--compact">
                <div>
                    <p class="experience-eyebrow">Depoimentos</p>
                    <h2 class="titulo">A Voz de Quem Já Esteve Lá</h2>
                </div>

                <p class="experience-heading-support">
                    O que profissionais da advocacia dizem sobre as experiências anteriores
                </p>
            </div>

            <div class="caixa-car experience-testimonial-window">
                <div class="carousel experience-testimonial-carousel" id="carousel">
                    @foreach ($depoimentos as $item)
                        <div class="cards experience-testimonial-slide">
                            <article class="texto-depoimentos experience-testimonial-card">
                                <div class="experience-testimonial-person">
                                    @php
                                        $fotoDepoimento = !empty($item->usuario->foto_usuario)
                                            ? 'dash/assets/img/' . $item->usuario->foto_usuario
                                            : null;

                                        $fotoDepoimentoExiste = $fotoDepoimento
                                            && file_exists(public_path($fotoDepoimento));
                                    @endphp

                                    @if ($fotoDepoimentoExiste)
                                        <img class="img-advo"
                                            src="{{ asset($fotoDepoimento) }}"
                                            alt="{{ $item->usuario->nome_usuario }}"
                                            width="54"
                                            height="54"
                                            loading="lazy"
                                            decoding="async">
                                    @else
                                        <div class="img-advo experience-testimonial-avatar-fallback"
                                            aria-label="{{ $item->usuario->nome_usuario }}"
                                            title="{{ $item->usuario->nome_usuario }}">
                                            {{ mb_strtoupper(mb_substr(trim($item->usuario->nome_usuario), 0, 1)) }}
                                        </div>
                                    @endif

                                    <div>
                                        <h3>{{ $item->usuario->nome_usuario }}</h3>
                                        <h4>{{ $item->usuario->area_atuacao_usuario }}</h4>
                                    </div>
                                </div>

                                <p class="textetexto experience-testimonial-text">
                                    “{{ $item->descricao_depoimento }}”
                                </p>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>


    {{-- ================================================================
    6. APP / COMUNIDADE
    Imagens reais do aplicativo.
    Colocar os arquivos em public/conexao360/img/app-login.png e app-home.png.
    ================================================================= --}}
    <section id="comunidade" class="experience-app-section experience-section-spaced">
        <div class="experience-shell experience-app-shell">

            <div class="experience-app-copy">
                <p class="experience-eyebrow">App & Comunidade</p>
                <h2>O evento termina.<br>As conexões continuam.</h2>

                <p class="experience-app-description">
                    O Conexão 360 também vive no digital. Continue perto de quem esteve no evento,
                    compartilhe experiências e encontre conteúdos que mantêm a comunidade ativa durante todo o ano.
                </p>

                <div class="experience-app-features">
                    <div class="experience-app-feature">
                        <i class="bi bi-people"></i>
                        <div>
                            <strong>Networking profissional</strong>
                            <span>Encontre e acompanhe outros participantes.</span>
                        </div>
                    </div>

                    <div class="experience-app-feature">
                        <i class="bi bi-chat-square-text"></i>
                        <div>
                            <strong>Publicações e discussões</strong>
                            <span>Compartilhe ideias e continue as conversas do evento.</span>
                        </div>
                    </div>

                    <div class="experience-app-feature">
                        <i class="bi bi-images"></i>
                        <div>
                            <strong>Fotos e vídeos</strong>
                            <span>Reviva os principais momentos do Conexão 360.</span>
                        </div>
                    </div>

                    <div class="experience-app-feature">
                        <i class="bi bi-calendar-event"></i>
                        <div>
                            <strong>Eventos e novidades</strong>
                            <span>Acompanhe próximas experiências e conteúdos exclusivos.</span>
                        </div>
                    </div>
                </div>

                <div class="experience-app-actions">
                    <a href="{{ route('page-app') }}" class="experience-primary-button">
                        Conheça a comunidade
                    </a>
                </div>
            </div>

            <div class="experience-app-visual" aria-label="Telas do aplicativo Conexão 360">
                <div class="experience-app-glow"></div>

                <img src="{{ asset('conexao360/img/app-login.png') }}"
                    alt="Tela de login do aplicativo Conexão 360"
                    class="experience-app-phone experience-app-phone--back"
                    loading="lazy"
                    decoding="async">

                <img src="{{ asset('conexao360/img/app-home.png') }}"
                    alt="Feed da comunidade no aplicativo Conexão 360"
                    class="experience-app-phone experience-app-phone--front"
                    loading="lazy"
                    decoding="async">
            </div>

        </div>
    </section>


    {{-- ================================================================
    7. CONEXÃO JURÍDICA / NOTÍCIAS
    Conteúdo demonstrativo por enquanto; pronto para virar @foreach com API.
    ================================================================= --}}
    <section id="noticias" class="experience-news-section experience-section-spaced">
        <div class="experience-shell">

            <div class="experience-news-heading">
                <div>
                    <p class="experience-eyebrow">Notícias</p>
                    <h2>Conexão Jurídica</h2>
                    <p>Informação para uma advocacia que evolui.</p>
                </div>

                <a href="{{ url('/noticias') }}" class="experience-text-link experience-text-link--light">
                    Ver todas as notícias
                    <span aria-hidden="true">→</span>
                </a>
            </div>

            <div class="experience-news-grid">

                <article class="experience-news-card">
                    <a href="#" class="experience-news-image">
                        <img src="{{ asset('conexao360/img/Mídia (1).jpg') }}"
                            alt="Profissionais em encontro jurídico"
                            loading="lazy"
                            decoding="async">
                    </a>

                    <div class="experience-news-content">
                        <span class="experience-news-category">Tecnologia</span>
                        <h3>Inteligência artificial e os novos fluxos de trabalho na advocacia</h3>
                        <p>Como novas ferramentas podem apoiar pesquisa, organização e produtividade sem substituir estratégia e julgamento profissional.</p>
                        <a href="#" class="experience-news-link">Ler mais →</a>
                    </div>
                </article>

                <article class="experience-news-card">
                    <a href="#" class="experience-news-image">
                        <img src="{{ asset('conexao360/img/captura.png') }}"
                            alt="Networking durante evento profissional"
                            loading="lazy"
                            decoding="async">
                    </a>

                    <div class="experience-news-content">
                        <span class="experience-news-category">Carreira</span>
                        <h3>Posicionamento jurídico: autoridade também se constrói fora do tribunal</h3>
                        <p>Relacionamento, clareza de comunicação e consistência de marca se tornaram partes importantes da presença profissional.</p>
                        <a href="#" class="experience-news-link">Ler mais →</a>
                    </div>
                </article>

                <article class="experience-news-card">
                    <a href="#" class="experience-news-image">
                        <img src="{{ asset('conexao360/img/vista.png') }}"
                            alt="Ambiente corporativo e gestão"
                            loading="lazy"
                            decoding="async">
                    </a>

                    <div class="experience-news-content">
                        <span class="experience-news-category">Gestão</span>
                        <h3>Escritório de advocacia também é negócio: indicadores que ajudam a decidir</h3>
                        <p>Organizar processos e acompanhar resultados torna decisões de crescimento mais claras e menos dependentes de improviso.</p>
                        <a href="#" class="experience-news-link">Ler mais →</a>
                    </div>
                </article>

            </div>
        </div>
    </section>


    {{-- ================================================================
    8. LOCAL DO EVENTO
    Mantém dados dinâmicos atuais.
    ================================================================= --}}
    <section class="local_sessao experience-location experience-section-spaced">
        <div class="experience-shell">
            <div class="experience-section-heading experience-section-heading--light experience-section-heading--compact">
                <div>
                    <p class="experience-eyebrow">Local do Evento</p>
                    <h2 class="tit_local">Sua transformação tem hora e lugar marcados</h2>
                </div>
            </div>

            <div class="local-cont experience-location-grid">
                <div class="event-info experience-location-info">
                    <div class="experience-location-intro">
                        <span class="experience-location-kicker">Conexão 360º</span>
                        <h3>O evento acontece aqui</h3>
                    </div>

                    <div class="info-item experience-location-item">
                        <div class="info-icon">
                            <img src="{{ asset('conexao360/img/icones_adv (8).svg') }}" alt="Calendário">
                        </div>

                        <div class="info-text">
                            <strong>Data e Horário</strong>
                            <p>{{ $evento->data_formatada }}.</p>
                        </div>
                    </div>

                    <div class="info-item experience-location-item">
                        <div class="info-icon">
                            <img src="{{ asset('conexao360/img/icones_adv (9).svg') }}" alt="Localização">
                        </div>

                        <div class="info-text">
                            <strong>Localização Evento</strong>
                            <p>{{ $evento->endereco_evento }}</p>
                        </div>
                    </div>
                </div>

                <div class="mapa experience-map-card">
                    <iframe src="{{ $evento->url_evento }}"
                        title="Local do evento"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>


    {{-- CTA FINAL — mantido antes do footer do layout --}}
    <section id="ingressos" class="cta-sessao experience-final-cta">
        <div class="experience-final-cta-overlay"></div>

        <div class="experience-shell experience-final-cta-shell">
            <div class="experience-final-cta-content">
                <p class="experience-eyebrow experience-final-cta-eyebrow">Ingressos</p>

                <h2>O próximo nível da sua carreira jurídica é uma decisão estratégica.</h2>

                <p class="experience-final-cta-description">
                    Faça parte do Conexão 360 e viva uma experiência criada para ampliar repertório,
                    relacionamentos e novas possibilidades profissionais.
                </p>

                <div class="experience-final-cta-meta">
                    <div class="experience-final-cta-meta-item">
                        <span>Data e horário</span>
                        <strong>{{ $evento->data_formatada }}</strong>
                    </div>

                    <div class="experience-final-cta-separator" aria-hidden="true"></div>

                    <div class="experience-final-cta-meta-item experience-final-cta-meta-item--location">
                        <span>Local</span>
                        <strong>{{ $evento->endereco_evento }}</strong>
                    </div>
                </div>

                <a href="https://sun.eduzz.com/Q9N56RAK01"
                    class="cta-botao experience-primary-button experience-final-cta-button"
                    target="_blank"
                    rel="noopener noreferrer">
                    Garantir meu ingresso <span>›</span>
                </a>
            </div>
        </div>
    </section>

</main>

{{-- Scripts no final da página: não bloqueiam a primeira renderização. --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('conexao360/js/slick.js') }}"></script>
<script src="{{ asset('conexao360/js/lity.min.js') }}"></script>
<script src="{{ asset('conexao360/js/script.js') }}"></script>

<script>
    $(function () {
        const $heroCarousel = $('#heroCarousel');

        if ($heroCarousel.length && !$heroCarousel.hasClass('slick-initialized')) {
            const quantidadeSlides = $heroCarousel.children('.experience-hero-slide').length;

            $heroCarousel.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: quantidadeSlides > 1,
                autoplay: quantidadeSlides > 1,
                autoplaySpeed: 6500,
                speed: 700,
                fade: true,
                cssEase: 'ease-in-out',
                arrows: quantidadeSlides > 1,
                dots: quantidadeSlides > 1,
                pauseOnHover: true,
                pauseOnFocus: true,
                adaptiveHeight: false,
                prevArrow: '<button type="button" class="experience-hero-arrow experience-hero-arrow--prev" aria-label="Slide anterior">‹</button>',
                nextArrow: '<button type="button" class="experience-hero-arrow experience-hero-arrow--next" aria-label="Próximo slide">›</button>'
            });
        }
    });
</script>
