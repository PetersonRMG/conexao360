{{-- ============================================================
CABEÇALHO INTERNO — PALESTRANTE
============================================================= --}}
<div class="app-content-header admin-page-header">

    <div class="container-fluid">

        <div class="admin-page-header-inner">

            <div class="admin-page-heading">

                <span class="admin-page-eyebrow">
                    <i class="bi bi-mic-fill"></i>
                    Área do Palestrante
                </span>

                <h1 class="admin-page-title">
                    @yield('pg-titulo', 'Visão Geral')
                </h1>

            </div>


            <nav class="admin-page-breadcrumb-nav" aria-label="breadcrumb">

                <ol class="breadcrumb admin-page-breadcrumb">

                    <li class="breadcrumb-item">

                        <a href="{{ route('admin.palestrante.dash') }}">

                            <i class="bi bi-house-door"></i>

                            <span>
                                Início
                            </span>

                        </a>

                    </li>


                    <li class="breadcrumb-item active" aria-current="page">
                        <span>
                            @yield('link-topo', 'Visão Geral')
                        </span>
                    </li>

                </ol>

            </nav>

        </div>

    </div>

</div>