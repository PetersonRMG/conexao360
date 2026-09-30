@extends('layout.admin')
@section('title', 'Dashboard')
@section('pg-titulo', 'Dashboard')
@section('link-topo', 'Dashboard')

@section('content')
    <main class="app-main dash-home-main">
        <div class="app-content container-fluid">
            <div class="dash-page">

                {{-- CABEÇALHO --}}
                <header class="dash-page-header">
                    <div class="dash-page-heading">
                        <span class="dash-eyebrow">
                            <i class="bi bi-grid-1x2-fill"></i>
                            Dashboard administrativo
                        </span>

                        <h3 class="dash-title dash-title--sm">Visão Geral</h3>

                        <p class="dash-subtitle">
                            Acompanhe os principais números do Conexão 360° e veja rapidamente o que precisa de atenção.
                        </p>
                    </div>

                    <div class="dash-date-pill">
                        <i class="bi bi-calendar3"></i>
                        <span>
                            {{ \Carbon\Carbon::now()->locale('pt_BR')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                        </span>
                    </div>
                </header>

                {{-- INDICADORES PRINCIPAIS --}}
                <section class="dash-stats-grid" aria-label="Indicadores principais">
                    <a href="{{ route('admin.cadastro.usuarios') }}" class="dash-stat-link">
                        <article class="dash-stat-card dash-stat-card--success">
                            <div class="dash-stat-icon">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="dash-stat-body">
                                <span class="dash-stat-label">Total de Usuários</span>
                                <strong class="dash-stat-value">{{ $totalUsuarios }}</strong>
                                <span class="dash-stat-description">
                                    <i class="bi bi-check-circle"></i>
                                    {{ $usuariosAtivos }} ativos
                                </span>
                            </div>
                        </article>
                    </a>

                    <article class="dash-stat-card dash-stat-card--info">
                        <div class="dash-stat-icon">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <div class="dash-stat-body">
                            <span class="dash-stat-label">Novos este Mês</span>
                            <strong class="dash-stat-value">{{ $novosEsteMes }}</strong>
                            <span class="dash-stat-description">
                                <i class="bi bi-calendar-check"></i>
                                Cadastros no mês atual
                            </span>
                        </div>
                    </article>

                    <a href="{{ route('admin.publicacoes.index') }}" class="dash-stat-link">
                        <article class="dash-stat-card dash-stat-card--primary">
                            <div class="dash-stat-icon">
                                <i class="bi bi-file-post-fill"></i>
                            </div>
                            <div class="dash-stat-body">
                                <span class="dash-stat-label">Publicações Ativas</span>
                                <strong class="dash-stat-value">{{ $publicacoesAtivas }}</strong>
                                <span class="dash-stat-description">
                                    <i class="bi bi-collection"></i>
                                    {{ $totalPublicacoes }} no total
                                </span>
                            </div>
                        </article>
                    </a>

                    <a href="{{ route('admin.moderacao.index') }}" class="dash-stat-link">
                        <article class="dash-stat-card dash-stat-card--warning">
                            <div class="dash-stat-icon">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>
                            <div class="dash-stat-body">
                                <span class="dash-stat-label">Aguardando Moderação</span>
                                <strong class="dash-stat-value">{{ $aguardandoModeracao }}</strong>
                                <span class="dash-stat-description">
                                    <i class="bi bi-clock"></i>
                                    Denúncias pendentes
                                </span>
                            </div>
                        </article>
                    </a>
                </section>

                {{-- PANORAMA POR MÓDULO --}}
                <section class="dash-overview-section">
                    <header class="dash-overview-header">
                        <div>
                            <span class="dash-overview-kicker">Panorama da plataforma</span>
                            <h4>Resumo por módulo</h4>
                            <p>Uma leitura rápida das áreas que já fazem parte do painel administrativo.</p>
                        </div>
                    </header>

                    <div class="dash-module-grid">
                        <a href="{{ route('admin.cadastro.usuarios') }}" class="dash-module-card">
                            <div class="dash-module-icon"><i class="bi bi-people"></i></div>
                            <div class="dash-module-copy">
                                <span>Usuários</span>
                                <strong>{{ $totalUsuarios }}</strong>
                                <small>{{ $usuariosAtivos }} ativos</small>
                            </div>
                            <i class="bi bi-arrow-up-right dash-module-arrow"></i>
                        </a>

                        <a href="{{ route('admin.cadastro.palestrante') }}" class="dash-module-card">
                            <div class="dash-module-icon"><i class="bi bi-mic"></i></div>
                            <div class="dash-module-copy">
                                <span>Palestrantes</span>
                                <strong>{{ $totalPalestrantes }}</strong>
                                <small>{{ $palestrantesAtivos }} ativos</small>
                            </div>
                            <i class="bi bi-arrow-up-right dash-module-arrow"></i>
                        </a>

                        <a href="{{ route('admin.publicacoes.index') }}" class="dash-module-card">
                            <div class="dash-module-icon"><i class="bi bi-file-post"></i></div>
                            <div class="dash-module-copy">
                                <span>Publicações</span>
                                <strong>{{ $totalPublicacoes }}</strong>
                                <small>{{ $publicacoesOcultas }} ocultas</small>
                            </div>
                            <i class="bi bi-arrow-up-right dash-module-arrow"></i>
                        </a>

                        <a href="{{ route('admin.conteudos.videos') }}" class="dash-module-card">
                            <div class="dash-module-icon"><i class="bi bi-play-btn"></i></div>
                            <div class="dash-module-copy">
                                <span>Vídeos</span>
                                <strong>{{ $totalVideos }}</strong>
                                <small>{{ $videosAtivos }} ativos</small>
                            </div>
                            <i class="bi bi-arrow-up-right dash-module-arrow"></i>
                        </a>

                        <a href="{{ route('admin.enquetes.index') }}" class="dash-module-card">
                            <div class="dash-module-icon"><i class="bi bi-bar-chart-line"></i></div>
                            <div class="dash-module-copy">
                                <span>Enquetes</span>
                                <strong>{{ $totalEnquetes }}</strong>
                                <small>{{ $totalRespostasEnquetes }} respostas</small>
                            </div>
                            <i class="bi bi-arrow-up-right dash-module-arrow"></i>
                        </a>

                        <a href="{{ route('admin.modificar.site') }}" class="dash-module-card">
                            <div class="dash-module-icon"><i class="bi bi-calendar-event"></i></div>
                            <div class="dash-module-copy">
                                <span>Eventos</span>
                                <strong>{{ $totalEventos }}</strong>
                                <small>Eventos cadastrados</small>
                            </div>
                            <i class="bi bi-arrow-up-right dash-module-arrow"></i>
                        </a>

                        <a href="{{ route('admin.depoimentos.index') }}" class="dash-module-card">
                            <div class="dash-module-icon"><i class="bi bi-chat-quote"></i></div>
                            <div class="dash-module-copy">
                                <span>Depoimentos</span>
                                <strong>{{ $depoimentosAtivos }}</strong>
                                <small>{{ $totalDepoimentos }} recebidos</small>
                            </div>
                            <i class="bi bi-arrow-up-right dash-module-arrow"></i>
                        </a>

                        <a href="{{ route('admin.moderacao.index') }}" class="dash-module-card">
                            <div class="dash-module-icon"><i class="bi bi-shield-check"></i></div>
                            <div class="dash-module-copy">
                                <span>Moderação</span>
                                <strong>{{ $aguardandoModeracao }}</strong>
                                <small>{{ $denunciasAnalisadas }} analisadas</small>
                            </div>
                            <i class="bi bi-arrow-up-right dash-module-arrow"></i>
                        </a>

                        <div class="dash-module-card dash-module-card--static">
                            <div class="dash-module-icon"><i class="bi bi-activity"></i></div>
                            <div class="dash-module-copy">
                                <span>Interações</span>
                                <strong>{{ $totalCurtidas + $totalComentarios }}</strong>
                                <small>{{ $totalCurtidas }} curtidas • {{ $totalComentarios }} comentários</small>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- ATIVIDADE RECENTE --}}
                <section class="dash-panels-grid dash-panels-grid--balanced">
                    <section class="dash-panel">
                        <header class="dash-panel-header">
                            <div class="dash-panel-heading">
                                <h5 class="dash-panel-title">Usuários Recentes</h5>
                                <small class="dash-panel-subtitle">Últimos cadastros realizados na plataforma</small>
                            </div>
                            <a href="{{ route('admin.cadastro.usuarios') }}" class="dash-panel-link">
                                Ver usuários <i class="bi bi-arrow-right"></i>
                            </a>
                        </header>

                        <div class="dash-table-wrap">
                            <table class="dash-table">
                                <thead>
                                    <tr>
                                        <th>Usuário</th>
                                        <th>Perfil</th>
                                        <th>Cadastro</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($usuariosRecentes as $item)
                                        @php
                                            $nomeCompleto = trim($item->nome_usuario ?? 'Usuário');
                                            $partesNome = preg_split('/\s+/', $nomeCompleto);
                                            $inicial1 = mb_substr($partesNome[0] ?? '', 0, 1);
                                            $inicial2 = isset($partesNome[1])
                                                ? mb_substr($partesNome[1], 0, 1)
                                                : mb_substr($partesNome[0] ?? '', 1, 1);
                                            $iniciais = strtoupper($inicial1 . $inicial2);
                                            $status = strtoupper(trim($item->status_usuario ?? ''));
                                        @endphp

                                        <tr class="dash-table-row">
                                            <td>
                                                <div class="dash-author">
                                                    @if (!empty($item->foto_usuario) && file_exists(public_path('dash/assets/img/' . $item->foto_usuario)))
                                                        <img src="{{ asset('dash/assets/img/' . $item->foto_usuario) }}"
                                                            alt="{{ $item->nome_usuario }}"
                                                            class="dash-avatar dash-avatar--image"
                                                            loading="lazy">
                                                    @else
                                                        <div class="dash-avatar dash-avatar--primary">{{ $iniciais }}</div>
                                                    @endif

                                                    <div>
                                                        <span class="dash-author-name">{{ $item->nome_usuario }}</span>
                                                        <small class="dash-author-meta">{{ $item->email_usuario }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="dash-cell-muted">
                                                {{ ucfirst($item->perfil_usuario ?: 'Não informado') }}
                                            </td>
                                            <td class="dash-cell-muted">
                                                {{ $item->criado_em_usuario
                                                    ? \Carbon\Carbon::parse($item->criado_em_usuario)->locale('pt_BR')->diffForHumans()
                                                    : 'Não informado' }}
                                            </td>
                                            <td>
                                                <span class="dash-status {{ $status === 'ATIVO' ? 'dash-status--approved' : 'dash-status--rejected' }}">
                                                    <i class="bi {{ $status === 'ATIVO' ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                                                    {{ $status ?: 'Não informado' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <div class="dash-empty-state">
                                                    <div class="dash-empty-icon"><i class="bi bi-people"></i></div>
                                                    <h5>Nenhum usuário encontrado.</h5>
                                                    <p class="dash-empty-text">Os novos cadastros aparecerão aqui.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section class="dash-panel">
                        <header class="dash-panel-header">
                            <div class="dash-panel-heading">
                                <h5 class="dash-panel-title">Publicações Recentes</h5>
                                <small class="dash-panel-subtitle">Últimas atividades publicadas no Conexão 360°</small>
                            </div>
                            <a href="{{ route('admin.publicacoes.index') }}" class="dash-panel-link">
                                Ver publicações <i class="bi bi-arrow-right"></i>
                            </a>
                        </header>

                        <div class="dash-recent-posts">
                            @forelse ($publicacoesRecentes as $publicacao)
                                <article class="dash-recent-post">
                                    <div class="dash-recent-post-icon">
                                        <i class="bi {{ $publicacao->tipo_midia_publicacao === 'VIDEO' ? 'bi-play-btn' : ($publicacao->tipo_midia_publicacao === 'IMAGEM' ? 'bi-image' : 'bi-file-text') }}"></i>
                                    </div>

                                    <div class="dash-recent-post-body">
                                        <div class="dash-recent-post-top">
                                            <strong>{{ $publicacao->usuario?->nome_usuario ?? 'Usuário' }}</strong>
                                            <span class="dash-status {{ $publicacao->status_publicacao === 'ATIVO' ? 'dash-status--approved' : 'dash-status--pending' }}">
                                                {{ $publicacao->status_publicacao }}
                                            </span>
                                        </div>

                                        <p>
                                            {{ \Illuminate\Support\Str::limit($publicacao->texto_publicacao ?: 'Publicação com mídia.', 115) }}
                                        </p>

                                        <small>
                                            <i class="bi bi-clock"></i>
                                            {{ $publicacao->criado_em_publicacao
                                                ? $publicacao->criado_em_publicacao->locale('pt_BR')->diffForHumans()
                                                : 'Data não informada' }}
                                            @if ($publicacao->evento)
                                                <span>•</span>
                                                {{ $publicacao->evento->titulo_evento }}
                                            @endif
                                        </small>
                                    </div>
                                </article>
                            @empty
                                <div class="dash-empty-state">
                                    <div class="dash-empty-icon"><i class="bi bi-file-post"></i></div>
                                    <h5>Nenhuma publicação encontrada.</h5>
                                    <p class="dash-empty-text">As publicações mais recentes aparecerão aqui.</p>
                                </div>
                            @endforelse
                        </div>
                    </section>
                </section>

            </div>
        </div>
    </main>
@endsection
