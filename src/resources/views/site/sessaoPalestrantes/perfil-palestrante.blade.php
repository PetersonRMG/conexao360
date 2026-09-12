@extends('layout.site')

@section('title', $palestrante->nome_usuario . ' | Palestrante')

@section('content')

    @php
        $fotoPalestrante = !empty($palestrante->foto_usuario)
            ? 'dash/assets/img/' . $palestrante->foto_usuario
            : null;

        $fotoExiste = $fotoPalestrante
            && file_exists(public_path($fotoPalestrante));

        $iniciais = collect(
            preg_split('/\s+/', trim($palestrante->nome_usuario))
        )
            ->filter()
            ->take(2)
            ->map(
                fn($parte) =>
                    mb_strtoupper(
                        mb_substr($parte, 0, 1)
                    )
            )
            ->implode('');

        $redes = collect([
            [
                'nome' => 'Instagram',
                'icone' => 'bi-instagram',
                'url' => $palestrante->instagram_usuario ?? null,
            ],
            [
                'nome' => 'LinkedIn',
                'icone' => 'bi-linkedin',
                'url' => $palestrante->linkedin_usuario ?? null,
            ],
            [
                'nome' => 'YouTube',
                'icone' => 'bi-youtube',
                'url' => $palestrante->youtube_usuario ?? null,
            ],
            [
                'nome' => 'TikTok',
                'icone' => 'bi-tiktok',
                'url' => $palestrante->tiktok_usuario ?? null,
            ],
            [
                'nome' => 'Facebook',
                'icone' => 'bi-facebook',
                'url' => $palestrante->facebook_usuario ?? null,
            ],
            [
                'nome' => 'Site profissional',
                'icone' => 'bi-globe2',
                'url' => $palestrante->site_usuario ?? null,
            ],
        ])->filter(
                fn($rede) => filled($rede['url'])
            );
    @endphp


    <main class="experience-main speaker-detail-page">

        {{-- ================================================================
        HERO / PERFIL PRINCIPAL
        ================================================================= --}}
        <section class="speaker-detail-hero">

            <div class="speaker-detail-hero-glow"></div>

            <div class="experience-shell speaker-detail-hero-grid">

                {{-- FOTO --}}
                <div class="speaker-detail-photo">

                    @if ($fotoExiste)

                        <img src="{{ asset($fotoPalestrante) }}" alt="{{ $palestrante->nome_usuario }}" loading="eager"
                            decoding="async">

                    @else

                        <div class="speaker-detail-photo-fallback" aria-label="{{ $palestrante->nome_usuario }}">
                            {{ $iniciais ?: 'P' }}
                        </div>

                    @endif

                    <div class="speaker-detail-photo-line"></div>

                </div>


                {{-- INFORMAÇÕES --}}
                <div class="speaker-detail-intro">

                    <a href="{{ route('page-palestrantes') }}" class="speaker-detail-back">
                        <i class="bi bi-arrow-left"></i>
                        Voltar para palestrantes
                    </a>


                    <p class="experience-eyebrow">
                        Palestrante
                    </p>


                    <h1>
                        {{ $palestrante->nome_usuario }}
                    </h1>


                    <p class="speaker-detail-area">
                        {{ $palestrante->area_atuacao_usuario ?: 'Palestrante Conexão 360º' }}
                    </p>


                    @if (!empty($palestrante->estado_usuario))

                        <div class="speaker-detail-location">

                            <i class="bi bi-geo-alt"></i>

                            <span>
                                {{ $palestrante->estado_usuario }}
                            </span>

                        </div>

                    @endif


                    {{-- REDES SOCIAIS --}}
                    @if ($redes->isNotEmpty())

                        <div class="speaker-detail-socials" aria-label="Redes sociais de {{ $palestrante->nome_usuario }}">

                            @foreach ($redes as $rede)

                                <a href="{{ $rede['url'] }}" target="_blank" rel="noopener noreferrer" title="{{ $rede['nome'] }}"
                                    aria-label="{{ $rede['nome'] }} de {{ $palestrante->nome_usuario }}">
                                    <i class="bi {{ $rede['icone'] }}"></i>
                                </a>

                            @endforeach

                        </div>

                    @endif

                </div>

            </div>

        </section>


        {{-- ================================================================
        SOBRE O PALESTRANTE
        ================================================================= --}}
        <section class="speaker-detail-about">

            <div class="experience-shell speaker-detail-about-grid">

                <div class="speaker-detail-section-title">

                    <p class="experience-eyebrow">
                        Conheça o palestrante
                    </p>

                    <h2>
                        Experiência,
                        conhecimento e
                        novas perspectivas.
                    </h2>

                </div>


                <div class="speaker-detail-bio">

                    @if (!empty($palestrante->sobre_usuario))

                        <p>
                            {!! nl2br(e($palestrante->sobre_usuario)) !!}
                        </p>

                    @else

                        <p>
                            {{ $palestrante->nome_usuario }} é palestrante convidado
                            do Conexão 360º. Em breve, novas informações sobre sua
                            trajetória profissional estarão disponíveis.
                        </p>

                    @endif

                </div>

            </div>

        </section>


        {{-- ================================================================
        PRESENÇA DIGITAL
        Só aparece se houver alguma rede preenchida.
        ================================================================= --}}
        @if ($redes->isNotEmpty())

            <section class="speaker-detail-connect">

                <div class="experience-shell">

                    <div class="speaker-detail-connect-heading">

                        <div>

                            <p class="experience-eyebrow">
                                Continue a conexão
                            </p>

                            <h2>
                                Acompanhe
                                <span>{{ $palestrante->nome_usuario }}</span>
                                também fora do evento.
                            </h2>

                        </div>


                        <p>
                            Conheça os canais oficiais e acompanhe conteúdos,
                            ideias e experiências compartilhadas pelo palestrante.
                        </p>

                    </div>


                    <div class="speaker-detail-network-grid">

                        @foreach ($redes as $rede)

                            <a href="{{ $rede['url'] }}" target="_blank" rel="noopener noreferrer"
                                class="speaker-detail-network-card">

                                <i class="bi {{ $rede['icone'] }}"></i>


                                <div>

                                    <span>
                                        Acessar
                                    </span>

                                    <strong>
                                        {{ $rede['nome'] }}
                                    </strong>

                                </div>


                                <i class="bi bi-arrow-up-right"></i>

                            </a>

                        @endforeach

                    </div>

                </div>

            </section>

        @endif


        {{-- ================================================================
        CTA FINAL
        ================================================================= --}}
        <section class="speaker-detail-cta">

            <div class="speaker-detail-cta-glow"></div>

            <div class="experience-shell speaker-detail-cta-shell">

                <p class="experience-eyebrow">
                    Conexão 360º
                </p>


                <h2>
                    Conhecimento ganha força
                    <span>quando gera conexão.</span>
                </h2>


                <div class="speaker-detail-cta-actions">

                    <a href="{{ route('page-palestrantes') }}" class="speaker-detail-secondary-button">
                        Ver todos os palestrantes
                    </a>


                    <a href="{{ route('home') }}#ingressos" class="experience-primary-button">
                        Garantir ingresso
                    </a>

                </div>

            </div>

        </section>

    </main>

@endsection