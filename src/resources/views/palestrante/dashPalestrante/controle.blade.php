@php
    $palestranteLogado = auth('admin')->user();

    $nomeCompleto = trim($palestranteLogado->nome_usuario ?? 'Palestrante');
    $primeiroNome = preg_split('/\s+/', $nomeCompleto)[0] ?? 'Palestrante';

    $partesNome = preg_split('/\s+/', $nomeCompleto);

    $inicial1 = mb_substr($partesNome[0] ?? '', 0, 1);
    $inicial2 = isset($partesNome[1])
        ? mb_substr($partesNome[1], 0, 1)
        : mb_substr($partesNome[0] ?? '', 1, 1);

    $iniciais = strtoupper($inicial1 . $inicial2);

    $fotoRelativa = !empty($palestranteLogado->foto_usuario)
        ? 'dash/assets/img/' . $palestranteLogado->foto_usuario
        : null;

    $fotoExiste = $fotoRelativa
        && file_exists(public_path($fotoRelativa));

    $statusConta = strtoupper(trim($palestranteLogado->status_usuario ?? ''));
@endphp


<main class="app-main admin-standard-main speaker-admin-main">

    <div class="app-content container-fluid admin-standard-content">

        <div class="admin-standard-page speaker-home-page">

            {{-- =========================================================
            BOAS-VINDAS
            ========================================================== --}}
            <section class="speaker-welcome">

                <div class="speaker-welcome-copy">

                    <span class="speaker-eyebrow">
                        <i class="bi bi-stars"></i>
                        Conexão 360º
                    </span>

                    <h2 class="speaker-welcome-title">
                        Bem-vindo,
                        <span>{{ $primeiroNome }}</span>.
                    </h2>

                    <p class="speaker-welcome-description">
                        Este é o seu espaço exclusivo como palestrante.
                        Acompanhe seus depoimentos e acesse rapidamente os recursos
                        disponíveis para o seu perfil.
                    </p>


                    <div class="speaker-welcome-actions">

                        <a href="{{ route('admin.palestrante.depoimento.index') }}" class="admin-primary-action">
                            <i class="bi bi-chat-left-quote"></i>
                            Meus Depoimentos
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
                            <span>Perfil</span>

                            <strong>
                                {{ $palestranteLogado->perfil_usuario ?? 'Palestrante' }}
                            </strong>
                        </div>


                        @if (!empty($palestranteLogado->area_atuacao_usuario))
                            <div class="speaker-identity-row">
                                <span>Área</span>

                                <strong>
                                    {{ $palestranteLogado->area_atuacao_usuario }}
                                </strong>
                            </div>
                        @endif


                        @if (!empty($palestranteLogado->estado_usuario))
                            <div class="speaker-identity-row">
                                <span>Estado</span>

                                <strong>
                                    {{ $palestranteLogado->estado_usuario }}
                                </strong>
                            </div>
                        @endif


                        <div class="speaker-identity-row">
                            <span>Status</span>

                            <strong class="speaker-account-status {{ $statusConta === 'ATIVO' ? 'is-active' : '' }}">
                                {{ $palestranteLogado->status_usuario ?? 'Não informado' }}
                            </strong>
                        </div>

                    </div>

                </aside>

            </section>


            {{-- =========================================================
            ACESSOS RÁPIDOS
            ========================================================== --}}
            <section class="speaker-quick-grid" aria-label="Acessos rápidos">

                <a href="{{ route('admin.palestrante.depoimento.index') }}" class="speaker-quick-card">
                    <span class="speaker-quick-icon">
                        <i class="bi bi-chat-quote-fill"></i>
                    </span>

                    <div class="speaker-quick-copy">
                        <strong>
                            Depoimentos
                        </strong>

                        <span>
                            Crie um novo depoimento e acompanhe o status dos que você já enviou.
                        </span>
                    </div>

                    <i class="bi bi-arrow-right speaker-quick-arrow"></i>
                </a>


                <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="speaker-quick-card">
                    <span class="speaker-quick-icon">
                        <i class="bi bi-globe2"></i>
                    </span>

                    <div class="speaker-quick-copy">
                        <strong>
                            Site Oficial
                        </strong>

                        <span>
                            Acesse a experiência pública do Conexão 360º em uma nova aba.
                        </span>
                    </div>

                    <i class="bi bi-box-arrow-up-right speaker-quick-arrow"></i>
                </a>


                <article class="speaker-quick-card speaker-quick-card--info">

                    <span class="speaker-quick-icon">
                        <i class="bi bi-shield-check"></i>
                    </span>

                    <div class="speaker-quick-copy">
                        <strong>
                            Acesso Protegido
                        </strong>

                        <span>
                            Sua conta possui acesso somente aos recursos liberados para palestrantes.
                        </span>
                    </div>

                </article>

            </section>


            {{-- =========================================================
            GUIA
            ========================================================== --}}
            <section class="speaker-guide-panel">

                <div class="speaker-guide-content">

                    <div class="speaker-guide-heading">

                        <h3>
                            Seu espaço no Conexão 360º
                        </h3>

                        <p>
                            A área do palestrante foi mantida objetiva para facilitar o acesso ao que você realmente
                            utiliza.
                        </p>

                    </div>


                    <div class="speaker-guide-list">

                        <div class="speaker-guide-item">

                            <span class="speaker-guide-number">
                                01
                            </span>

                            <div>
                                <strong>
                                    Compartilhe sua experiência
                                </strong>

                                <span>
                                    Envie depoimentos diretamente pelo painel.
                                </span>
                            </div>

                        </div>


                        <div class="speaker-guide-item">

                            <span class="speaker-guide-number">
                                02
                            </span>

                            <div>
                                <strong>
                                    Acompanhe o status
                                </strong>

                                <span>
                                    Veja seus depoimentos pendentes, aprovados ou reprovados.
                                </span>
                            </div>

                        </div>


                        <div class="speaker-guide-item">

                            <span class="speaker-guide-number">
                                03
                            </span>

                            <div>
                                <strong>
                                    Navegue com segurança
                                </strong>

                                <span>
                                    O painel exibe apenas as funcionalidades autorizadas para o perfil de palestrante.
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