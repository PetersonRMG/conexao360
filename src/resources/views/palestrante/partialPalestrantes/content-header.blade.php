{{-- ============================================================
     CABEÇALHO INTERNO DA PÁGINA
============================================================= --}}
<div class="app-content-header admin-page-header ">

    <div class="container-fluid">

        <div class="admin-page-header-inner">

            {{-- TÍTULO --}}
            <div class="admin-page-heading">

                <span class="admin-page-eyebrow">
                    <i class="bi bi-grid-1x2-fill"></i>
                    Painel Administrativo
                </span>

                <h1 class="admin-page-title">
                    @yield('pg-titulo', 'Dashboard Conexão 360')
                </h1>

            </div>


            {{-- BREADCRUMB --}}
            <nav
                class="admin-page-breadcrumb-nav"
                aria-label="breadcrumb"
            >

                <ol class="breadcrumb admin-page-breadcrumb">

                    <li class="breadcrumb-item">

                        <a href="{{ route('admin.dash') }}">

                            <i class="bi bi-house-door"></i>

                            <span>
                                Home
                            </span>

                        </a>

                    </li>


                    <li
                        class="breadcrumb-item active"
                        aria-current="page"
                    >

                        <span>
                            @yield('link-topo', 'Dashboard')
                        </span>

                    </li>

                </ol>

            </nav>

        </div>

    </div>

</div>