@php

    $rotaPublicacoes = \Illuminate\Support\Facades\Route::has('admin.publicacoes.index');
    $rotaConteudos = \Illuminate\Support\Facades\Route::has('admin.conteudos.index');

    // Próximos módulos
    $rotaParticipantes = \Illuminate\Support\Facades\Route::has('admin.participantes.index');
    $rotaEnquetes = \Illuminate\Support\Facades\Route::has('admin.enquetes.index');
    $rotaModeracao = \Illuminate\Support\Facades\Route::has('admin.moderacao.index');
    $rotaConfiguracoes = \Illuminate\Support\Facades\Route::has('admin.rede.configuracoes');

@endphp


<aside class="app-sidebar admin-sidebar" data-bs-theme="dark">

    {{-- ============================================================
         LOGO / MARCA
    ============================================================= --}}
    <div class="sidebar-brand admin-sidebar-brand">

        <a
            href="{{ route('home') }}"
            target="_blank"
            rel="noopener noreferrer"
            class="brand-link admin-sidebar-brand-link">

            <img
                src="{{ asset('conexao360/img/pint.svg') }}"
                alt="Logo"
                class="brand-image admin-sidebar-logo">

            <div class="admin-sidebar-brand-copy">

                <span>Advocacia</span>

                <strong>
                    E<span>X</span>ponencial
                </strong>

                <small>
                    Painel Administrativo
                </small>

            </div>

        </a>

    </div>


    {{-- ============================================================
         MENU
    ============================================================= --}}
    <div class="sidebar-wrapper admin-sidebar-wrapper">

        <nav class="mt-2">

            <ul
                class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="navigation"
                aria-label="Main navigation"
                data-accordion="false"
                id="navigation">


                {{-- ====================================================
                     PAINEL
                ===================================================== --}}
                <li class="nav-header admin-sidebar-section">
                    Painel
                </li>


                {{-- DASHBOARD --}}
                <li class="nav-item">

                    <a
                        href="{{ route('admin.dash') }}"
                        class="nav-link admin-sidebar-link
                        {{ Request::routeIs('admin.dash') ? 'active' : '' }}">

                        <i class="nav-icon bi bi-grid-1x2-fill"></i>

                        <p>
                            Dashboard
                        </p>

                    </a>

                </li>



                {{-- ====================================================
                     GERENCIAR SITE
                ===================================================== --}}
                <li class="nav-header admin-sidebar-section admin-sidebar-section--divided">
                    Gerenciar Site
                </li>


                {{-- MODIFICAÇÕES DO SITE --}}
                <li class="nav-item">

                    <a
                        href="{{ route('admin.modificar.site') }}"
                        class="nav-link admin-sidebar-link
                        {{ Request::routeIs('admin.modificar.site') ? 'active' : '' }}">

                        <i class="nav-icon bi bi-pencil-square"></i>

                        <p>
                            Modificações do Site
                        </p>

                    </a>

                </li>


                {{-- DEPOIMENTOS --}}
                <li class="nav-item">

                    <a
                        href="{{ route('admin.depoimentos.index') }}"
                        class="nav-link admin-sidebar-link
                        {{ Request::routeIs('admin.depoimentos.*') ? 'active' : '' }}">

                        <i class="nav-icon bi bi-chat-left-quote-fill"></i>

                        <p>
                            Depoimentos
                        </p>

                    </a>

                </li>



                {{-- ====================================================
                     REDE PRIVADA
                ===================================================== --}}
                <li class="nav-header admin-sidebar-section admin-sidebar-section--divided">
                    Rede Privada
                </li>


                {{-- MEMBROS --}}
                <li class="nav-item">

                    <a
                        href="{{ route('admin.cadastro.usuarios') }}"
                        class="nav-link admin-sidebar-link
                        {{ Request::routeIs('admin.cadastro.usuarios') ? 'active' : '' }}">

                        <i class="nav-icon bi bi-people-fill"></i>

                        <p>
                            Membros
                        </p>

                    </a>

                </li>


                {{-- PALESTRANTES --}}
                <li class="nav-item">

                    <a
                        href="{{ route('admin.cadastro.palestrante') }}"
                        class="nav-link admin-sidebar-link
                        {{ Request::routeIs('admin.cadastro.palestrante') ? 'active' : '' }}">

                        <i class="nav-icon bi bi-mic-fill"></i>

                        <p>
                            Palestrantes
                        </p>

                    </a>

                </li>


                {{-- PUBLICAÇÕES --}}
                <li class="nav-item">

                    <a
                        href="{{ $rotaPublicacoes ? route('admin.publicacoes.index') : '#' }}"
                        class="nav-link admin-sidebar-link
                        {{ Request::routeIs('admin.publicacoes.*') ? 'active' : '' }}
                        {{ !$rotaPublicacoes ? 'disabled' : '' }}">

                        <i class="nav-icon bi bi-file-post-fill"></i>

                        <p>
                            Publicações
                        </p>

                    </a>

                </li>


                {{-- CONTEÚDOS --}}
                <li class="nav-item">

                    <a
                        href="{{ $rotaConteudos ? route('admin.conteudos.index') : '#' }}"
                        class="nav-link admin-sidebar-link
                        {{ Request::routeIs('admin.conteudos.*') ? 'active' : '' }}
                        {{ !$rotaConteudos ? 'disabled' : '' }}">

                        <i class="nav-icon bi bi-collection-play-fill"></i>

                        <p>
                            Conteúdos
                        </p>

                    </a>

                </li>



                {{-- ====================================================
                     EVENTOS / PARTICIPAÇÃO
                ===================================================== --}}
                <li class="nav-header admin-sidebar-section admin-sidebar-section--divided">
                    Eventos e Participação
                </li>


                {{-- PARTICIPANTES / PRESENÇAS --}}
                <li class="nav-item">

                    <a
                        href="{{ $rotaParticipantes ? route('admin.participantes.index') : '#' }}"
                        class="nav-link admin-sidebar-link
                        {{ Request::routeIs('admin.participantes.*') ? 'active' : '' }}
                        {{ !$rotaParticipantes ? 'disabled' : '' }}">

                        <i class="nav-icon bi bi-person-check-fill"></i>

                        <p>
                            Participantes
                        </p>

                        @if (!$rotaParticipantes)
                            <span class="badge admin-sidebar-coming-soon">
                                Em breve
                            </span>
                        @endif

                    </a>

                </li>


                {{-- ENQUETES --}}
                <li class="nav-item">

                    <a
                        href="{{ $rotaEnquetes ? route('admin.enquetes.index') : '#' }}"
                        class="nav-link admin-sidebar-link
                        {{ Request::routeIs('admin.enquetes.*') ? 'active' : '' }}
                        {{ !$rotaEnquetes ? 'disabled' : '' }}">

                        <i class="nav-icon bi bi-bar-chart-fill"></i>

                        <p>
                            Enquetes
                        </p>

                        @if (!$rotaEnquetes)
                            <span class="badge admin-sidebar-coming-soon">
                                Em breve
                            </span>
                        @endif

                    </a>

                </li>



                {{-- ====================================================
                     MODERAÇÃO
                ===================================================== --}}
                <li class="nav-header admin-sidebar-section admin-sidebar-section--divided">
                    Segurança e Moderação
                </li>


                {{-- MODERAR PUBLICAÇÕES --}}
                <li class="nav-item">

                    <a
                        href="{{ $rotaModeracao ? route('admin.moderacao.index') : '#' }}"
                        class="nav-link admin-sidebar-link
                        {{ Request::routeIs('admin.moderacao.*') ? 'active' : '' }}
                        {{ !$rotaModeracao ? 'disabled' : '' }}">

                        <i class="nav-icon bi bi-shield-exclamation"></i>

                        <p>
                            Moderação
                        </p>

                        @if (!$rotaModeracao)
                            <span class="badge admin-sidebar-coming-soon">
                                Em breve
                            </span>
                        @endif

                    </a>

                </li>



                {{-- ====================================================
                     CONFIGURAÇÕES
                ===================================================== --}}
                <li class="nav-header admin-sidebar-section admin-sidebar-section--divided">
                    Sistema
                </li>


                {{-- PERFIL --}}
                <li class="nav-item">

                    <a
                        href="{{ route('admin.perfil') }}"
                        class="nav-link admin-sidebar-link
                        {{ Request::routeIs('admin.perfil*') ? 'active' : '' }}">

                        <i class="nav-icon bi bi-person-circle"></i>

                        <p>
                            Meu Perfil
                        </p>

                    </a>

                </li>


                {{-- CONFIGURAÇÕES DA REDE --}}
                <li class="nav-item">

                    <a
                        href="{{ $rotaConfiguracoes ? route('admin.rede.configuracoes') : '#' }}"
                        class="nav-link admin-sidebar-link
                        {{ Request::routeIs('admin.rede.configuracoes') ? 'active' : '' }}
                        {{ !$rotaConfiguracoes ? 'disabled' : '' }}">

                        <i class="nav-icon bi bi-gear-fill"></i>

                        <p>
                            Configurações da Rede
                        </p>

                        @if (!$rotaConfiguracoes)
                            <span class="badge admin-sidebar-coming-soon">
                                Em breve
                            </span>
                        @endif

                    </a>

                </li>

            </ul>

        </nav>

    </div>

</aside>