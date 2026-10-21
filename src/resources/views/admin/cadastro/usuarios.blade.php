@extends('layout.admin')

@section('title', 'Membros')
@section('pg-titulo', 'Membros')
@section('link-topo', 'Membros')


@section('content')

<div class="site-editor-main">

    <div class="site-editor-page">

        <div class="site-editor">


            {{-- =====================================================
                 CABEÇALHO
            ====================================================== --}}

            <div class="site-editor-tabs-header mb-4">

                <div class="site-editor-tabs-title">

                    <i class="bi bi-people"></i>

                    <div>

                        <strong>
                            Membros do aplicativo
                        </strong>

                        <span>
                            Acompanhe os usuários cadastrados no
                            Conexão 360° e monitore novos cadastros.
                        </span>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 INDICADORES
            ====================================================== --}}

            <section class="mb-4">

                <div class="site-editor-section-header">

                    <div>

                        <div class="site-editor-section-icon">
                            <i class="bi bi-bar-chart"></i>
                        </div>

                        <div>

                            <h4>
                                Visão geral
                            </h4>

                            <p>
                                Resumo dos usuários cadastrados na plataforma.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="row g-3">


                    {{-- TOTAL --}}

                    <div class="col-12 col-md-6 col-xl-3">

                        <div class="site-editor-card h-100">

                            <div
                                class="
                                    d-flex
                                    align-items-center
                                    justify-content-between
                                    gap-3
                                "
                            >

                                <div>

                                    <div class="form-text mb-2">
                                        Total de membros
                                    </div>

                                    <h2 class="mb-0">
                                        {{ $totalUsuarios }}
                                    </h2>

                                </div>


                                <div class="site-editor-section-icon mb-0">

                                    <i class="bi bi-people-fill"></i>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- NOVOS ESTE MÊS --}}

                    <div class="col-12 col-md-6 col-xl-3">

                        <a
                            href="{{ route(
                                'admin.cadastro.usuarios',
                                ['periodo' => 'mes']
                            ) }}"
                            class="text-decoration-none"
                        >

                            <div class="site-editor-card h-100">

                                <div
                                    class="
                                        d-flex
                                        align-items-center
                                        justify-content-between
                                        gap-3
                                    "
                                >

                                    <div>

                                        <div class="form-text mb-2">
                                            Novos este mês
                                        </div>

                                        <h2 class="mb-0">
                                            {{ $novosEsteMes }}
                                        </h2>

                                    </div>


                                    <div class="site-editor-section-icon mb-0">

                                        <i class="bi bi-person-plus-fill"></i>

                                    </div>

                                </div>

                            </div>

                        </a>

                    </div>


                    {{-- ATIVOS --}}

                    <div class="col-12 col-md-6 col-xl-3">

                        <a
                            href="{{ route(
                                'admin.cadastro.usuarios',
                                ['status' => 'ATIVO']
                            ) }}"
                            class="text-decoration-none"
                        >

                            <div class="site-editor-card h-100">

                                <div
                                    class="
                                        d-flex
                                        align-items-center
                                        justify-content-between
                                        gap-3
                                    "
                                >

                                    <div>

                                        <div class="form-text mb-2">
                                            Usuários ativos
                                        </div>

                                        <h2 class="mb-0">
                                            {{ $usuariosAtivos }}
                                        </h2>

                                    </div>


                                    <div class="site-editor-section-icon mb-0">

                                        <i class="bi bi-person-check-fill"></i>

                                    </div>

                                </div>

                            </div>

                        </a>

                    </div>


                    {{-- NÃO ATIVOS --}}

                    <div class="col-12 col-md-6 col-xl-3">

                        <div class="site-editor-card h-100">

                            <div
                                class="
                                    d-flex
                                    align-items-center
                                    justify-content-between
                                    gap-3
                                "
                            >

                                <div>

                                    <div class="form-text mb-2">
                                        Não ativos
                                    </div>

                                    <h2 class="mb-0">
                                        {{ $usuariosNaoAtivos }}
                                    </h2>

                                </div>


                                <div class="site-editor-section-icon mb-0">

                                    <i class="bi bi-person-dash-fill"></i>

                                </div>

                            </div>

                        </div>

                    </div>


                </div>

            </section>


            {{-- =====================================================
                 FILTROS
            ====================================================== --}}

            <section class="mb-4">

                <div class="site-editor-section-header">

                    <div>

                        <div class="site-editor-section-icon">
                            <i class="bi bi-funnel"></i>
                        </div>

                        <div>

                            <h4>
                                Filtros
                            </h4>

                            <p>
                                Localize usuários por nome, perfil,
                                status ou período de cadastro.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="site-editor-card">

                    <form
                        action="{{ route('admin.cadastro.usuarios') }}"
                        method="GET"
                    >

                        <div class="row g-4">


                            {{-- BUSCA --}}

                            <div class="col-12 col-xl-4">

                                <label
                                    for="busca"
                                    class="form-label"
                                >
                                    Buscar membro
                                </label>

                                <input
                                    type="text"
                                    name="busca"
                                    id="busca"
                                    class="form-control"
                                    value="{{ $busca }}"
                                    placeholder="Nome, e-mail ou área de atuação"
                                >

                            </div>


                            {{-- PERFIL --}}

                            <div class="col-12 col-md-4 col-xl-2">

                                <label
                                    for="perfil"
                                    class="form-label"
                                >
                                    Perfil
                                </label>

                                <select
                                    name="perfil"
                                    id="perfil"
                                    class="form-select"
                                >

                                    <option value="">
                                        Todos
                                    </option>


                                    @foreach ($perfisDisponiveis as $perfilDisponivel)

                                        <option
                                            value="{{ $perfilDisponivel }}"
                                            @selected(
                                                $perfil === $perfilDisponivel
                                            )
                                        >

                                            {{ ucfirst($perfilDisponivel) }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- STATUS --}}

                            <div class="col-12 col-md-4 col-xl-2">

                                <label
                                    for="status"
                                    class="form-label"
                                >
                                    Status
                                </label>

                                <select
                                    name="status"
                                    id="status"
                                    class="form-select"
                                >

                                    <option value="">
                                        Todos
                                    </option>


                                    @foreach ($statusDisponiveis as $statusDisponivel)

                                        <option
                                            value="{{ $statusDisponivel }}"
                                            @selected(
                                                $status === $statusDisponivel
                                            )
                                        >

                                            {{
                                                ucfirst(
                                                    strtolower(
                                                        $statusDisponivel
                                                    )
                                                )
                                            }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- PERÍODO --}}

                            <div class="col-12 col-md-4 col-xl-2">

                                <label
                                    for="periodo"
                                    class="form-label"
                                >
                                    Cadastro
                                </label>

                                <select
                                    name="periodo"
                                    id="periodo"
                                    class="form-select"
                                >

                                    <option
                                        value=""
                                        @selected($periodo === '')
                                    >
                                        Todos
                                    </option>

                                    <option
                                        value="hoje"
                                        @selected($periodo === 'hoje')
                                    >
                                        Hoje
                                    </option>

                                    <option
                                        value="7dias"
                                        @selected($periodo === '7dias')
                                    >
                                        Últimos 7 dias
                                    </option>

                                    <option
                                        value="mes"
                                        @selected($periodo === 'mes')
                                    >
                                        Novos este mês
                                    </option>

                                </select>

                            </div>


                            {{-- BOTÕES --}}

                            <div
                                class="
                                    col-12
                                    col-xl-2
                                    d-flex
                                    align-items-end
                                    gap-2
                                "
                            >

                                <button
                                    type="submit"
                                    class="btn-site-editor-save flex-grow-1"
                                >

                                    <i class="bi bi-funnel-fill"></i>

                                    Filtrar

                                </button>


                                <a
                                    href="{{ route(
                                        'admin.cadastro.usuarios'
                                    ) }}"
                                    class="publication-manager-button"
                                    title="Limpar filtros"
                                >

                                    <i class="bi bi-x-lg"></i>

                                </a>

                            </div>


                        </div>

                    </form>

                </div>

            </section>


            {{-- =====================================================
                 USUÁRIOS CADASTRADOS
            ====================================================== --}}

            <section>

                <div class="site-editor-section-header">

                    <div>

                        <div class="site-editor-section-icon">
                            <i class="bi bi-people"></i>
                        </div>

                        <div>

                            <h4>
                                Usuários cadastrados
                            </h4>

                            <p>
                                Visualize os membros cadastrados
                                atualmente no aplicativo.
                            </p>

                        </div>

                    </div>


                    <span class="publication-total">

                        {{ $usuarios->total() }}

                        {{
                            $usuarios->total() === 1
                                ? 'usuário'
                                : 'usuários'
                        }}

                    </span>

                </div>


                <div class="site-editor-card p-0">

                    <div class="table-responsive">

                        <table
                            class="
                                table
                                table-dark
                                table-hover
                                align-middle
                                mb-0
                            "
                        >

                            <thead>

                                <tr>

                                    <th class="ps-4">
                                        Membro
                                    </th>

                                    <th>
                                        E-mail
                                    </th>

                                    <th>
                                        Área de atuação
                                    </th>

                                    <th>
                                        Perfil
                                    </th>

                                    <th>
                                        Estado
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th class="pe-4">
                                        Cadastro
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse ($usuarios as $usuario)

                                    @php
                                        $dataCadastro = $usuario->criado_em_usuario
                                            ? \Carbon\Carbon::parse(
                                                $usuario->criado_em_usuario
                                            )
                                            : null;

                                        $novoEsteMes = $dataCadastro
                                            && $dataCadastro->isCurrentMonth();

                                        $statusUsuario = strtoupper(
                                            (string) $usuario->status_usuario
                                        );
                                    @endphp


                                    <tr>


                                        {{-- MEMBRO --}}

                                        <td class="ps-4">

                                            <div
                                                class="
                                                    d-flex
                                                    align-items-center
                                                    gap-3
                                                "
                                            >

                                                <div class="publication-manager-avatar">

                                                    {{
                                                        strtoupper(
                                                            substr(
                                                                $usuario->nome_usuario
                                                                    ?? 'U',
                                                                0,
                                                                1
                                                            )
                                                        )
                                                    }}

                                                </div>


                                                <div class="publication-manager-author-info">

                                                    <strong>

                                                        {{
                                                            $usuario->nome_usuario
                                                                ?: 'Usuário sem nome'
                                                        }}

                                                    </strong>


                                                    <span>

                                                        ID #{{ $usuario->id_usuario }}

                                                    </span>


                                                    @if ($novoEsteMes)

                                                        <span
                                                            class="
                                                                publication-total
                                                                mt-1
                                                            "
                                                        >
                                                            Novo
                                                        </span>

                                                    @endif

                                                </div>

                                            </div>

                                        </td>


                                        {{-- E-MAIL --}}

                                        <td>

                                            {{
                                                $usuario->email_usuario
                                                    ?: '-'
                                            }}

                                        </td>


                                        {{-- ÁREA --}}

                                        <td>

                                            {{
                                                $usuario->area_atuacao_usuario
                                                    ?: 'Não informada'
                                            }}

                                        </td>


                                        {{-- PERFIL --}}

                                        <td>

                                            <span class="publication-total">

                                                {{
                                                    ucfirst(
                                                        $usuario->perfil_usuario
                                                            ?: 'usuario'
                                                    )
                                                }}

                                            </span>

                                        </td>


                                        {{-- ESTADO --}}

                                        <td>

                                            {{
                                                $usuario->estado_usuario
                                                    ?: '-'
                                            }}

                                        </td>


                                        {{-- STATUS --}}

                                        <td>

                                            @if ($statusUsuario === 'ATIVO')

                                                <span
                                                    class="
                                                        publication-status-pill
                                                        publication-status-pill--active
                                                    "
                                                >

                                                    <i class="bi bi-circle-fill"></i>

                                                    Ativo

                                                </span>

                                            @else

                                                <span
                                                    class="
                                                        publication-status-pill
                                                        publication-status-pill--hidden
                                                    "
                                                >

                                                    <i class="bi bi-circle-fill"></i>

                                                    {{
                                                        ucfirst(
                                                            strtolower(
                                                                $usuario->status_usuario
                                                                    ?: 'Inativo'
                                                            )
                                                        )
                                                    }}

                                                </span>

                                            @endif

                                        </td>


                                        {{-- CADASTRO --}}

                                        <td class="pe-4">

                                            @if ($dataCadastro)

                                                <strong>
                                                    {{
                                                        $dataCadastro->format(
                                                            'd/m/Y'
                                                        )
                                                    }}
                                                </strong>

                                                <div class="form-text">

                                                    {{
                                                        $dataCadastro->format(
                                                            'H:i'
                                                        )
                                                    }}

                                                </div>

                                            @else

                                                -

                                            @endif

                                        </td>


                                    </tr>

                                @empty


                                    <tr>

                                        <td
                                            colspan="7"
                                            class="text-center py-5"
                                        >

                                            <div class="publication-manager-empty">

                                                <i class="bi bi-people"></i>

                                                <strong>
                                                    Nenhum usuário encontrado
                                                </strong>

                                                <span>
                                                    Tente alterar ou limpar
                                                    os filtros utilizados.
                                                </span>

                                            </div>

                                        </td>

                                    </tr>


                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    {{-- =================================================
                         PAGINAÇÃO
                    ================================================== --}}

                    @if ($usuarios->hasPages())

                        <div class="p-4">

                            {{
                                $usuarios
                                    ->onEachSide(1)
                                    ->links('pagination::bootstrap-5')
                            }}

                        </div>

                    @endif

                </div>

            </section>


        </div>

    </div>

</div>

@endsection