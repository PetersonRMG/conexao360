@extends('layout.admin')

@section('title', 'Dashboard')
@section('pg-titulo', 'Dashboard')
@section('link-topo', 'Dashboard')

@section('content')
@php
    /* Dados reais: consultas somente de leitura, sem alterar migrations ou controllers. */
    $inicioHistorico = now()->startOfMonth()->subMonthsNoOverflow(5);
    $cadastrosAgrupados = \Illuminate\Support\Facades\DB::table('tbl_usuarios')
        ->where('criado_em_usuario', '>=', $inicioHistorico->toDateTimeString())
        ->selectRaw("DATE_FORMAT(criado_em_usuario, '%Y-%m') AS mes, COUNT(*) AS total")
        ->groupBy('mes')
        ->pluck('total', 'mes');

    $mesesGrafico = [];
    $serieCadastros = [];
    for ($i = 0; $i < 6; $i++) {
        $mes = $inicioHistorico->copy()->addMonthsNoOverflow($i);
        $mesesGrafico[] = ucfirst($mes->locale('pt_BR')->translatedFormat('M'));
        $serieCadastros[] = (int) ($cadastrosAgrupados[$mes->format('Y-m')] ?? 0);
    }

    $escalaMax = max(1, max($serieCadastros));
    $pontosGrafico = [];
    foreach ($serieCadastros as $indice => $quantidade) {
        $x = round(34 + ($indice * 120), 2);
        $y = round(144 - ($quantidade / $escalaMax * 112), 2);
        $pontosGrafico[] = ['x' => $x, 'y' => $y, 'valor' => $quantidade];
    }
    $linhaGrafico = collect($pontosGrafico)->map(fn ($p) => $p['x'] . ',' . $p['y'])->implode(' ');
    $areaGrafico = '34,144 ' . $linhaGrafico . ' 634,144';

    $totalUsuariosGrafico = max(0, (int) $totalUsuarios);
    $usuariosAtivosGrafico = max(0, min($totalUsuariosGrafico, (int) $usuariosAtivos));
    $usuariosInativosGrafico = $totalUsuariosGrafico - $usuariosAtivosGrafico;
    $percentualAtivos = $totalUsuariosGrafico > 0 ? round($usuariosAtivosGrafico * 100 / $totalUsuariosGrafico, 1) : 0;
    $percentualInativos = $totalUsuariosGrafico > 0 ? round($usuariosInativosGrafico * 100 / $totalUsuariosGrafico, 1) : 0;

    $atividadesDashboard = collect();
    foreach ($usuariosRecentes as $usuario) {
        if (!empty($usuario->criado_em_usuario)) {
            $atividadesDashboard->push([
                'tipo' => 'usuario',
                'titulo' => 'Novo membro: ' . ($usuario->nome_usuario ?: 'Usuário'),
                'descricao' => ucfirst($usuario->perfil_usuario ?: 'Usuário'),
                'data' => \Carbon\Carbon::parse($usuario->criado_em_usuario),
                'url' => route('admin.cadastro.usuarios'),
            ]);
        }
    }
    foreach ($publicacoesRecentes as $publicacao) {
        if (!empty($publicacao->criado_em_publicacao)) {
            $atividadesDashboard->push([
                'tipo' => 'publicacao',
                'titulo' => 'Publicação de ' . ($publicacao->usuario?->nome_usuario ?? 'Usuário'),
                'descricao' => \Illuminate\Support\Str::limit($publicacao->texto_publicacao ?: 'Publicação com mídia', 75),
                'data' => \Carbon\Carbon::parse($publicacao->criado_em_publicacao),
                'url' => route('admin.publicacoes.index'),
            ]);
        }
    }
    $atividadesDashboard = $atividadesDashboard->sortByDesc('data')->take(5);

    $eventosAgenda = \Illuminate\Support\Facades\DB::table('tbl_eventos')
        ->where('status_evento', 'ATIVO')
        ->where('data_termino_evento', '>=', now()->toDateString())
        ->orderBy('data_inicial_evento')
        ->limit(3)
        ->get();
@endphp

