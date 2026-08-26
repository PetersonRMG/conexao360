@php
    $usuarioLogado = auth('admin')->user();

    $fotoUser = $usuarioLogado && $usuarioLogado->foto_usuario
        ? asset('dash/assets/img/' . $usuarioLogado->foto_usuario)
        : asset('dash/assets/img/usuario/default.jpg');
@endphp

<nav class="app-header navbar navbar-expand admin-topbar">

    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
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
                <a href="{{ route('admin.dash') }}"
                    class="nav-link admin-topbar-link {{ Request::routeIs('admin.dash') ? 'active' : '' }}">
                    Home
                </a>
            </li>

            <li class="nav-item d-none d-md-block">
                <a href="#" class="nav-link admin-topbar-link">
                    Contact
                </a>
            </li>

        </ul>


        <ul class="navbar-nav ms-auto admin-topbar-end">

            <li class="nav-item">
                <a class="nav-link admin-topbar-icon-btn" data-widget="navbar-search" href="#" role="button"
                    aria-label="Pesquisar">
                    <i class="bi bi-search"></i>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link admin-topbar-icon-btn" href="#" data-lte-toggle="fullscreen" aria-label="Tela cheia">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>

                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li>


            <li class="nav-item dropdown user-menu admin-user-menu">

                <a href="#" class="nav-link dropdown-toggle admin-user-trigger" data-bs-toggle="dropdown">
                    <img src="{{ $fotoUser }}" class="user-image rounded-circle admin-user-image" alt="User Image">

                    <span class="d-none d-md-inline admin-user-name">
                        {{ $usuarioLogado->nome_usuario }}
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end admin-user-dropdown">

                    <li class="user-header admin-user-header">
                        <img src="{{ $fotoUser }}" class="rounded-circle admin-user-dropdown-image" alt="User Image">

                        <p>
                            {{ $usuarioLogado->nome_usuario }} - {{ $usuarioLogado->area_atuacao }}

                            <small>
                                Membro desde {{ $usuarioLogado->criado_em_usuario->format('m/Y') }}
                            </small>
                        </p>
                    </li>


                    <li class="user-body admin-user-body">

                        <div class="row">

                            <div class="col-4 text-center">
                                <a href="#">Seguidores</a>
                            </div>

                            <div class="col-4 text-center">
                                <a href="#">Sales</a>
                            </div>

                            <div class="col-4 text-center">
                                <a href="#">Friends</a>
                            </div>

                        </div>

                    </li>


                    <li class="user-footer admin-user-footer">

                        <a href="{{ route('admin.perfil') }}"
                            class="btn admin-user-action admin-user-action--profile float-start">
                            Perfil
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


            <li class="nav-item dropdown admin-theme-menu">

                <button class="btn btn-link nav-link dropdown-toggle d-flex align-items-center admin-theme-trigger"
                    id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown"
                    data-bs-display="static">
                    <span class="theme-icon-active">
                        <i class="my-1"></i>
                    </span>

                    <span class="d-lg-none ms-2" id="bd-theme-text">
                        Toggle theme
                    </span>
                </button>

                <ul class="dropdown-menu dropdown-menu-end admin-theme-dropdown" aria-labelledby="bd-theme-text">

                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center active"
                            data-bs-theme-value="light" aria-pressed="false">
                            <i class="bi bi-sun-fill me-2"></i>
                            Light
                            <i class="bi bi-check-lg ms-auto d-none"></i>
                        </button>
                    </li>

                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark"
                            aria-pressed="false">
                            <i class="bi bi-moon-fill me-2"></i>
                            Dark
                            <i class="bi bi-check-lg ms-auto d-none"></i>
                        </button>
                    </li>

                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto"
                            aria-pressed="true">
                            <i class="bi bi-circle-fill-half-stroke me-2"></i>
                            Auto
                            <i class="bi bi-check-lg ms-auto d-none"></i>
                        </button>
                    </li>

                </ul>

            </li>

        </ul>

    </div>

</nav>