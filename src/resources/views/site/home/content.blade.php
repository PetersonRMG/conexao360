<main class="experience-main">

    {{-- ================================================================
    HERO DINÂMICO
    Mantém os dados cadastrados no dashboard.
    O conteúdo institucional foi integrado ao final do próprio hero.
    ================================================================= --}}
    @foreach ($hero as $item)
        @if ($item->status_hero === 'ATIVO')
            <section class="header-advocacia experience-hero"
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
                                <img src="{{ asset('conexao360/img/icones_adv (8).svg') }}" alt="Calendário">
                                <div>
                                    <span>Data e Horário</span>
                                    <strong>{{ $evento->data_formatada }}</strong>
                                </div>
                            </div>

                            <div class="experience-meta-item">
                                <img src="{{ asset('conexao360/img/icones_adv (9).svg') }}" alt="Localização">
                                <div>
                                    <span>Localização Evento</span>
                                    <strong>{{ $evento->endereco_evento }}</strong>
                                </div>
                            </div>
                        </div>

                        <a href="{{ $item->link_botao_hero }}" class="cta-header experience-primary-button" target="_blank"
                            rel="noopener noreferrer">
                            {{ $item->texto_botao_hero }}
                        </a>
                    </div>
                </div>

                {{-- Conteúdo institucional integrado ao hero --}}
                <div class="experience-hero-brand">
                    <div class="experience-shell experience-hero-brand-shell">
                        <div class="conexao-carousel experience-hero-brand-carousel" id="conexaoCarousel">

                            <div class="experience-hero-brand-slide">
                                <div class="experience-hero-brand-logo">
                                    <img src="{{ asset('conexao360/img/pint.svg') }}" alt="Logo" decoding="async">
                                </div>

                                <div class="experience-hero-brand-copy">
                                    <span>Conexão 360º</span>
                                    <strong>ADVOCACIA <br> E<span>X</span>PONENCIAL</strong>
                                    <small>3ª EDIÇÃO</small>
                                </div>

                                <div class="experience-hero-brand-thumb"
                                    style="background-image: url('{{ asset('conexao360/img/Mídia (1).jpg') }}');"></div>
                            </div>

                            <div class="experience-hero-brand-slide">
                                <div class="experience-hero-brand-logo">
                                    <img src="{{ asset('conexao360/img/pint.svg') }}" alt="Logo" decoding="async">
                                </div>

                                <div class="experience-hero-brand-copy">
                                    <span>Networking de Elite</span>
                                    <strong>CONEXÕES <br> E<span>X</span>CLUSIVAS</strong>
                                    <small>VAGAS LIMITADAS</small>
                                </div>

                                <div class="experience-hero-brand-thumb"
                                    style="background-image: url('{{ asset('conexao360/img/captura.png') }}');"></div>
                            </div>

                            <div class="experience-hero-brand-slide">
                                <div class="experience-hero-brand-logo">
                                    <img src="{{ asset('conexao360/img/pint.svg') }}" alt="Logo" decoding="async">
                                </div>

                                <div class="experience-hero-brand-copy">
                                    <span>Imersão Prática</span>
                                    <strong>MENTORIA <br> E<span>X</span>STRATÉGICA</strong>
                                    <small>PRÓXIMO EVENTO</small>
                                </div>

                                <div class="experience-hero-brand-thumb"
                                    style="background-image: url('{{ asset('conexao360/img/Mídia (1).jpg') }}');"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach


    {{-- ================================================================
    PALESTRA / CONTEÚDO EM VÍDEO
    Dados dinâmicos: $video
    ================================================================= --}}
    <section id="palestra" class="palestra experience-about">
        <div class="experience-shell experience-about-shell">
            @foreach ($video as $item)
                <article class="teste experience-about-grid">
                    <div class="conteudo experience-about-copy">
                        <p class="experience-eyebrow">Sobre o Evento</p>
                        <span class="tag experience-outline-tag">Palestra Exclusiva</span>

                        <h2>{{ $item->titulo_video }}</h2>

                        <p>{{ $item->subtitulo_video }}</p>

                        <ul class="experience-check-list">
                            <li>Com método, clareza e direção estratégica</li>
                            <li>Sem promessas vazias</li>
                            <li>Sem atalhos irreais</li>
                        </ul>
                    </div>

                    <div class="imagem experience-video-card">
                        <a class="data-lity experience-video-link" href="{{ asset('conexao360/img/' . $item->url_video) }}"
                            data-lity>
                            <img src="{{ asset('conexao360/img/' . $item->capa_video) }}" alt="Palestra advocacia"
                                loading="lazy" decoding="async">

                            <span class="play-btn" aria-hidden="true">
                                <span class="play-icon"></span>
                            </span>
                        </a>

                        <p class="tit-video experience-video-caption">
                            — {{ $item->legenda_video }} —
                        </p>
                    </div>
                </article>
            @endforeach
        </div>
    </section>


    {{-- ================================================================
    TEMAS / O QUE SERÁ ATIVADO
    Dados dinâmicos: $temas
    ================================================================= --}}
    <section class="abordagem experience-topics">
        <div class="experience-shell">
            <div class="experience-section-heading experience-section-heading--light">
                <p class="experience-eyebrow">Conexão 360º</p>
                <h2 class="title">O que você vai ativar no conexão 360°</h2>
                <h3 class="sub-title">( Não é conteúdo. É virada de chave )</h3>
            </div>

            <div class="experience-topic-grid">
                @foreach ($temas as $item)
                    <article class="experience-topic-card" id="tema-{{ $item->id_tema }}">
                        <div class="experience-topic-image">
                            <img src="{{ asset('conexao360/img/' . $item->foto_tema) }}" alt="{{ $item->titulo_tema }}"
                                loading="lazy" decoding="async">
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
    DRA. / PALESTRANTE
    Dados dinâmicos: $dra
    ================================================================= --}}
    <section class="sobre experience-speakers">
        <div class="experience-shell">
            <div class="experience-section-heading experience-section-heading--dark">
                <p class="experience-eyebrow">Uma Referência na Advocacia</p>
                <h2 class="titulo">A Mente que Provoca Mudança</h2>
            </div>

            <div class="experience-speaker-grid">
                @foreach ($dra as $item)
                    <article class="sobre-tds experience-speaker-card">
                        <div class="ajst-img experience-speaker-image">
                            <img src="{{ asset('conexao360/img/' . $item->foto_dra) }}" alt="Dra. Simone Baptista"
                                loading="lazy" decoding="async">
                        </div>

                        <div class="sobre-info experience-speaker-info">
                            <p class="experience-eyebrow">Palestrante</p>
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
    DEPOIMENTOS
    Dados dinâmicos: $depoimentos e relacionamento usuario
    ================================================================= --}}
    <section id="depoimento" class="depoimentos experience-testimonials">
        <div class="experience-shell">
            <div
                class="experience-section-heading experience-section-heading--light experience-section-heading--compact">
                <div>
                    <p class="experience-eyebrow">Depoimentos</p>
                    <h2 class="titulo">A Voz de Quem Já Esteve Lá</h2>
                </div>

                <p class="experience-heading-support">
                    O que profissionais da advocacia dizem sobre as palestras anteriores
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
                                        <img class="img-advo" src="{{ asset($fotoDepoimento) }}"
                                            alt="{{ $item->usuario->nome_usuario }}" width="54" height="54" loading="lazy"
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
    LOCAL DO EVENTO
    Opção aprovada: dados + Google Maps, sem inventar fotografia.
    Dados dinâmicos: $evento
    ================================================================= --}}
    <section class="local_sessao experience-location">
        <div class="experience-shell">
            <div
                class="experience-section-heading experience-section-heading--light experience-section-heading--compact">
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
                    <iframe src="{{ $evento->url_evento }}" title="Local do evento" allowfullscreen loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>


    {{-- ================================================================
    CTA FINAL / INGRESSOS
    Versão compacta: sem contador e sem card interno.
    Mantém o CTA existente e reaproveita os dados dinâmicos do evento.
    ================================================================= --}}
    <section id="ingressos" class="cta-sessao experience-final-cta">
        <div class="experience-final-cta-overlay"></div>

        <div class="experience-shell experience-final-cta-shell">
            <div class="experience-final-cta-content">
                <p class="experience-eyebrow experience-final-cta-eyebrow">Ingressos</p>

                <h2>O próximo nível da sua carreira jurídica é uma decisão estratégica.</h2>

                <p class="experience-final-cta-description">
                    Saia do operacional exaustivo e assuma o controle da sua advocacia com o método de quem vive a
                    prática
                    real todos os dias.
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
                    class="cta-botao experience-primary-button experience-final-cta-button" target="_blank"
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