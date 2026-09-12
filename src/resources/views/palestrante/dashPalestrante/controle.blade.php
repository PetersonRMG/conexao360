@php
    $palestranteLogado = auth('admin')->user();

    $nomeCompleto =
        trim(
            $palestranteLogado->nome_usuario
            ?? 'Palestrante'
        );

    $primeiroNome =
        preg_split('/\s+/', $nomeCompleto)[0]
        ?? 'Palestrante';

    $partesNome =
        preg_split('/\s+/', $nomeCompleto);

    $inicial1 =
        mb_substr(
            $partesNome[0] ?? '',
            0,
            1
        );

    $inicial2 =
        isset($partesNome[1])
        ? mb_substr($partesNome[1], 0, 1)
        : mb_substr($partesNome[0] ?? '', 1, 1);

    $iniciais =
        strtoupper(
            $inicial1 . $inicial2
        );

    $fotoRelativa =
        !empty($palestranteLogado->foto_usuario)
        ? 'dash/assets/img/' . $palestranteLogado->foto_usuario
        : null;

    $fotoExiste =
        $fotoRelativa
        && file_exists(
            public_path($fotoRelativa)
        );

    $statusConta =
        strtoupper(
            trim(
                $palestranteLogado->status_usuario
                ?? ''
            )
        );

    $perfilPreenchido = collect([
        $palestranteLogado->nome_usuario ?? null,
        $palestranteLogado->foto_usuario ?? null,
        $palestranteLogado->area_atuacao_usuario ?? null,
        $palestranteLogado->estado_usuario ?? null,
        $palestranteLogado->sobre_usuario ?? null,
    ])
        ->filter(fn($valor) => filled($valor))
        ->count();

    $percentualPerfil =
        $perfilPreenchido * 20;

    $rotaVideosExiste =
        \Illuminate\Support\Facades\Route::has(
            'admin.palestrante.video.index'
        );

    $rotaEnquetesExiste =
        \Illuminate\Support\Facades\Route::has(
            'admin.palestrante.enquete.index'
        );
@endphp