<style>
    /* Isolado nesta view: não modifica outras telas, o menu ou o cabeçalho. */
    .dashv2 {
        --v2-surface: var(--site-editor-surface, #ffffff);
        --v2-soft: var(--site-editor-surface-2, #f7f3ed);
        --v2-border: var(--site-editor-border, #e5ddd3);
        --v2-text: var(--site-editor-text, #2b2926);
        --v2-muted: var(--site-editor-text-muted, var(--site-editor-text-soft, #77716a));
        --v2-gold: var(--site-editor-primary, #b18a3c);
        --v2-shadow: 0 6px 24px rgba(45, 32, 15, .045);
        color: var(--v2-text);
        width: 100%;
    }
    [data-bs-theme="dark"] .dashv2 {
        --v2-surface: var(--site-editor-surface, #191919);
        --v2-soft: var(--site-editor-surface-2, #24221f);
        --v2-border: var(--site-editor-border, #3b3730);
        --v2-text: var(--site-editor-text, #f4f1eb);
        --v2-muted: var(--site-editor-text-muted, var(--site-editor-text-soft, #aaa59d));
        --v2-gold: var(--site-editor-primary, #d5af62);
        --v2-shadow: 0 6px 24px rgba(0, 0, 0, .14);
    }
    .dashv2 *, .dashv2 *::before, .dashv2 *::after { box-sizing: border-box; }
    .dashv2 .dashv2-head { display:flex; align-items:end; justify-content:space-between; gap:20px; flex-wrap:wrap; margin: 0 0 23px; }
    .dashv2 .dashv2-kicker { display:block; text-transform:uppercase; letter-spacing:.12em; font-size:.76rem; font-weight:800; color:var(--v2-gold); margin-bottom:5px; }
    .dashv2 .dashv2-title { margin:0; color:var(--v2-text); font:700 clamp(1.75rem, 2.5vw, 2.3rem)/1.2 Georgia,serif; }
    .dashv2 .dashv2-lead { margin:8px 0 0; color:var(--v2-muted); font-size:.92rem; }
    .dashv2 .dashv2-date { display:inline-flex;align-items:center;gap:9px;padding:12px 15px;border:1px solid var(--v2-border);border-radius:10px;background:var(--v2-surface);color:var(--v2-muted);font-size:.82rem;box-shadow:var(--v2-shadow); }
    .dashv2 .dashv2-date i { color:var(--v2-gold); }
    .dashv2 .dashv2-kpis { display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:15px;margin-bottom:17px; }
    .dashv2 .dashv2-kpi { display:flex;align-items:center;gap:16px;min-width:0;padding:21px 19px;background:var(--v2-surface);color:var(--v2-text);border:1px solid var(--v2-border);border-left:3px solid var(--v2-gold);border-radius:13px;box-shadow:var(--v2-shadow);height:100%;text-decoration:none;transition:transform .15s,border-color .15s; }
    .dashv2 a.dashv2-kpi:hover,.dashv2 a.dashv2-module:hover { transform:translateY(-2px);border-color:var(--v2-gold);color:var(--v2-text); }
    .dashv2 .dashv2-kpi-icon { display:grid;place-items:center;flex-shrink:0;width:46px;height:46px;border-radius:12px;background:var(--v2-soft);color:var(--v2-gold);font-size:1.25rem; }
    .dashv2 .dashv2-kpi--success {border-left-color:#31a269;}.dashv2 .dashv2-kpi--success .dashv2-kpi-icon {color:#268a55;background:rgba(49,162,105,.10);}
    .dashv2 .dashv2-kpi--info {border-left-color:#408bd4;}.dashv2 .dashv2-kpi--info .dashv2-kpi-icon {color:#408bd4;background:rgba(64,139,212,.10);}
    .dashv2 .dashv2-kpi--danger {border-left-color:#c75b52;}.dashv2 .dashv2-kpi--danger .dashv2-kpi-icon {color:#c75b52;background:rgba(199,91,82,.10);}
    .dashv2 .dashv2-kpi-label {display:block;font-size:.8rem;color:var(--v2-muted);font-weight:700;}
    .dashv2 .dashv2-kpi-value {display:block;font-size:1.85rem;font-weight:800;line-height:1.2;margin:3px 0;color:var(--v2-text);font-variant-numeric:tabular-nums;}
    .dashv2 .dashv2-kpi-foot {display:block;font-size:.77rem;color:var(--v2-muted);}
    .dashv2 .dashv2-kpi-foot i {color:var(--v2-gold);margin-right:4px;}
    .dashv2 .dashv2-analytics {display:grid;grid-template-columns:minmax(0,1.7fr) minmax(260px,1fr);gap:16px;margin-bottom:16px;}
    .dashv2 .dashv2-panel {min-width:0;border:1px solid var(--v2-border);border-radius:14px;background:var(--v2-surface);box-shadow:var(--v2-shadow);overflow:hidden;}
    .dashv2 .dashv2-panel-pad {padding:19px 21px;}
    .dashv2 .dashv2-panel-title {display:flex;gap:11px;align-items:center;min-width:0;}
    .dashv2 .dashv2-section-icon {width:38px;height:38px;display:grid;place-items:center;flex-shrink:0;border:1px solid var(--v2-border);border-radius:10px;background:var(--v2-soft);color:var(--v2-gold);font-size:1.1rem;}
    .dashv2 h3 {font-size:1.02rem;font-weight:750;color:var(--v2-text);margin:0;}
    .dashv2 .dashv2-hint {display:block;color:var(--v2-muted);font-size:.78rem;margin-top:3px;}
    .dashv2 .dashv2-header-row {display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;}
    .dashv2 .dashv2-mini-label {padding:6px 10px;border:1px solid var(--v2-border);border-radius:8px;color:var(--v2-muted);font-size:.74rem;white-space:nowrap;}
    .dashv2 .dashv2-chart {display:block;width:100%;height:auto;min-height:170px;margin-top:6px;overflow:visible;}
    .dashv2 .dashv2-chart text {fill:var(--v2-muted);font-size:12px;}
    .dashv2 .dashv2-chart .dashv2-gridline {stroke:var(--v2-border);stroke-width:1;}
    .dashv2 .dashv2-chart .dashv2-line {fill:none;stroke:var(--v2-gold);stroke-width:3;stroke-linecap:round;stroke-linejoin:round;}
    .dashv2 .dashv2-chart .dashv2-dot {fill:var(--v2-gold);stroke:var(--v2-surface);stroke-width:3;}
    .dashv2 .dashv2-months {display:grid;grid-template-columns:repeat(6,1fr);padding-left:8px;margin-top:-5px;color:var(--v2-muted);font-size:.73rem;text-align:center;}
    .dashv2 .dashv2-donut-flex {display:flex;gap:24px;align-items:center;justify-content:center;min-height:205px;padding-top:10px;flex-wrap:wrap;}
    .dashv2 .dashv2-donut {position:relative;flex-shrink:0;width:160px;height:160px;border-radius:50%;background:conic-gradient(#37a467 0 var(--percent-active), var(--v2-border) var(--percent-active) 100%);display:grid;place-items:center;}
    .dashv2 .dashv2-donut::before {content:'';position:absolute;inset:23px;border-radius:50%;background:var(--v2-surface);}
    .dashv2 .dashv2-donut-value {position:relative;z-index:1;text-align:center;}
    .dashv2 .dashv2-donut-value strong {display:block;color:var(--v2-text);font-size:1.8rem;line-height:1;}
    .dashv2 .dashv2-donut-value small {display:block;color:var(--v2-muted);margin-top:6px;}
    .dashv2 .dashv2-legend {display:grid;gap:12px;min-width:125px;flex:1;max-width:200px;}
    .dashv2 .dashv2-legend-line {display:grid;grid-template-columns:10px 1fr auto;gap:8px;align-items:center;font-size:.83rem;color:var(--v2-text);}
    .dashv2 .dashv2-legend-line strong {font-variant-numeric:tabular-nums;}
    .dashv2 .dashv2-dot-legend {width:10px;height:10px;border-radius:50%;background:#37a467;}
    .dashv2 .dashv2-dot-legend--off {background:#a6a39e;}
    .dashv2 .dashv2-legend-line small {grid-column:2 / -1;color:var(--v2-muted);font-size:.75rem;margin-top:-5px;}
    .dashv2 .dashv2-module-panel {margin-bottom:16px;}
    .dashv2 .dashv2-modules {display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:10px;margin-top:17px;}
    .dashv2 .dashv2-module {display:flex;align-items:center;gap:10px;position:relative;padding:14px 10px;border:1px solid var(--v2-border);border-radius:11px;background:var(--v2-soft);text-decoration:none;color:var(--v2-text);min-width:0;transition:transform .15s,border-color .15s;}
    .dashv2 .dashv2-module .dashv2-section-icon {width:35px;height:35px;background:var(--v2-surface);}
    .dashv2 .dashv2-module-name {display:block;font-size:.76rem;font-weight:600;line-height:1.15;}
    .dashv2 .dashv2-module-count {display:block;font-weight:800;font-size:1.22rem;line-height:1.3;}
    .dashv2 .dashv2-module-info {display:block;color:var(--v2-muted);font-size:.69rem;line-height:1.25;white-space:normal;}
    .dashv2 .dashv2-bottom {display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .dashv2 .dashv2-panel-heading {padding:17px 20px;border-bottom:1px solid var(--v2-border);display:flex;justify-content:space-between;align-items:center;gap:12px;}
    .dashv2 .dashv2-panel-content {padding:4px 20px;}
    .dashv2 .dashv2-action {color:var(--v2-gold);font-size:.8rem;font-weight:700;text-decoration:none;white-space:nowrap;}
    .dashv2 .dashv2-action:hover {text-decoration:underline;color:var(--v2-gold);}
    .dashv2 .dashv2-feed-row {display:flex;align-items:center;gap:12px;padding:14px 0;text-decoration:none;color:var(--v2-text);border-bottom:1px solid var(--v2-border);}
    .dashv2 .dashv2-feed-row:last-child {border-bottom:0;}
    .dashv2 .dashv2-feed-row:hover {color:var(--v2-text);}
    .dashv2 .dashv2-feed-row:hover strong {color:var(--v2-gold);}
    .dashv2 .dashv2-feed-icon {width:39px;height:39px;display:grid;place-items:center;flex-shrink:0;background:var(--v2-soft);border-radius:50%;color:var(--v2-gold);}
    .dashv2 .dashv2-feed-row strong {display:block;font-weight:700;font-size:.86rem;}
    .dashv2 .dashv2-feed-row small {display:block;font-size:.76rem;color:var(--v2-muted);margin-top:3px;}
    .dashv2 .dashv2-feed-when {margin-left:auto;flex-shrink:0;color:var(--v2-muted);font-size:.72rem;}
    .dashv2 .dashv2-event {display:flex;align-items:center;gap:14px;padding:15px 0;border-bottom:1px solid var(--v2-border);}
    .dashv2 .dashv2-event:last-child {border-bottom:0;}
    .dashv2 .dashv2-event-image {width:74px;height:62px;object-fit:cover;border-radius:9px;flex-shrink:0;background:var(--v2-soft);}
    .dashv2 .dashv2-event-placeholder {display:grid;place-items:center;color:var(--v2-gold);font-size:1.5rem;}
    .dashv2 .dashv2-event-info {min-width:0;flex:1;}
    .dashv2 .dashv2-event-info strong {display:block;color:var(--v2-text);font-size:.87rem;}
    .dashv2 .dashv2-event-info small {display:block;color:var(--v2-muted);font-size:.75rem;margin-top:4px;}
    .dashv2 .dashv2-event-tag {background:rgba(48,155,88,.1);color:#278c53;border:1px solid rgba(48,155,88,.2);border-radius:20px;padding:5px 9px;font-size:.7rem;font-weight:700;white-space:nowrap;}
    .dashv2 .dashv2-empty {padding:28px 4px;color:var(--v2-muted);font-size:.85rem;text-align:center;}
    @media(max-width:1300px){.dashv2 .dashv2-modules{grid-template-columns:repeat(3,minmax(0,1fr));}.dashv2 .dashv2-kpis{grid-template-columns:repeat(2,minmax(0,1fr));}}
    @media(max-width:850px){.dashv2 .dashv2-analytics,.dashv2 .dashv2-bottom{grid-template-columns:1fr;}}
    @media(max-width:575px){.dashv2 .dashv2-kpis,.dashv2 .dashv2-modules{grid-template-columns:1fr 1fr;}.dashv2 .dashv2-kpi{padding:15px;gap:9px;}.dashv2 .dashv2-kpi-icon{width:38px;height:38px;}.dashv2 .dashv2-kpi-value{font-size:1.4rem;}.dashv2 .dashv2-panel-pad{padding:16px;}.dashv2 .dashv2-modules{gap:8px;}.dashv2 .dashv2-module{padding:9px 7px;gap:7px;}.dashv2 .dashv2-module .dashv2-section-icon{display:none;}.dashv2 .dashv2-date{width:100%;}.dashv2 .dashv2-feed-when{display:none;}}
</style>

<main class="app-main dash-home-main">
    <div class="app-content container-fluid">
        <div class="dash-page dashv2">
            <header class="dashv2-head">
                <div>
                    <span class="dashv2-kicker"><i class="bi bi-grid-1x2-fill me-1"></i> Dashboard administrativo</span>
                    <h2 class="dashv2-title">Visão Geral</h2>
                    <p class="dashv2-lead">Acompanhe os principais números do Conexão 360° e veja rapidamente o que precisa de atenção.</p>
                </div>
                <div class="dashv2-date"><i class="bi bi-calendar3"></i>{{ now()->locale('pt_BR')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</div>
            </header>

            <section class="dashv2-kpis" aria-label="Indicadores principais">
                <a href="{{ route('admin.cadastro.usuarios') }}" class="dashv2-kpi dashv2-kpi--success">
                    <span class="dashv2-kpi-icon"><i class="bi bi-people-fill"></i></span>
                    <span><span class="dashv2-kpi-label">Total de usuários</span><strong class="dashv2-kpi-value">{{ $totalUsuarios }}</strong><span class="dashv2-kpi-foot"><i class="bi bi-check-circle"></i>{{ $usuariosAtivos }} ativos</span></span>
                </a>
                <article class="dashv2-kpi">
                    <span class="dashv2-kpi-icon"><i class="bi bi-person-plus-fill"></i></span>
                    <span><span class="dashv2-kpi-label">Novos este mês</span><strong class="dashv2-kpi-value">{{ $novosEsteMes }}</strong><span class="dashv2-kpi-foot"><i class="bi bi-calendar-check"></i>Cadastros no mês atual</span></span>
                </article>
                <a href="{{ route('admin.publicacoes.index') }}" class="dashv2-kpi dashv2-kpi--info">
                    <span class="dashv2-kpi-icon"><i class="bi bi-file-post-fill"></i></span>
                    <span><span class="dashv2-kpi-label">Publicações ativas</span><strong class="dashv2-kpi-value">{{ $publicacoesAtivas }}</strong><span class="dashv2-kpi-foot"><i class="bi bi-collection"></i>{{ $totalPublicacoes }} no total</span></span>
                </a>
                <a href="{{ route('admin.moderacao.index') }}" class="dashv2-kpi dashv2-kpi--danger">
                    <span class="dashv2-kpi-icon"><i class="bi bi-exclamation-triangle-fill"></i></span>
                    <span><span class="dashv2-kpi-label">Aguardando moderação</span><strong class="dashv2-kpi-value">{{ $aguardandoModeracao }}</strong><span class="dashv2-kpi-foot"><i class="bi bi-clock"></i>Denúncias pendentes</span></span>
                </a>
            </section>

            <div class="dashv2-analytics">
                <section class="dashv2-panel dashv2-panel-pad" aria-labelledby="cadastros-titulo">
                    <div class="dashv2-header-row">
                        <div class="dashv2-panel-title">
                            <span class="dashv2-section-icon"><i class="bi bi-bar-chart-line"></i></span>
                            <div><h3 id="cadastros-titulo">Cadastros de usuários</h3><span class="dashv2-hint">Evolução mensal de novos cadastros</span></div>
                        </div>
                        <span class="dashv2-mini-label">Últimos 6 meses</span>
                    </div>
                    <svg class="dashv2-chart" viewBox="0 0 680 165" role="img" aria-label="Gráfico de cadastros de usuários nos últimos seis meses">
                        <defs><linearGradient id="dashv2-area" x1="0" x2="0" y1="0" y2="1"><stop offset="0%" stop-color="var(--v2-gold)" stop-opacity=".23"/><stop offset="100%" stop-color="var(--v2-gold)" stop-opacity=".02"/></linearGradient></defs>
                        @foreach ([0, .5, 1] as $passo)
                            @php $gridY = 144 - 112 * $passo; @endphp
                            <line class="dashv2-gridline" x1="34" y1="{{ $gridY }}" x2="648" y2="{{ $gridY }}"/>
                            <text x="24" y="{{ $gridY + 4 }}" text-anchor="end">{{ (int) round($escalaMax * $passo) }}</text>
                        @endforeach
                        <polygon points="{{ $areaGrafico }}" fill="url(#dashv2-area)"/>
                        <polyline class="dashv2-line" points="{{ $linhaGrafico }}"/>
                        @foreach ($pontosGrafico as $ponto)
                            <circle class="dashv2-dot" cx="{{ $ponto['x'] }}" cy="{{ $ponto['y'] }}" r="5"><title>{{ $mesesGrafico[$loop->index] }}: {{ $ponto['valor'] }} cadastro(s)</title></circle>
                        @endforeach
                    </svg>
                    <div class="dashv2-months">@foreach ($mesesGrafico as $mes)<span>{{ $mes }}</span>@endforeach</div>
                </section>

                <section class="dashv2-panel dashv2-panel-pad" aria-labelledby="status-titulo">
                    <div class="dashv2-panel-title">
                        <span class="dashv2-section-icon"><i class="bi bi-people"></i></span>
                        <div><h3 id="status-titulo">Usuários por status</h3><span class="dashv2-hint">Distribuição atual dos membros</span></div>
                    </div>
                    <div class="dashv2-donut-flex">
                        <div class="dashv2-donut" style="--percent-active: {{ $percentualAtivos }}%;" role="img" aria-label="{{ $usuariosAtivosGrafico }} usuários ativos de {{ $totalUsuariosGrafico }} no total">
                            <span class="dashv2-donut-value"><strong>{{ $totalUsuariosGrafico }}</strong><small>usuários</small></span>
                        </div>
                        <div class="dashv2-legend">
                            <div class="dashv2-legend-line"><span class="dashv2-dot-legend"></span><span>Ativos</span><strong>{{ $usuariosAtivosGrafico }}</strong><small>{{ number_format($percentualAtivos, 1, ',', '.') }}%</small></div>
                            <div class="dashv2-legend-line"><span class="dashv2-dot-legend dashv2-dot-legend--off"></span><span>Inativos</span><strong>{{ $usuariosInativosGrafico }}</strong><small>{{ number_format($percentualInativos, 1, ',', '.') }}%</small></div>
                        </div>
                    </div>
                </section>
            </div>

            <section class="dashv2-panel dashv2-panel-pad dashv2-module-panel" aria-labelledby="modulos-titulo">
                <div class="dashv2-header-row">
                    <div class="dashv2-panel-title"><span class="dashv2-section-icon"><i class="bi bi-grid"></i></span><div><h3 id="modulos-titulo">Resumo por módulo</h3><span class="dashv2-hint">Acessos rápidos aos principais recursos do painel</span></div></div>
                    <span class="dashv2-mini-label">{{ $totalCurtidas + $totalComentarios }} interações · {{ $totalCurtidas }} curtidas · {{ $totalComentarios }} comentários</span>
                </div>
                <div class="dashv2-modules">
                    <a href="{{ route('admin.cadastro.usuarios') }}" class="dashv2-module"><span class="dashv2-section-icon"><i class="bi bi-people"></i></span><span><span class="dashv2-module-name">Usuários</span><strong class="dashv2-module-count">{{ $totalUsuarios }}</strong><small class="dashv2-module-info">{{ $usuariosAtivos }} ativos</small></span></a>
                    <a href="{{ route('admin.cadastro.palestrante') }}" class="dashv2-module"><span class="dashv2-section-icon"><i class="bi bi-mic"></i></span><span><span class="dashv2-module-name">Palestrantes</span><strong class="dashv2-module-count">{{ $totalPalestrantes }}</strong><small class="dashv2-module-info">{{ $palestrantesAtivos }} ativos</small></span></a>
                    <a href="{{ route('admin.publicacoes.index') }}" class="dashv2-module"><span class="dashv2-section-icon"><i class="bi bi-file-post"></i></span><span><span class="dashv2-module-name">Publicações</span><strong class="dashv2-module-count">{{ $totalPublicacoes }}</strong><small class="dashv2-module-info">{{ $publicacoesOcultas }} ocultas</small></span></a>
                    <a href="{{ route('admin.eventos.index') }}" class="dashv2-module"><span class="dashv2-section-icon"><i class="bi bi-calendar-event"></i></span><span><span class="dashv2-module-name">Eventos</span><strong class="dashv2-module-count">{{ $totalEventos }}</strong><small class="dashv2-module-info">{{ $totalVideos }} vídeos · {{ $totalEnquetes }} enquetes</small></span></a>
                    <a href="{{ route('admin.depoimentos.index') }}" class="dashv2-module"><span class="dashv2-section-icon"><i class="bi bi-chat-quote"></i></span><span><span class="dashv2-module-name">Depoimentos</span><strong class="dashv2-module-count">{{ $depoimentosAtivos }}</strong><small class="dashv2-module-info">{{ $totalDepoimentos }} recebidos</small></span></a>
                    <a href="{{ route('admin.moderacao.index') }}" class="dashv2-module"><span class="dashv2-section-icon"><i class="bi bi-shield-check"></i></span><span><span class="dashv2-module-name">Moderação</span><strong class="dashv2-module-count">{{ $aguardandoModeracao }}</strong><small class="dashv2-module-info">{{ $denunciasAnalisadas }} analisadas</small></span></a>
                </div>
            </section>

            <div class="dashv2-bottom">
                <section class="dashv2-panel" aria-labelledby="atividades-titulo">
                    <div class="dashv2-panel-heading"><div class="dashv2-panel-title"><span class="dashv2-section-icon"><i class="bi bi-list-ul"></i></span><div><h3 id="atividades-titulo">Atividades recentes</h3><span class="dashv2-hint">Novos cadastros e publicações</span></div></div></div>
                    <div class="dashv2-panel-content">
                        @forelse ($atividadesDashboard as $atividade)
                            <a class="dashv2-feed-row" href="{{ $atividade['url'] }}">
                                <span class="dashv2-feed-icon"><i class="bi {{ $atividade['tipo'] === 'usuario' ? 'bi-person-plus' : 'bi-file-earmark-text' }}"></i></span>
                                <span class="dashv2-event-info"><strong>{{ $atividade['titulo'] }}</strong><small>{{ $atividade['descricao'] }}</small></span>
                                <span class="dashv2-feed-when">{{ $atividade['data']->locale('pt_BR')->diffForHumans() }}</span>
                            </a>
                        @empty
                            <div class="dashv2-empty">Ainda não há atividades recentes.</div>
                        @endforelse
                    </div>
                </section>
                <section class="dashv2-panel" aria-labelledby="agenda-titulo">
                    <div class="dashv2-panel-heading">
                        <div class="dashv2-panel-title"><span class="dashv2-section-icon"><i class="bi bi-calendar2-week"></i></span><div><h3 id="agenda-titulo">Agenda de eventos</h3><span class="dashv2-hint">Eventos ativos em andamento ou futuros</span></div></div>
                        <a class="dashv2-action" href="{{ route('admin.eventos.index') }}">Ver eventos <i class="bi bi-arrow-right"></i></a>
                    </div>
                    <div class="dashv2-panel-content">
                        @forelse ($eventosAgenda as $eventoAgenda)
                            @php
                                $capaAgenda = $eventoAgenda->banner_evento ? 'conexao360/img/' . $eventoAgenda->banner_evento : null;
                                $capaDisponivel = $capaAgenda && is_file(public_path($capaAgenda));
                                $emAndamento = \Carbon\Carbon::parse($eventoAgenda->data_inicial_evento)->startOfDay()->lte(now());
                            @endphp
                            <div class="dashv2-event">
                                @if ($capaDisponivel)
                                    <img class="dashv2-event-image" src="{{ asset($capaAgenda) }}" alt="" loading="lazy">
                                @else
                                    <span class="dashv2-event-image dashv2-event-placeholder"><i class="bi bi-calendar-event"></i></span>
                                @endif
                                <span class="dashv2-event-info">
                                    <strong>{{ $eventoAgenda->titulo_evento }}</strong>
                                    <small>{{ $eventoAgenda->edicao_evento }}ª edição · {{ $eventoAgenda->endereco_evento }}</small>
                                    <small><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($eventoAgenda->data_inicial_evento)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($eventoAgenda->data_termino_evento)->format('d/m/Y') }}</small>
                                </span>
                                <span class="dashv2-event-tag">{{ $emAndamento ? 'Em andamento' : 'Em breve' }}</span>
                            </div>
                        @empty
                            <div class="dashv2-empty">Nenhum evento ativo em andamento ou futuro.</div>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </div>
</main>
@endsection
