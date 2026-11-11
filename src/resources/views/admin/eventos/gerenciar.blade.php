@extends('layout.admin')

@section('title', 'Gerenciar Eventos')
@section('pg-titulo', 'Gerenciar Eventos')
@section('link-topo', 'Eventos / Manutenção')

@section('content')
@include('admin.eventos._estilos')
<main class="app-main eventos-admin">
    <div class="ev-shell ev-shell--fluid">
        <header class="ev-top">
            <div>
                <span class="ev-eyebrow"><i class="bi bi-calendar2-week me-2"></i> Gestão de eventos</span>
                <h2>Manutenção de Eventos</h2>
                <p class="ev-description">Todas as edições em um só lugar. Cadastre ou edite o evento e gerencie as fotos, os vídeos, as enquetes e a programação separadamente em cada edição.</p>
            </div>
            <a href="{{ route('admin.eventos.novo') }}" class="ev-btn"><i class="bi bi-plus-circle"></i> Novo evento</a>
        </header>

        @if(session('success'))
            <div class="ev-flash" role="status"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
        @endif

        <div class="ev-summary" aria-label="Resumo de eventos">
            <div class="ev-stat"><small><i class="bi bi-calendar-event"></i>Eventos cadastrados</small><strong>{{ $totalEventos }}</strong></div>
            <div class="ev-stat"><small><i class="bi bi-check-circle"></i>Eventos ativos</small><strong>{{ $totalAtivos }}</strong></div>
            <div class="ev-stat"><small><i class="bi bi-archive"></i>Eventos inativos</small><strong>{{ $totalEventos - $totalAtivos }}</strong></div>
        </div>

        <form method="GET" action="{{ route('admin.eventos.index') }}" class="ev-filter" aria-label="Filtrar eventos">
            <div class="ev-field">
                <label for="eventos-busca">Buscar evento</label>
                <input id="eventos-busca" type="search" name="busca" value="{{ $busca }}" placeholder="Nome, edição ou local">
            </div>
            <div style="min-width:170px;">
                <label for="eventos-status">Situação</label>
                <select id="eventos-status" name="status">
                    <option value="">Todos</option>
                    <option value="ATIVO" @selected($status === 'ATIVO')>Ativos</option>
                    <option value="INATIVO" @selected($status === 'INATIVO')>Inativos</option>
                </select>
            </div>
            <button class="ev-btn" type="submit"><i class="bi bi-search"></i> Buscar</button>
            @if($busca !== '' || $status !== '')
                <a class="ev-btn ev-btn--neutral" href="{{ route('admin.eventos.index') }}">Limpar</a>
            @endif
        </form>

        @forelse($eventos as $evento)
            <article class="ev-card">
                <div class="ev-cover">
                    @if($evento->banner_evento)
                        <img src="{{ asset('conexao360/img/' . $evento->banner_evento) }}" alt="Banner de {{ $evento->titulo_evento }}" loading="lazy">
                    @else
                        <i class="bi bi-calendar-event" aria-hidden="true"></i>
                    @endif
                </div>
                <div class="ev-card-body">
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                        <h3 class="ev-card-title">{{ $evento->titulo_evento }}</h3>
                        <span class="ev-badge {{ $evento->status_evento === 'ATIVO' ? 'ev-badge--active' : '' }}">{{ $evento->status_evento === 'ATIVO' ? 'Ativo' : 'Inativo' }}</span>
                    </div>
                    <p class="ev-card-sub">{{ $evento->edicao_evento }}ª edição · {{ $evento->endereco_evento }}</p>
                    <div class="ev-meta">
                        <span><i class="bi bi-calendar3"></i>{{ \Illuminate\Support\Carbon::parse($evento->data_inicial_evento)->format('d/m/Y') }} a {{ \Illuminate\Support\Carbon::parse($evento->data_termino_evento)->format('d/m/Y') }}</span>
                        <span><i class="bi bi-images"></i>{{ $contagens['albuns']->get($evento->id_evento, 0) }} álbuns</span>
                        <span><i class="bi bi-play-circle"></i>{{ $contagens['videos']->get($evento->id_evento, 0) }} vídeos</span>
                        <span><i class="bi bi-ui-checks"></i>{{ $contagens['enquetes']->get($evento->id_evento, 0) }} enquetes</span>
                        <span><i class="bi bi-clock-history"></i>{{ $contagens['programacao']->get($evento->id_evento, 0) }} atividades</span>
                    </div>
                    <div class="ev-card-actions">
                        <a class="ev-btn" href="{{ route('admin.eventos.conteudo', ['idEvento' => $evento->id_evento]) }}"><i class="bi bi-sliders"></i> Gerenciar conteúdo</a>
                        <a class="ev-btn ev-btn--outline" href="{{ route('admin.eventos.editar', ['idEvento' => $evento->id_evento]) }}"><i class="bi bi-pencil-square"></i> Editar dados</a>
                    </div>
                </div>
            </article>
        @empty
            <div class="ev-empty"><i class="bi bi-calendar-x"></i>Nenhum evento encontrado.<div class="mt-3"><a href="{{ route('admin.eventos.novo') }}" class="ev-btn">Criar evento</a></div></div>
        @endforelse

        @if($eventos->hasPages())
            <div class="ev-pagination">{{ $eventos->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
</main>
@endsection
