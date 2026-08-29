@php
    $usuarioLogado = auth('admin')->user();

    $nomeUsuario = trim($usuarioLogado->nome_usuario ?? 'Palestrante');
    $partesNome = preg_split('/\s+/', $nomeUsuario);

    $inicial1 = mb_substr($partesNome[0] ?? '', 0, 1);
    $inicial2 = isset($partesNome[1])
        ? mb_substr($partesNome[1], 0, 1)
        : mb_substr($partesNome[0] ?? '', 1, 1);

    $iniciaisUsuario = strtoupper($inicial1 . $inicial2);

    $fotoRelativa = !empty($usuarioLogado->foto_usuario)
        ? 'dash/assets/img/' . $usuarioLogado->foto_usuario
        : null;

    $fotoExiste = $fotoRelativa
        && file_exists(public_path($fotoRelativa));

    $fotoUser = $fotoExiste
        ? asset($fotoRelativa)
        : null;
@endphp


<nav class="app-header navbar navbar-expand admin-topbar">

    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>


    <div class="container-fluid admin-topbar-container">

        <ul class="navbar-nav admin-topbar-start">

            <li class="nav-item">

                <a class="nav-link admin-topbar-icon-btn" data-lte-toggle="sidebar" href="#" role="button"
                    aria-label="Alternar menu lateral">
                    <i class="bi bi-list"></i>
                </a>

            </li>


            <li class="nav-item d-none d-md-block">

                <a href="{{ route('admin.palestrante.dash') }}"
                    class="nav-link admin-topbar-link {{ Request::routeIs('admin.palestrante.dash') ? 'active' : '' }}">
                    Início
                </a>

            </li>


            <li class="nav-item d-none d-md-block">

                <a href="{{ route('admin.palestrante.depoimento.index') }}"
                    class="nav-link admin-topbar-link {{ Request::routeIs('admin.palestrante.depoimento.*') ? 'active' : '' }}">
                    Depoimentos
                </a>

            </li>

        </ul>


        <ul class="navbar-nav ms-auto admin-topbar-end">

            {{-- SITE OFICIAL --}}
            <li class="nav-item d-none d-sm-block">

                <a class="nav-link admin-topbar-icon-btn" href="{{ route('home') }}" target="_blank"
                    rel="noopener noreferrer" aria-label="Abrir site oficial" title="Abrir site oficial">
                    <i class="bi bi-box-arrow-up-right"></i>
                </a>

            </li>


            {{-- TELA CHEIA --}}
            <li class="nav-item">

                <a class="nav-link admin-topbar-icon-btn" href="#" data-lte-toggle="fullscreen" aria-label="Tela cheia">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>

                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>

            </li>


            {{-- USUÁRIO --}}
            <li class="nav-item dropdown user-menu admin-user-menu">

                <a href="#" class="nav-link dropdown-toggle admin-user-trigger" data-bs-toggle="dropdown"
                    aria-expanded="false">

                    @if ($fotoUser)

                        <img src="{{ $fotoUser }}" class="user-image rounded-circle admin-user-image"
                            alt="{{ $nomeUsuario }}">

                    @else

                        <span class="speaker-nav-avatar">
                            {{ $iniciaisUsuario }}
                        </span>

                    @endif


                    <span class="d-none d-md-inline admin-user-name">
                        {{ $nomeUsuario }}
                    </span>

                </a>


                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end admin-user-dropdown">

                    <li class="user-header admin-user-header">

                        @if ($fotoUser)

                            <img src="{{ $fotoUser }}" class="rounded-circle admin-user-dropdown-image"
                                alt="{{ $nomeUsuario }}">

                        @else

                            <span class="speaker-nav-avatar">
                                {{ $iniciaisUsuario }}
                            </span>

                        @endif


                        <p>
                            {{ $nomeUsuario }}

                            <small>
                                Palestrante
                                @if (!empty($usuarioLogado->area_atuacao_usuario))
                                    • {{ $usuarioLogado->area_atuacao_usuario }}
                                @endif
                            </small>
                        </p>

                    </li>


                    <li class="speaker-user-summary">

                        <div class="speaker-user-summary-row">
                            <span>E-mail</span>

                            <strong>
                                {{ $usuarioLogado->email_usuario ?? 'Não informado' }}
                            </strong>
                        </div>


                        <div class="speaker-user-summary-row">
                            <span>Status</span>

                            <strong>
                                {{ $usuarioLogado->status_usuario ?? 'Não informado' }}
                            </strong>
                        </div>

                    </li>


                    <li class="user-footer admin-user-footer">

                        <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer"
                            class="btn admin-user-action admin-user-action--profile float-start">
                            Ver Site
                        </a>


                        <form id="logout-form-btn" method="POST" action="{{ route('admin.logout') }}">
                            @csrf

                            <button type="submit" class="btn admin-user-action admin-user-action--logout float-end">
                                Sair
                            </button>
                        </form>

                    </li>

                </ul>

            </li>


            {{-- TEMA --}}
            <li class="nav-item dropdown admin-theme-menu">

                <button class="btn btn-link nav-link dropdown-toggle d-flex align-items-center admin-theme-trigger"
                    id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static"
                    aria-label="Alterar tema">
                    <span class="theme-icon-active">
                        <i class="my-1"></i>
                    </span>

                    <span class="d-lg-none ms-2" id="bd-theme-text">
                        Tema
                    </span>
                </button>


                <ul class="dropdown-menu dropdown-menu-end admin-theme-dropdown" aria-labelledby="bd-theme-text">

                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center"
                            data-bs-theme-value="light" aria-pressed="false">
                            <i class="bi bi-sun-fill me-2"></i>
                            Claro
                            <i class="bi bi-check-lg ms-auto d-none"></i>
                        </button>
                    </li>


                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark"
                            aria-pressed="false">
                            <i class="bi bi-moon-fill me-2"></i>
                            Escuro
                            <i class="bi bi-check-lg ms-auto d-none"></i>
                        </button>
                    </li>


                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto"
                            aria-pressed="false">
                            <i class="bi bi-circle-half me-2"></i>
                            Automático
                            <i class="bi bi-check-lg ms-auto d-none"></i>
                        </button>
                    </li>

                </ul>

            </li>

        </ul>

    </div>

</nav>