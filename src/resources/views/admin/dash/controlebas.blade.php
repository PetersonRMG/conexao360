@extends('layout.admin')
@section('title', 'Home')
@section('pg-titulo', 'Home')
@section('link-topo', 'Home')

@section('content')
    <main class="app-main dash-page">
        <div class="app-content container-fluid">

            <div class="dash-page">

                {{-- =========================================================
                     CABEÇALHO
                ========================================================== --}}
                <header class="dash-page-header">
                    <div class="dash-page-heading">
                        <span class="dash-eyebrow">
                            <i class="bi bi-grid-1x2-fill"></i>
                            Dashboard
                        </span>

                        <h3 class="dash-title dash-title--sm">
                            Visão Geral
                        </h3>

                        <p class="dash-subtitle">
                            Monitore as métricas, engajamento e atividades da sua plataforma.
                        </p>
                    </div>

                    <div class="dash-date-pill">
                        <i class="bi bi-calendar3"></i>
                        <span>
                            {{ \Carbon\Carbon::now()
                                ->locale('pt_BR')
                                ->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                        </span>
                    </div>
                </header>


                {{-- =========================================================
                     CARDS DE ESTATÍSTICAS
                ========================================================== --}}
                <section class="dash-stats-grid" aria-label="Resumo das métricas">

                    <article class="dash-stat-card dash-stat-card--success">
                        <div class="dash-stat-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>

                        <div class="dash-stat-body">
                            <span class="dash-stat-label">Membros Ativos</span>

                            <strong class="dash-stat-value">
                                {{ $usuario->count() }}
                            </strong>

                            <span class="dash-stat-description">
                                <i class="bi bi-arrow-up"></i>
                                Usuários cadastrados
                            </span>
                        </div>
                    </article>


                    <article class="dash-stat-card dash-stat-card--warning">
                        <div class="dash-stat-icon">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>

                        <div class="dash-stat-body">
                            <span class="dash-stat-label">Aguardando Moderação</span>

                            <strong class="dash-stat-value">
                                {{ 7 }}
                            </strong>

                            <span class="dash-stat-description">
                                <i class="bi bi-clock"></i>
                                Requer atenção
                            </span>
                        </div>
                    </article>


                    <article class="dash-stat-card dash-stat-card--info">
                        <div class="dash-stat-icon">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>

                        <div class="dash-stat-body">
                            <span class="dash-stat-label">Novos este Mês</span>

                            <strong class="dash-stat-value">
                                +84
                            </strong>

                            <span class="dash-stat-description">
                                <i class="bi bi-graph-up-arrow"></i>
                                Crescimento mensal
                            </span>
                        </div>
                    </article>


                        <a href="{{ route ('admin.depoimentos.index')}}">
                    <article class="dash-stat-card dash-stat-card--primary">
                            <div class="dash-stat-icon">
                                <i class="bi bi-chat-quote-fill"></i>
                            </div>
                            <div class="dash-stat-body">
                                <span class="dash-stat-label">Depoimentos no Site</span>
                                <strong class="dash-stat-value">
                                    {{ $depoimentos->count() }}
                                </strong>
                                <span class="dash-stat-description">
                                    <i class="bi bi-chat-quote"></i>
                                    Publicados
                                </span>
                            </div>
                    </article>
                        </a>

                </section>


                {{-- =========================================================
                     PAINÉIS PRINCIPAIS
                ========================================================== --}}
                <section class="dash-panels-grid">

                    {{-- =====================================================
                         PUBLICAÇÕES RECENTES
                    ====================================================== --}}
                    <section class="dash-panel">

                        <header class="dash-panel-header">
                            <div class="dash-panel-heading">
<h5 class="dash-panel-title">
    Usuários Recentes
</h5>

<small class="dash-panel-subtitle">
    Usuários cadastrados recentemente
</small>
                            </div>

                            <div class="dash-panel-tools">
<span class="dash-badge">
    {{ $usuario->count() }} usuários
</span>

<a href="#" class="dash-panel-link">
    Ver todos
    <i class="bi bi-arrow-right"></i>
</a>
                            </div>
                        </header>

<div class="dash-table-wrap">
    <table class="dash-table">
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Área de Atuação</th>
                <th>Cadastro</th>
                <th>Status</th>
                <th class="text-end">Ação</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($usuario->sortByDesc('criado_em_usuario')->take(5) as $item)

                @php
                    $nomeCompleto = trim($item->nome_usuario ?? 'Usuário');

                    $partesNome = preg_split('/\s+/', $nomeCompleto);

                    $inicial1 = mb_substr($partesNome[0] ?? '', 0, 1);

                    $inicial2 = isset($partesNome[1])
                        ? mb_substr($partesNome[1], 0, 1)
                        : mb_substr($partesNome[0] ?? '', 1, 1);

                    $iniciais = strtoupper($inicial1 . $inicial2);

                    $status = strtolower(trim($item->status_usuario ?? ''));

                    $statusClasse = match ($status) {
                        'ativo', '1', 'active' => 'dash-status--approved',
                        'inativo', '0', 'inactive' => 'dash-status--rejected',
                        default => 'dash-status--pending',
                    };

                    $statusIcone = match ($status) {
                        'ativo', '1', 'active' => 'bi-check-circle ',
                        'inativo', '0', 'inactive' => 'bi-x-circle',
                        default => 'bi-clock-history',
                    };

                    $statusTexto = match ($status) {
                        'ativo', '1', 'active' => 'Ativo',
                        'inativo', '0', 'inactive' => 'Inativo',
                        default => $item->status_usuario ?: 'Pendente',
                    };
                @endphp

                <tr class="dash-table-row">

                    {{-- USUÁRIO --}}
                    <td>
                        <div class="dash-author">

                            @if (!empty($item->foto_usuario))
                                <img
                                    src="{{ asset($item->foto_usuario) }}"
                                    alt="{{ $item->nome_usuario }}"
                                    class="dash-avatar dash-avatar--image"
                                >
                            @else
                                <div class="dash-avatar dash-avatar--primary">
                                    {{ $iniciais }}
                                </div>
                            @endif

                            <div>
                                <span class="dash-author-name">
                                    {{ $item->nome_usuario }}
                                </span>

                                <small class="dash-author-meta">
                                    {{ $item->email_usuario }}
                                </small>
                            </div>

                        </div>
                    </td>


                    {{-- ÁREA DE ATUAÇÃO --}}
                    <td class="dash-cell-truncate">
                        {{ $item->area_atuacao_usuario ?: 'Não informado' }}
                    </td>


                    {{-- DATA DE CADASTRO --}}
                    <td class="dash-cell-muted">
                        @if ($item->criado_em_usuario)
                            {{ \Carbon\Carbon::parse($item->criado_em_usuario)->locale('pt_BR')->diffForHumans() }}
                        @else
                            Não informado
                        @endif
                    </td>


                    {{-- STATUS --}}
                    <td >
                        <span class="dash-status {{ $statusClasse }}  ">
                            <i class="bi {{ $statusIcone }}"></i>
                            {{ $statusTexto }}
                        </span>
                    </td>


                    {{-- AÇÃO --}}
                    <td class="text-end">
                        <a href="#" class="dash-action-btn">
                            <i class="bi bi-eye"></i>
                            Visualizar
                        </a>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5">
                        <div class="dash-empty-state">
                            <div class="dash-empty-icon">
                                <i class="bi bi-people"></i>
                            </div>

                            <h5>Nenhum usuário encontrado.</h5>

                            <p class="dash-empty-text">
                                Ainda não existem usuários cadastrados.
                            </p>
                        </div>
                    </td>
                </tr>

            @endforelse
        </tbody>
    </table>
</div>

                    </section>


                    {{-- =====================================================
                         NOVOS MEMBROS
                    ====================================================== --}}
                    <section class="dash-panel">

                        <header class="dash-panel-header">
                            <div class="dash-panel-heading">
                                <h5 class="dash-panel-title">
                                    Novos Membros
                                </h5>

                                <small class="dash-panel-subtitle">
                                    Usuários cadastrados recentemente
                                </small>
                            </div>

                            <span class="dash-badge">
                                {{ $usuarioNovos->count() }}
                            </span>
                        </header>


                        <div class="dash-member-list">
                            @forelse ($usuarioNovos as $item)

                                @php
                                    $partesNome = explode(' ', trim($item->nome_usuario));

                                    $inicial1 = mb_substr(
                                        $partesNome[0],
                                        0,
                                        1
                                    );

                                    $inicial2 = isset($partesNome[1])
                                        ? mb_substr($partesNome[1], 0, 1)
                                        : mb_substr($partesNome[0], 1, 1);

                                    $iniciais = strtoupper($inicial1 . $inicial2);
                                @endphp

                                <div class="dash-member-item">
                                    <div class="dash-member-avatar">
                                        {{ $iniciais }}
                                    </div>

                                    <div class="dash-member-info">
                                        <h6 class="dash-member-name">
                                            {{ $item->nome_usuario }}
                                        </h6>

                                        <small class="dash-member-meta">
                                            Membro VIP

                                            @if($item->estado_usuario)
                                                <span class="dash-member-separator">•</span>
                                                {{ $item->estado_usuario }}
                                            @endif
                                        </small>
                                    </div>

                                    <i class="bi bi-chevron-right dash-chevron"></i>
                                </div>

                            @empty

                                <div class="dash-empty-state">
                                    <div class="dash-empty-icon">
                                        <i class="bi bi-people"></i>
                                    </div>

                                    <h5>Nenhum membro recente.</h5>

                                    <p class="dash-empty-text">
                                        Novos usuários aparecerão aqui.
                                    </p>
                                </div>

                            @endforelse
                        </div>


                        @if($usuarioNovos->count() > 0)
                            <footer class="dash-panel-footer">
                                <a href="#" class="dash-panel-link">
                                    Ver todos os membros
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </footer>
                        @endif

                    </section>

                </section>

            </div>
        </div>
    </main>
@endsection