<main class="app-main admin-standard-main speaker-admin-main">

    <div class="app-content container-fluid admin-standard-content">

        <div class="admin-standard-page speaker-home-page">

            {{-- BOAS-VINDAS --}}
            <section class="speaker-welcome">

                <div class="speaker-welcome-copy">

                    <span class="speaker-eyebrow">

                        <i class="bi bi-stars"></i>

                        Conexão 360º

                    </span>


                    <h2 class="speaker-welcome-title">

                        Bem-vindo,

                        <span>
                            {{ $primeiroNome }}
                        </span>.

                    </h2>


                    <p class="speaker-welcome-description">

                        Gerencie sua apresentação pública,
                        seus depoimentos e os conteúdos que
                        serão conectados ao site e ao aplicativo.

                    </p>


                    <div class="speaker-welcome-actions">

                        <a href="{{ route('admin.palestrante.perfil.index') }}" class="admin-primary-action">

                            <i class="bi bi-person-vcard"></i>

                            Editar meu perfil

                        </a>


                        <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer"
                            class="admin-secondary-action">

                            <i class="bi bi-box-arrow-up-right"></i>

                            Abrir Site Oficial

                        </a>

                    </div>

                </div>


                {{-- IDENTIDADE --}}
                <aside class="speaker-identity">

                    <div class="speaker-identity-top">

                        @if ($fotoExiste)

                            <img src="{{ asset($fotoRelativa) }}" alt="{{ $nomeCompleto }}" class="speaker-identity-avatar">

                        @else

                            <div class="speaker-identity-avatar-fallback" aria-label="{{ $nomeCompleto }}">
                                {{ $iniciais }}
                            </div>

                        @endif


                        <div class="speaker-identity-copy">

                            <strong>
                                {{ $nomeCompleto }}
                            </strong>

                            <span>
                                {{ $palestranteLogado->email_usuario ?? 'E-mail não informado' }}
                            </span>

                        </div>

                    </div>


                    <div class="speaker-identity-list">

                        <div class="speaker-identity-row">

                            <span>
                                Perfil
                            </span>

                            <strong>
                                {{ $palestranteLogado->perfil_usuario ?? 'Palestrante' }}
                            </strong>

                        </div>


                        @if (!empty($palestranteLogado->area_atuacao_usuario))

                            <div class="speaker-identity-row">

                                <span>
                                    Área
                                </span>

                                <strong>
                                    {{ $palestranteLogado->area_atuacao_usuario }}
                                </strong>

                            </div>

                        @endif


                        @if (!empty($palestranteLogado->estado_usuario))

                            <div class="speaker-identity-row">

                                <span>
                                    Estado
                                </span>

                                <strong>
                                    {{ $palestranteLogado->estado_usuario }}
                                </strong>

                            </div>

                        @endif


                        <div class="speaker-identity-row">

                            <span>
                                Perfil público
                            </span>

                            <strong>
                                {{ $percentualPerfil }}%
                            </strong>

                        </div>


                        <div class="speaker-identity-row">

                            <span>
                                Status
                            </span>

                            <strong class="speaker-account-status {{ $statusConta === 'ATIVO' ? 'is-active' : '' }}">
                                {{ $palestranteLogado->status_usuario ?? 'Não informado' }}
                            </strong>

                        </div>

                    </div>

                </aside>

            </section>


            {{-- MÓDULOS --}}
            <section class="speaker-management-panel">

                <div class="speaker-management-heading">

                    <div>

                        <span class="speaker-eyebrow">

                            <i class="bi bi-grid"></i>

                            Seu espaço

                        </span>

                        <h3>
                            Conteúdo do Palestrante
                        </h3>

                        <p>
                            Aqui ficam as informações e conteúdos
                            que pertencem ao seu perfil dentro do
                            Conexão 360º.
                        </p>

                    </div>

                </div>


                <div class="speaker-management-grid">

                    <a href="{{ route('admin.palestrante.perfil.index') }}" class="speaker-management-card">

                        <span class="speaker-management-icon">
                            <i class="bi bi-person-vcard"></i>
                        </span>

                        <div class="speaker-management-copy">

                            <strong>
                                Meu Perfil
                            </strong>

                            <p>
                                Edite foto, nome, área de atuação,
                                estado e sua apresentação pública.
                            </p>

                        </div>

                        <i class="bi bi-arrow-right speaker-management-arrow"></i>

                    </a>


                    @if ($rotaVideosExiste)

                        <a href="{{ route('admin.palestrante.video.index') }}" class="speaker-management-card">

                            <span class="speaker-management-icon">
                                <i class="bi bi-play-btn-fill"></i>
                            </span>

                            <div class="speaker-management-copy">

                                <strong>
                                    Meus Vídeos
                                </strong>

                                <p>
                                    Envie vídeos e acompanhe
                                    o status de publicação.
                                </p>

                            </div>

                            <i class="bi bi-arrow-right speaker-management-arrow"></i>

                        </a>

                    @else

                        <article class="speaker-management-card speaker-management-card--disabled">

                            <span class="speaker-management-icon">
                                <i class="bi bi-play-btn-fill"></i>
                            </span>

                            <div class="speaker-management-copy">

                                <strong>
                                    Meus Vídeos
                                </strong>

                                <p>
                                    Este será o próximo módulo
                                    de conteúdo do palestrante.
                                </p>

                                <span class="speaker-module-status">
                                    Próximo
                                </span>

                            </div>

                        </article>

                    @endif


                    @if ($rotaEnquetesExiste)

                        <a href="{{ route('admin.palestrante.enquete.index') }}" class="speaker-management-card">

                            <span class="speaker-management-icon">
                                <i class="bi bi-bar-chart-steps"></i>
                            </span>

                            <div class="speaker-management-copy">

                                <strong>
                                    Minhas Enquetes
                                </strong>

                                <p>
                                    Crie perguntas e acompanhe
                                    as respostas dos participantes.
                                </p>

                            </div>

                            <i class="bi bi-arrow-right speaker-management-arrow"></i>

                        </a>

                    @else

                        <article class="speaker-management-card speaker-management-card--disabled">

                            <span class="speaker-management-icon">
                                <i class="bi bi-bar-chart-steps"></i>
                            </span>

                            <div class="speaker-management-copy">

                                <strong>
                                    Minhas Enquetes
                                </strong>

                                <p>
                                    As enquetes serão publicadas
                                    no aplicativo do evento.
                                </p>

                                <span class="speaker-module-status">
                                    Próximo
                                </span>

                            </div>

                        </article>

                    @endif


                    <a href="{{ route('admin.palestrante.depoimento.index') }}" class="speaker-management-card">

                        <span class="speaker-management-icon">
                            <i class="bi bi-chat-quote-fill"></i>
                        </span>

                        <div class="speaker-management-copy">

                            <strong>
                                Depoimentos
                            </strong>

                            <p>
                                Crie um novo depoimento e acompanhe
                                pendentes, aprovados e reprovados.
                            </p>

                        </div>

                        <i class="bi bi-arrow-right speaker-management-arrow"></i>

                    </a>


                    <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer"
                        class="speaker-management-card">

                        <span class="speaker-management-icon">
                            <i class="bi bi-globe2"></i>
                        </span>

                        <div class="speaker-management-copy">

                            <strong>
                                Site Oficial
                            </strong>

                            <p>
                                Confira como o conteúdo público
                                aparece para os participantes.
                            </p>

                        </div>

                        <i class="bi bi-box-arrow-up-right speaker-management-arrow"></i>

                    </a>

                </div>

            </section>


            {{-- FLUXO --}}
            <section class="speaker-guide-panel">

                <div class="speaker-guide-content">

                    <div class="speaker-guide-heading">

                        <h3>
                            Seu conteúdo dentro do Conexão 360º
                        </h3>

                        <p>
                            O painel passa a ser o ponto central
                            do conteúdo oficial do palestrante.
                        </p>

                    </div>


                    <div class="speaker-guide-list">

                        <div class="speaker-guide-item">

                            <span class="speaker-guide-number">
                                01
                            </span>

                            <div>

                                <strong>
                                    Perfil público
                                </strong>

                                <span>
                                    Nome, foto, área e apresentação
                                    alimentam o site automaticamente.
                                </span>

                            </div>

                        </div>


                        <div class="speaker-guide-item">

                            <span class="speaker-guide-number">
                                02
                            </span>

                            <div>

                                <strong>
                                    Conteúdo oficial
                                </strong>

                                <span>
                                    Vídeos e enquetes ficam vinculados
                                    ao palestrante e ao evento.
                                </span>

                            </div>

                        </div>


                        <div class="speaker-guide-item">

                            <span class="speaker-guide-number">
                                03
                            </span>

                            <div>

                                <strong>
                                    Site + App
                                </strong>

                                <span>
                                    O Laravel mantém uma única fonte
                                    de dados para web e mobile.
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                <div class="speaker-guide-brand" aria-hidden="true">

                    <img src="{{ asset('conexao360/img/pint.svg') }}" alt="">

                </div>

            </section>

        </div>

    </div>

</main>