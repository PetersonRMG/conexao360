@extends('layout.admin')

@section('title', 'Conteúdo do Evento')

@section('pg-titulo', 'Conteúdo do Evento')

@section('link-topo', 'Eventos / Gerenciar Conteúdo')

@section('content')

<style>
    /* Estilos exclusivos da tela Conteúdo do Evento.
       O menu e o cabeçalho continuam controlados pelo layout.admin. */
    .evento-conteudo-page {
        --evento-bg: #101010;
        --evento-card: #171717;
        --evento-header: #1e1a15;
        --evento-form: #121212;
        --evento-border: #40382b;
        --evento-border-soft: #34302b;
        --evento-text: #f4f0e8;
        --evento-muted: #bdb5a9;
        --evento-gold: #d3ab55;
        --evento-gold-hover: #e4c16f;
        --evento-gold-dark: #161208;
        background-color: var(--evento-bg) !important;
        color: var(--evento-text);
        min-height: 100vh;
    }

    .evento-conteudo-page h2,
    .evento-conteudo-page h3,
    .evento-conteudo-page h4,
    .evento-conteudo-page strong,
    .evento-conteudo-page .form-label {
        color: var(--evento-text);
    }

    .evento-conteudo-page .text-body-secondary {
        color: var(--evento-muted) !important;
    }

    /* Links e indicadores */
    .evento-conteudo-page a:not(.btn) {
        color: var(--evento-gold);
    }

    .evento-conteudo-page a:not(.btn):hover {
        color: var(--evento-gold-hover);
    }

    .evento-conteudo-page .row > [class*="col-"] > a > .card {
        transition: border-color .2s ease, transform .2s ease;
    }

    .evento-conteudo-page .row > [class*="col-"] > a:hover > .card {
        border-color: var(--evento-gold);
        transform: translateY(-2px);
    }

    .evento-conteudo-page .row > [class*="col-"] > a > .card i {
        color: var(--evento-gold);
    }

    .evento-conteudo-page .card {
        background: var(--evento-card);
        color: var(--evento-text);
        border: 1px solid var(--evento-border-soft);
        border-radius: .65rem;
        box-shadow: 0 6px 18px rgba(0, 0, 0, .16) !important;
    }

    .evento-conteudo-page .card-header {
        background: var(--evento-header);
        border-bottom: 1px solid var(--evento-border);
        color: var(--evento-text);
        border-radius: .65rem .65rem 0 0;
    }

    .evento-conteudo-page .card-header > i,
    .evento-conteudo-page .card-header h3 > i {
        color: var(--evento-gold);
    }

    /* Formulários e divisórias */
    .evento-conteudo-page form.border,
    .evento-conteudo-page .card-body > .border {
        background: var(--evento-form);
        border-color: var(--evento-border) !important;
        border-radius: .55rem !important;
    }

    .evento-conteudo-page .border,
    .evento-conteudo-page .border-top,
    .evento-conteudo-page .border-bottom {
        border-color: var(--evento-border-soft) !important;
    }

    .evento-conteudo-page .form-control,
    .evento-conteudo-page .form-select {
        background-color: #1c1c1c;
        border: 1px solid #5b5041;
        color: var(--evento-text);
        color-scheme: dark;
        min-height: 42px;
    }

    .evento-conteudo-page .form-control::placeholder {
        color: #a99f91;
        opacity: 1;
    }

    .evento-conteudo-page .form-control:focus,
    .evento-conteudo-page .form-select:focus {
        background-color: #202020;
        border-color: var(--evento-gold);
        color: var(--evento-text);
        box-shadow: 0 0 0 .2rem rgba(211, 171, 85, .18);
    }

    .evento-conteudo-page .form-control[type="file"]::file-selector-button {
        background: #332a1b;
        color: var(--evento-text);
        border: 0;
        border-right: 1px solid var(--evento-border);
        margin-right: 1rem;
        padding: .6rem .9rem;
    }

    /* Botões alinhados ao dourado institucional */
    .evento-conteudo-page .btn-warning {
        background: var(--evento-gold);
        color: var(--evento-gold-dark);
        border-color: var(--evento-gold);
        font-weight: 600;
    }

    .evento-conteudo-page .btn-warning:hover,
    .evento-conteudo-page .btn-warning:focus-visible {
        background: var(--evento-gold-hover);
        border-color: var(--evento-gold-hover);
        color: var(--evento-gold-dark);
    }

    .evento-conteudo-page .btn-outline-warning {
        color: var(--evento-gold);
        border-color: var(--evento-gold);
        font-weight: 600;
    }

    .evento-conteudo-page .btn-outline-warning:hover,
    .evento-conteudo-page .btn-outline-warning:focus-visible {
        color: var(--evento-gold-dark);
        background: var(--evento-gold);
        border-color: var(--evento-gold);
    }

    .evento-conteudo-page .btn-warning:focus-visible,
    .evento-conteudo-page .btn-outline-warning:focus-visible {
        box-shadow: 0 0 0 .2rem rgba(211, 171, 85, .25);
    }

    /* Feedback: verde/vermelho continuam indicando situação, não navegação. */
    .evento-conteudo-page .badge.text-bg-secondary {
        background: #3e3529 !important;
        color: #f5e5ca !important;
    }

    .evento-conteudo-page .alert-success {
        background: #12291e;
        border-color: #276a45;
        color: #c1f0d3;
    }

    .evento-conteudo-page .alert-danger {
        background: #331719;
        border-color: #873942;
        color: #ffd9dc;
    }

    .evento-conteudo-page .alert-warning {
        background: #332817;
        border-color: #8c713d;
        color: #f7e3b5;
    }

    .evento-conteudo-page .alert-info,
    .evento-conteudo-page .alert-secondary {
        background: #25221d;
        border-color: #6d5a3d;
        color: #e9dfcd;
    }

    .evento-conteudo-page .alert code {
        color: var(--evento-gold-hover);
    }

    .evento-conteudo-page .form-text {
        color: var(--evento-muted);
    }

    .evento-conteudo-page .album-validacao {
        color: #ffb5b9;
        font-size: .92rem;
        margin-top: .35rem;
    }

    .evento-conteudo-page .form-control.is-invalid {
        border-color: #b95560;
    }

    /* Legibilidade das informações e das fotos */
    .evento-conteudo-page .card-body,
    .evento-conteudo-page .form-label,
    .evento-conteudo-page p {
        font-size: .98rem;
    }

    .evento-conteudo-page .card-header h3 {
        font-size: 1.14rem;
    }

    .evento-conteudo-page img.border {
        border-color: var(--evento-border) !important;
    }
</style>


<main class="app-main dash-main--bg evento-conteudo-page">

    <div class="app-content container-fluid py-4 px-3 px-lg-4" style="max-width:1180px;">

        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">

            <div>

                <a href="{{ route('admin.eventos.index') }}" class="text-decoration-none d-inline-block mb-2">

                    <i class="bi bi-arrow-left"></i> Voltar para Eventos

                </a>

                <h2 class="fw-bold mb-1" style="font-size:1.6rem;">{{ $evento->titulo_evento }}</h2>

                <div class="text-body-secondary" style="font-size:1rem;">

                    {{ $evento->edicao_evento }} · {{ $evento->endereco_evento }}

                </div>

                <p class="text-body-secondary mb-0 mt-2">Gerencie fotos, vídeos, enquetes e a programação vinculados a esta edição.</p>

            </div>

            <a href="{{ route('admin.eventos.editar', ['idEvento' => $evento->id_evento]) }}" class="btn btn-outline-warning btn-sm"><i class="bi bi-pencil-square me-1"></i>Editar dados do evento</a>
            <span class="badge {{ $evento->status_evento === 'ATIVO' ? 'text-bg-success' : 'text-bg-secondary' }} px-3 py-2">

                {{ $evento->status_evento }}

            </span>

        </div>

        @if (session('success'))

            <div class="alert alert-success" role="status">{{ session('success') }}</div>

        @endif

        @if ($errors->any())

            <div class="alert alert-danger" role="alert">

                <strong>Verifique os campos:</strong>

                <ul class="mb-0 mt-2">

                    @foreach ($errors->all() as $erro)

                        <li>{{ $erro }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <div class="row g-3 mb-4">

            <div class="col-12 col-md-6 col-xl-3">

                <a href="#fotos" class="text-decoration-none">

                    <div class="card h-100 shadow-sm"><div class="card-body">

                        <i class="bi bi-images me-2"></i><strong>Galeria de fotos</strong>

                        <div class="fs-4 fw-bold mt-2">{{ $totalFotos }}</div>

                        <span class="text-body-secondary">{{ $albuns->count() }} álbuns deste evento</span>

                    </div></div>

                </a>

            </div>

            <div class="col-12 col-md-6 col-xl-3">

                <a href="#videos" class="text-decoration-none">

                    <div class="card h-100 shadow-sm"><div class="card-body">

                        <i class="bi bi-camera-video me-2"></i><strong>Vídeos</strong>

                        <div class="fs-4 fw-bold mt-2">{{ $videos->count() }}</div>

                        <span class="text-body-secondary">Conteúdos ligados a esta edição</span>

                    </div></div>

                </a>

            </div>

            <div class="col-12 col-md-6 col-xl-3">

                <a href="#enquetes" class="text-decoration-none">

                    <div class="card h-100 shadow-sm"><div class="card-body">

                        <i class="bi bi-ui-checks me-2"></i><strong>Enquetes</strong>

                        <div class="fs-4 fw-bold mt-2">{{ $enquetes->count() }}</div>

                        <span class="text-body-secondary">{{ $enquetesVinculadas ? 'Vinculadas a esta edição' : 'Vínculo ao evento ainda não configurado' }}</span>

                    </div></div>

                </a>

            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <a href="#programacao" class="text-decoration-none">
                    <div class="card h-100 shadow-sm"><div class="card-body">
                        <i class="bi bi-calendar-event me-2"></i><strong>Programação</strong>
                        <div class="fs-4 fw-bold mt-2">{{ $programacao->count() }}</div>
                        <span class="text-body-secondary">Atividades e horários desta edição</span>
                    </div></div>
                </a>
            </div>
        </div>

        <section id="fotos" class="card shadow-sm mb-4" style="scroll-margin-top:20px;">

            <div class="card-header py-3 d-flex align-items-center gap-2">

                <i class="bi bi-images fs-4"></i>

                <div><h3 class="h5 fw-bold mb-0">Galeria de fotos</h3><small class="text-body-secondary">Álbuns e fotos oficiais deste evento</small></div>

            </div>

            <div class="card-body">

                @unless($galeriaDisponivel)

                    <div class="alert alert-warning mb-0">

                        As tabelas da galeria ainda não estão disponíveis neste ambiente. Verifique a migration específica antes de cadastrar fotos.

                    </div>

                @else

                    @if (session('success'))
                        <div class="alert alert-success" role="status">{{ session('success') }}</div>
                    @endif
                    @if (session('album_error'))
                        <div class="alert alert-danger" role="alert">{{ session('album_error') }}</div>
                    @endif
                    @if ($errors->album->any())
                        <div class="alert alert-danger" role="alert">Confira os campos do álbum antes de salvar.</div>
                    @endif

                    <form id="form-criar-album" method="POST" action="{{ route('admin.eventos.albuns.store', ['idEvento' => $evento->id_evento]) }}" class="row g-3 border rounded p-3 mb-4">

                        @csrf

                        <div class="col-12"><h4 class="h6 fw-bold mb-0">Criar álbum</h4></div>

                        <div class="col-12 col-md-6">

                            <label for="titulo_album" class="form-label">Nome do álbum</label>

                            <input id="titulo_album" type="text" name="titulo_album" class="form-control @error('titulo_album', 'album') is-invalid @enderror" maxlength="150" required aria-describedby="album-cliente-erro" value="{{ old('titulo_album') }}" placeholder="Ex.: Abertura do evento">
                            <div id="album-cliente-erro" class="album-validacao d-none" role="alert">Informe o nome do álbum para continuar.</div>
                            @error('titulo_album', 'album')
                                <div class="album-validacao" role="alert">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="col-12 col-md-6">

                            <label for="descricao_album" class="form-label">Descrição (opcional)</label>

                            <input id="descricao_album" type="text" name="descricao_album" class="form-control @error('descricao_album', 'album') is-invalid @enderror" maxlength="2000" value="{{ old('descricao_album') }}">
                            @error('descricao_album', 'album')
                                <div class="album-validacao" role="alert">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="col-12">
                            <button id="btn-criar-album" type="submit" class="btn btn-warning fw-semibold">
                                <i class="bi bi-plus-circle me-1"></i> Criar álbum
                            </button>
                            <span id="album-enviando" class="ms-2 text-body-secondary d-none" role="status" aria-live="polite">Salvando álbum...</span>
                        </div>

                    </form>

                    @forelse($albuns as $album)

                        <div class="border rounded p-3 mb-3">

                            <div class="d-flex justify-content-between align-items-start gap-2 mb-3">

                                <div>

                                    <h4 class="h6 fw-bold mb-1">{{ $album->titulo_album }}</h4>

                                    <p class="text-body-secondary mb-0">{{ $album->descricao_album ?: 'Sem descrição' }}</p>

                                </div>

                                <span class="badge text-bg-secondary">{{ $album->fotos->count() }} fotos</span>

                            </div>

                            <details class="border rounded p-3 mb-3">
                                <summary class="fw-semibold" style="cursor:pointer;">Editar álbum · {{ $album->status_album }}</summary>
                                <form method="POST" action="{{ route('admin.eventos.albuns.update', ['idEvento' => $evento->id_evento, 'idAlbum' => $album->id_album]) }}" class="row g-2 mt-3">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-md-5"><label class="form-label">Nome do álbum</label><input class="form-control" name="titulo_album" maxlength="150" required value="{{ $album->titulo_album }}"></div>
                                    <div class="col-md-5"><label class="form-label">Descrição</label><input class="form-control" name="descricao_album" maxlength="2000" value="{{ $album->descricao_album }}"></div>
                                    <div class="col-md-2"><label class="form-label">Visibilidade</label><select name="status_album" class="form-select"><option value="ATIVO" @selected($album->status_album === 'ATIVO')>Ativo</option><option value="INATIVO" @selected($album->status_album === 'INATIVO')>Inativo</option></select></div>
                                    <div class="col-12"><button type="submit" class="btn btn-sm btn-outline-warning">Salvar álbum</button></div>
                                </form>
                                @if($album->fotos->isEmpty())
                                    <form method="POST" class="mt-2" action="{{ route('admin.eventos.albuns.destroy', ['idEvento' => $evento->id_evento, 'idAlbum' => $album->id_album]) }}" onsubmit="return confirm('Excluir este álbum vazio permanentemente?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Excluir álbum vazio</button>
                                    </form>
                                @else
                                    <p class="small text-body-secondary mt-2 mb-0">Para excluir o álbum, primeiro exclua suas fotos.</p>
                                @endif
                            </details>

                            @if($album->fotos->isNotEmpty())

                                <div class="row g-2 mb-3">

                                    @foreach($album->fotos as $foto)

                                        <div class="col-6 col-sm-4 col-lg-3">

                                            <a href="{{ asset('conexao360/uploads/galeria/' . $foto->arquivo_foto) }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none">

                                                <img src="{{ asset('conexao360/uploads/galeria/' . $foto->arquivo_foto) }}" alt="{{ $foto->titulo_foto }}" class="rounded border w-100" style="height:125px;object-fit:cover;" loading="lazy">

                                                <div class="small mt-1">{{ $foto->titulo_foto }}</div>

                                            </a>
                                            <details class="mt-2 border rounded p-2">
                                                <summary class="small fw-semibold" style="cursor:pointer;">Editar / excluir foto</summary>
                                                <form class="d-flex flex-column gap-2 mt-2" method="POST" enctype="multipart/form-data" action="{{ route('admin.eventos.fotos.update', ['idEvento' => $evento->id_evento, 'idAlbum' => $album->id_album, 'idFoto' => $foto->id_foto]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <label class="form-label small mb-0">Título</label><input class="form-control form-control-sm" name="titulo_foto" value="{{ $foto->titulo_foto }}" maxlength="150" required>
                                                    <label class="form-label small mb-0">Descrição</label><input class="form-control form-control-sm" name="descricao_foto" value="{{ $foto->descricao_foto }}" maxlength="2000">
                                                    <label class="form-label small mb-0">Substituir imagem (opcional)</label><input class="form-control form-control-sm" type="file" name="foto" accept="image/jpeg,image/png,image/webp">
                                                    <label class="form-label small mb-0">Visibilidade</label>
                                                    <select class="form-select form-select-sm" name="status_foto"><option value="ATIVO" @selected($foto->status_foto === 'ATIVO')>Ativa</option><option value="INATIVO" @selected($foto->status_foto === 'INATIVO')>Inativa</option></select>
                                                    <button class="btn btn-sm btn-outline-warning" type="submit">Salvar foto</button>
                                                </form>
                                                <form method="POST" class="mt-2" action="{{ route('admin.eventos.fotos.destroy', ['idEvento' => $evento->id_evento, 'idAlbum' => $album->id_album, 'idFoto' => $foto->id_foto]) }}" onsubmit="return confirm('Excluir esta foto permanentemente? Esta ação não pode ser desfeita.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">Excluir foto</button>
                                                </form>
                                            </details>


                                        </div>

                                    @endforeach

                                </div>

                            @endif

                            @if($album->status_album === 'ATIVO')

                                <form method="POST" enctype="multipart/form-data" action="{{ route('admin.eventos.fotos.store', ['idEvento' => $evento->id_evento, 'idAlbum' => $album->id_album]) }}" class="row g-3 border-top pt-3">

                                    @csrf

                                    <div class="col-12"><strong>Adicionar foto neste álbum</strong></div>

                                    <div class="col-12 col-md-4">

                                        <label for="titulo_foto_{{ $album->id_album }}" class="form-label">Título</label>

                                        <input id="titulo_foto_{{ $album->id_album }}" type="text" name="titulo_foto" maxlength="150" class="form-control" required>

                                    </div>

                                    <div class="col-12 col-md-4">

                                        <label for="foto_{{ $album->id_album }}" class="form-label">Imagem (JPG, PNG, WebP, até 5 MB)</label>

                                        <input id="foto_{{ $album->id_album }}" type="file" name="foto" accept="image/jpeg,image/png,image/webp" class="form-control" required>

                                    </div>

                                    <div class="col-12 col-md-4">

                                        <label for="descricao_foto_{{ $album->id_album }}" class="form-label">Descrição (opcional)</label>

                                        <input id="descricao_foto_{{ $album->id_album }}" type="text" name="descricao_foto" maxlength="2000" class="form-control">

                                    </div>

                                    <div class="col-12"><button type="submit" class="btn btn-outline-warning"><i class="bi bi-upload me-1"></i> Enviar foto</button></div>

                                </form>

                            @endif

                        </div>

                    @empty

                        <p class="text-body-secondary">Nenhum álbum cadastrado nesta edição.</p>

                    @endforelse

                @endunless

            </div>

        </section>

        {{-- VÍDEOS: os mesmos registros do módulo Conteúdos, filtrados pelo evento. --}}
        <section id="videos" class="card shadow-sm mb-4" style="scroll-margin-top:20px;">
            <div class="card-header py-3 d-flex align-items-center gap-2">
                <i class="bi bi-camera-video fs-4"></i>
                <div>
                    <h3 class="h5 fw-bold mb-0">Vídeos do evento</h3>
                    <small class="text-body-secondary">Adicione links do YouTube, Instagram, Vimeo ou outra plataforma</small>
                </div>
            </div>
            <div class="card-body">
                @unless($videosDisponiveis)
                    <div class="alert alert-warning mb-0">A tabela de vídeos não está disponível neste ambiente.</div>
                @else
                    <form method="POST" action="{{ route('admin.eventos.videos.store', ['idEvento' => $evento->id_evento]) }}" class="row g-3 border rounded p-3 mb-4">
                        @csrf
                        <div class="col-12"><h4 class="h6 fw-bold mb-0">Cadastrar vídeo para este evento</h4></div>
                        <div class="col-md-6">
                            <label class="form-label" for="evento_video_titulo">Título do vídeo</label>
                            <input class="form-control" id="evento_video_titulo" name="titulo_conteudo" maxlength="150" value="{{ old('titulo_conteudo') }}" required placeholder="Ex.: Palestra de abertura">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="evento_video_url">URL do vídeo (HTTPS)</label>
                            <input class="form-control" id="evento_video_url" name="url_conteudo" type="url" maxlength="255" pattern="https://.*" value="{{ old('url_conteudo') }}" placeholder="https://www.youtube.com/watch?v=..." required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label" for="evento_video_descricao">Descrição</label>
                            <textarea class="form-control" id="evento_video_descricao" name="descricao_conteudo" rows="2" maxlength="3000" required>{{ old('descricao_conteudo') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="evento_video_liberacao">Disponível a partir de</label>
                            <input class="form-control" id="evento_video_liberacao" name="liberado_em_conteudo" type="datetime-local" value="{{ old('liberado_em_conteudo', now()->format('Y-m-d\TH:i')) }}" required>
                        </div>
                        <div class="col-12 d-flex align-items-center gap-3 flex-wrap">
                            <button class="btn btn-warning" type="submit"><i class="bi bi-plus-circle me-1"></i> Adicionar vídeo</button>

                        </div>
                    </form>

                    @forelse($videos as $video)
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
                                <div>
                                    <h4 class="h6 fw-bold mb-1">{{ $video->titulo_conteudo }}</h4>
                                    <p class="text-body-secondary mb-1">{{ $video->descricao_conteudo }}</p>
                                    <div class="text-body-secondary small mb-2">
                                        Liberação: {{ $video->liberado_em_conteudo ? \Illuminate\Support\Carbon::parse($video->liberado_em_conteudo)->format('d/m/Y H:i') : 'Não informada' }}
                                        · {{ $video->status_conteudo }}
                                    </div>
                                    @if(filter_var($video->url_conteudo, FILTER_VALIDATE_URL) && parse_url($video->url_conteudo, PHP_URL_SCHEME) === 'https')
                                        <a href="{{ $video->url_conteudo }}" target="_blank" rel="noopener noreferrer"><i class="bi bi-box-arrow-up-right me-1"></i> Abrir vídeo</a>
                                    @endif
                                </div>
                                <div class="d-flex gap-2 flex-column">
                                <form method="POST" action="{{ route('admin.eventos.videos.status', ['idEvento' => $evento->id_evento, 'idVideo' => $video->id_conteudos]) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status_conteudo" value="{{ $video->status_conteudo === 'ATIVO' ? 'INATIVO' : 'ATIVO' }}">
                                    <button class="btn btn-sm btn-outline-warning" type="submit">{{ $video->status_conteudo === 'ATIVO' ? 'Inativar' : 'Ativar' }}</button>
                                </form>
                                </div>
                            </div>
                            <details class="mt-3 border rounded p-3">
                                <summary class="fw-semibold" style="cursor:pointer;">Editar vídeo / excluir</summary>
                                <form method="POST" action="{{ route('admin.eventos.videos.update', ['idEvento' => $evento->id_evento, 'idVideo' => $video->id_conteudos]) }}" class="row g-2 mt-2">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-md-6"><label class="form-label">Título</label><input class="form-control" name="titulo_conteudo" required maxlength="150" value="{{ $video->titulo_conteudo }}"></div>
                                    <div class="col-md-6"><label class="form-label">URL HTTPS</label><input class="form-control" name="url_conteudo" type="url" required maxlength="255" value="{{ $video->url_conteudo }}"></div>
                                    <div class="col-md-8"><label class="form-label">Descrição</label><textarea class="form-control" name="descricao_conteudo" maxlength="3000" required>{{ $video->descricao_conteudo }}</textarea></div>
                                    <div class="col-md-4"><label class="form-label">Disponível a partir de</label><input class="form-control" type="datetime-local" name="liberado_em_conteudo" required value="{{ \Illuminate\Support\Carbon::parse($video->liberado_em_conteudo)->format('Y-m-d\TH:i') }}"></div>
                                    <div class="col-12"><button class="btn btn-sm btn-outline-warning" type="submit">Salvar alterações</button></div>
                                </form>
                                <form class="mt-2" method="POST" action="{{ route('admin.eventos.videos.destroy', ['idEvento' => $evento->id_evento, 'idVideo' => $video->id_conteudos]) }}" onsubmit="return confirm('Excluir este vídeo permanentemente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Excluir vídeo</button>
                                </form>
                            </details>
                        </div>
                    @empty
                        <p class="text-body-secondary mb-0">Nenhum vídeo vinculado a este evento.</p>
                    @endforelse
                @endunless

                <details class="border rounded p-3 mb-3 mt-3">
                    <summary class="fw-semibold" style="cursor:pointer;">Adicionar vídeo em arquivo para o site (formato antigo)</summary>
                    <p class="small text-body-secondary mt-2 mb-3">A alternativa recomendada para o aplicativo é cadastrar uma URL acima. Este formulário preserva o cadastro antigo de arquivos usados no site.</p>
                    <form method="POST" action="{{ route('admin.video.create') }}" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_evento" value="{{ $evento->id_evento }}">
                        <div class="col-md-6"><label class="form-label">Título</label><input name="titulo_video" class="form-control" maxlength="50" required></div>
                        <div class="col-md-6"><label class="form-label">Subtítulo</label><input name="subtitulo_video" class="form-control" maxlength="50" required></div>
                        <div class="col-md-6"><label class="form-label">Legenda</label><input name="legenda_video" class="form-control" maxlength="100" required></div>
                        <div class="col-md-6"><label class="form-label">Breve descrição</label><input name="breve_descricao_video" class="form-control" maxlength="80" required></div>
                        <div class="col-md-4"><label class="form-label">Status</label><select name="status_video" class="form-select"><option value="ATIVO">Ativo</option><option value="INATIVO">Inativo</option></select></div>
                        <div class="col-md-4"><label class="form-label">Capa (até 2 MB)</label><input type="file" class="form-control" name="capa_video" accept="image/jpeg,image/png,image/webp" required></div>
                        <div class="col-md-4"><label class="form-label">Vídeo (MP4, WebM ou MOV, até 50 MB)</label><input type="file" class="form-control" name="url_video" accept="video/mp4,video/webm,video/quicktime" required></div>
                        <div class="col-12"><button class="btn btn-outline-warning" type="submit">Enviar vídeo para este evento</button></div>
                    </form>
                </details>

                @if($videosSite->isNotEmpty())
                    <div class="mt-4 pt-3 border-top" style="border-color: rgba(214,178,106,.2) !important;">
                        <h4 class="h6 fw-bold" style="color:var(--admin-shell-gold,#d6b26a);">Vídeos publicados no site (arquivos existentes)</h4>
                        <p class="text-body-secondary small">Estes vídeos foram cadastrados na antiga área de Modificações do Site. Permanecem vinculados a este evento e podem ser editados abaixo.</p>
                        @foreach($videosSite as $videoSite)
                            <details class="border rounded p-3 mb-2">
                                <summary class="fw-semibold" style="cursor:pointer;">{{ $videoSite->titulo_video }} — {{ $videoSite->status_video }}</summary>
                                <form method="POST" enctype="multipart/form-data" action="{{ route('admin.video.update', $videoSite->id_video) }}" class="row g-3 mt-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id_evento" value="{{ $evento->id_evento }}">
                                    <div class="col-md-6"><label class="form-label">Título</label><input class="form-control" name="titulo_video" maxlength="50" required value="{{ $videoSite->titulo_video }}"></div>
                                    <div class="col-md-6"><label class="form-label">Subtítulo</label><input class="form-control" name="subtitulo_video" maxlength="50" required value="{{ $videoSite->subtitulo_video }}"></div>
                                    <div class="col-md-6"><label class="form-label">Legenda</label><input class="form-control" name="legenda_video" maxlength="100" required value="{{ $videoSite->legenda_video }}"></div>
                                    <div class="col-md-6"><label class="form-label">Breve descrição</label><input class="form-control" name="breve_descricao_video" maxlength="80" required value="{{ $videoSite->breve_descricao_video }}"></div>
                                    <div class="col-md-4"><label class="form-label">Status</label><select class="form-select" name="status_video"><option value="ATIVO" @selected($videoSite->status_video === 'ATIVO')>Ativo</option><option value="INATIVO" @selected($videoSite->status_video === 'INATIVO')>Inativo</option></select></div>
                                    <div class="col-md-4"><label class="form-label">Substituir capa (opcional)</label><input class="form-control" type="file" name="capa_video" accept="image/jpeg,image/png,image/webp"></div>
                                    <div class="col-md-4"><label class="form-label">Substituir arquivo de vídeo (opcional)</label><input class="form-control" type="file" name="url_video" accept="video/mp4,video/webm,video/quicktime"></div>
                                    @if($videoSite->url_video)
                                    <div class="col-12"><a href="{{ asset('conexao360/img/' . $videoSite->url_video) }}" target="_blank" rel="noopener noreferrer">Ver vídeo atual <i class="bi bi-box-arrow-up-right"></i></a></div>
                                    @endif
                                    <div class="col-12"><button type="submit" class="btn btn-outline-warning">Salvar alterações</button></div>
                                </form>
                            </details>
                        @endforeach
                    </div>
                @endif

            </div>
        </section>

        {{-- ENQUETES: mantém respostas Sim/Não/Outro e todos os votos existentes. --}}
        <section id="enquetes" class="card shadow-sm mb-4" style="scroll-margin-top:20px;">
            <div class="card-header py-3 d-flex align-items-center gap-2">
                <i class="bi bi-ui-checks fs-4"></i>
                <div>
                    <h3 class="h5 fw-bold mb-0">Enquetes do evento</h3>
                    <small class="text-body-secondary">Perguntas com as opções Sim, Não e Outro</small>
                </div>
            </div>
            <div class="card-body">
                @unless($enquetesVinculadas)
                    <div class="alert alert-warning mb-0">Execute a migration de vínculo das enquetes para habilitar o cadastro.</div>
                @else
                    <form method="POST" action="{{ route('admin.eventos.enquetes.store', ['idEvento' => $evento->id_evento]) }}" class="row g-3 border rounded p-3 mb-4">
                        @csrf
                        <div class="col-12"><h4 class="h6 fw-bold mb-0">Criar enquete para este evento</h4></div>
                        <div class="col-md-9">
                            <label class="form-label" for="evento_pergunta_enquete">Pergunta (até 80 caracteres)</label>
                            <input class="form-control" id="evento_pergunta_enquete" name="pergunta_enquete" maxlength="80" value="{{ old('pergunta_enquete') }}" required placeholder="Ex.: Você participará da próxima palestra?">
                            <div class="form-text">Alternativas fixas: Sim · Não · Outro. As enquetes antigas não serão vinculadas automaticamente.</div>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button class="btn btn-warning w-100" type="submit"><i class="bi bi-plus-circle me-1"></i> Criar enquete</button>
                        </div>
                    </form>
                    @if($enquetesSemEvento->isNotEmpty())
                        <form method="POST" action="{{ route('admin.eventos.enquetes.vincular', ['idEvento' => $evento->id_evento]) }}" class="row g-3 border rounded p-3 mb-4">
                            @csrf
                            <div class="col-12"><h4 class="h6 fw-bold mb-0">Vincular enquete já cadastrada</h4></div>
                            <div class="col-md-9">
                                <label class="form-label" for="enquete_existente">Enquete sem evento</label>
                                <select class="form-select" id="enquete_existente" name="id_enquete" required>
                                    <option value="">Selecione uma enquete existente</option>
                                    @foreach($enquetesSemEvento as $semEvento)
                                        <option value="{{ $semEvento->id_enquete }}">{{ $semEvento->pergunta_enquete }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end"><button class="btn btn-outline-warning w-100" type="submit">Vincular</button></div>
                        </form>
                    @endif


                    @forelse($enquetes as $enquete)
                        <div class="border rounded p-3 mb-3 d-flex align-items-start justify-content-between flex-wrap gap-3">
                            <div>
                                <h4 class="h6 fw-bold mb-1">{{ $enquete->pergunta_enquete }}</h4>
                                <span class="text-body-secondary small">{{ $enquete->status_enquete }}</span>
                                <div class="text-body-secondary small mt-2">Votos: {{ $enquete->total_votos }} · Sim: {{ $enquete->votos_sim }} · Não: {{ $enquete->votos_nao }} · Outro: {{ $enquete->votos_outro }}</div>
                            </div>
                            <div class="d-flex flex-column gap-2">
                            <form method="POST" action="{{ route('admin.eventos.enquetes.status', ['idEvento' => $evento->id_evento, 'idEnquete' => $enquete->id_enquete]) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status_enquete" value="{{ $enquete->status_enquete === 'ATIVA' ? 'ENCERRADA' : 'ATIVA' }}">
                                <button type="submit" class="btn btn-sm btn-outline-warning">{{ $enquete->status_enquete === 'ATIVA' ? 'Encerrar enquete' : 'Reabrir enquete' }}</button>
                            </form>
                            </div>
                            @if($enquete->total_votos === 0)
                                <details class="w-100 border rounded p-3">
                                    <summary class="fw-semibold" style="cursor:pointer;">Editar enquete / excluir</summary>
                                    <form method="POST" class="row g-2 mt-2" action="{{ route('admin.eventos.enquetes.update', ['idEvento' => $evento->id_evento, 'idEnquete' => $enquete->id_enquete]) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-md-9"><label class="form-label">Pergunta</label><input class="form-control" name="pergunta_enquete" maxlength="80" required value="{{ $enquete->pergunta_enquete }}"></div>
                                        <div class="col-md-3 d-flex align-items-end"><button type="submit" class="btn btn-sm btn-outline-warning">Salvar</button></div>
                                    </form>
                                    <form method="POST" class="mt-2" action="{{ route('admin.eventos.enquetes.destroy', ['idEvento' => $evento->id_evento, 'idEnquete' => $enquete->id_enquete]) }}" onsubmit="return confirm('Excluir esta enquete sem votos permanentemente?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Excluir enquete</button>
                                    </form>
                                </details>
                            @else
                                <p class="small text-body-secondary w-100 mb-0">Esta enquete já recebeu votos. Para preservar os resultados, você pode encerrá-la, mas não alterar a pergunta nem excluí-la.</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-body-secondary mb-0">Nenhuma enquete vinculada a este evento.</p>
                    @endforelse
                @endunless
            </div>
        </section>

        {{-- PROGRAMAÇÃO: dados reais vinculados pelo id_evento (não demonstrativos). --}}
        <section id="programacao" class="card shadow-sm mb-4" style="scroll-margin-top:20px;">
            <div class="card-header py-3 d-flex align-items-center gap-2">
                <i class="bi bi-calendar-event fs-4"></i>
                <div>
                    <h3 class="h5 fw-bold mb-0">Programação do evento</h3>
                    <small class="text-body-secondary">Atividades entre {{ \Illuminate\Support\Carbon::parse($evento->data_inicial_evento)->format('d/m/Y') }} e {{ \Illuminate\Support\Carbon::parse($evento->data_termino_evento)->format('d/m/Y') }}</small>
                </div>
            </div>
            <div class="card-body">
                @unless($programacaoDisponivel)
                    <div class="alert alert-warning mb-0">Execute a migration de programação para cadastrar atividades e horários.</div>
                @else
                    <form method="POST" action="{{ route('admin.eventos.programacao.store', ['idEvento' => $evento->id_evento]) }}" class="row g-3 border rounded p-3 mb-4">
                        @csrf
                        <div class="col-12"><h4 class="h6 fw-bold mb-0">Adicionar atividade</h4></div>
                        <div class="col-md-6">
                            <label for="programacao_titulo" class="form-label">Título da atividade</label>
                            <input id="programacao_titulo" class="form-control" type="text" name="titulo_programacao" maxlength="150" value="{{ old('titulo_programacao') }}" placeholder="Ex.: Credenciamento e abertura" required>
                        </div>
                        <div class="col-md-3">
                            <label for="programacao_inicio" class="form-label">Início</label>
                            <input id="programacao_inicio" class="form-control" type="datetime-local" name="inicio_programacao" min="{{ $evento->data_inicial_evento }}T00:00" max="{{ $evento->data_termino_evento }}T23:59" value="{{ old('inicio_programacao', $evento->data_inicial_evento . 'T' . substr($evento->hora_inicial_evento, 0, 5)) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="programacao_fim" class="form-label">Término (opcional)</label>
                            <input id="programacao_fim" class="form-control" type="datetime-local" name="fim_programacao" min="{{ $evento->data_inicial_evento }}T00:00" max="{{ $evento->data_termino_evento }}T23:59" value="{{ old('fim_programacao') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="programacao_palestrante" class="form-label">Palestrante cadastrado (opcional)</label>
                            @if($palestrantesDisponiveis)
                                <input class="form-control mb-2" type="search" id="busca_palestrante_novo" data-busca-palestrante="programacao_palestrante" placeholder="Buscar por nome ou área de atuação" aria-label="Buscar palestrante cadastrado">
                                <select id="programacao_palestrante" class="form-select" name="id_palestrante" data-responsavel-externo="programacao_responsavel_externo">
                                    <option value="">Nenhum palestrante selecionado</option>
                                    @foreach($palestrantes->where('status_usuario', 'ATIVO') as $palestrante)
                                        <option value="{{ $palestrante->id_usuario }}" @selected(old('id_palestrante') == $palestrante->id_usuario)>{{ $palestrante->nome_usuario }}{{ $palestrante->area_atuacao_usuario ? ' · ' . $palestrante->area_atuacao_usuario : '' }}</option>
                                    @endforeach
                                </select>
                            @else
                                <div class="text-body-secondary small">Execute a migration de vínculo dos palestrantes para habilitar a seleção.</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="programacao_responsavel_externo" class="form-label">Responsável externo (opcional)</label>
                            <input id="programacao_responsavel_externo" class="form-control" name="palestrante_programacao" maxlength="150" value="{{ old('palestrante_programacao') }}" placeholder="Quando não houver palestrante cadastrado">
                        </div>
                        <div class="col-md-6">
                            <label for="programacao_local" class="form-label">Local ou sala (opcional)</label>
                            <input id="programacao_local" class="form-control" name="local_programacao" maxlength="150" value="{{ old('local_programacao') }}">
                        </div>
                        <div class="col-12">
                            <label for="programacao_descricao" class="form-label">Descrição (opcional)</label>
                            <textarea id="programacao_descricao" class="form-control" name="descricao_programacao" maxlength="3000" rows="2">{{ old('descricao_programacao') }}</textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-warning"><i class="bi bi-plus-circle me-1"></i> Adicionar à programação</button>
                        </div>
                    </form>

                    @forelse($programacao as $atividade)
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
                                <div>
                                    <div class="text-body-secondary small mb-1">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ \Illuminate\Support\Carbon::parse($atividade->inicio_programacao)->format('d/m/Y H:i') }}
                                        @if($atividade->fim_programacao)
                                            até {{ \Illuminate\Support\Carbon::parse($atividade->fim_programacao)->format('d/m/Y H:i') }}
                                        @endif
                                    </div>
                                    <h4 class="h6 fw-bold mb-1">{{ $atividade->titulo_programacao }}</h4>
                                    @if(($atividade->nome_palestrante_cadastrado ?? null) || $atividade->palestrante_programacao)
                                        <p class="text-body-secondary mb-1">Responsável: {{ ($atividade->nome_palestrante_cadastrado ?? null) ?: $atividade->palestrante_programacao }}</p>
                                    @endif
                                    @if($atividade->local_programacao)
                                        <p class="text-body-secondary mb-1">Local: {{ $atividade->local_programacao }}</p>
                                    @endif
                                    @if($atividade->descricao_programacao)
                                        <p class="text-body-secondary mb-1">{{ $atividade->descricao_programacao }}</p>
                                    @endif
                                    <span class="badge {{ $atividade->status_programacao === 'ATIVO' ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $atividade->status_programacao }}</span>
                                </div>
                                <form method="POST" action="{{ route('admin.eventos.programacao.status', ['idEvento' => $evento->id_evento, 'idProgramacao' => $atividade->id_programacao]) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status_programacao" value="{{ $atividade->status_programacao === 'ATIVO' ? 'INATIVO' : 'ATIVO' }}">
                                    <button type="submit" class="btn btn-sm btn-outline-warning">{{ $atividade->status_programacao === 'ATIVO' ? 'Inativar' : 'Reativar' }}</button>
                                </form>
                            </div>

                            <details class="mt-3">
                                <summary class="fw-semibold" style="cursor:pointer;color:var(--evento-gold);">Editar atividade</summary>
                                <form method="POST" action="{{ route('admin.eventos.programacao.update', ['idEvento' => $evento->id_evento, 'idProgramacao' => $atividade->id_programacao]) }}" class="row g-3 border rounded p-3 mt-2">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-md-6">
                                        <label class="form-label" for="titulo_{{ $atividade->id_programacao }}">Título</label>
                                        <input id="titulo_{{ $atividade->id_programacao }}" class="form-control" name="titulo_programacao" maxlength="150" value="{{ $atividade->titulo_programacao }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="inicio_{{ $atividade->id_programacao }}">Início</label>
                                        <input id="inicio_{{ $atividade->id_programacao }}" class="form-control" type="datetime-local" name="inicio_programacao" min="{{ $evento->data_inicial_evento }}T00:00" max="{{ $evento->data_termino_evento }}T23:59" value="{{ \Illuminate\Support\Carbon::parse($atividade->inicio_programacao)->format('Y-m-d\TH:i') }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="fim_{{ $atividade->id_programacao }}">Término</label>
                                        <input id="fim_{{ $atividade->id_programacao }}" class="form-control" type="datetime-local" name="fim_programacao" min="{{ $evento->data_inicial_evento }}T00:00" max="{{ $evento->data_termino_evento }}T23:59" value="{{ $atividade->fim_programacao ? \Illuminate\Support\Carbon::parse($atividade->fim_programacao)->format('Y-m-d\TH:i') : '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="palestrante_{{ $atividade->id_programacao }}">Palestrante cadastrado</label>
                                        @if($palestrantesDisponiveis)
                                            <input class="form-control mb-2" type="search" data-busca-palestrante="palestrante_{{ $atividade->id_programacao }}" placeholder="Buscar palestrante" aria-label="Buscar palestrante para atividade {{ $atividade->id_programacao }}">
                                            <select id="palestrante_{{ $atividade->id_programacao }}" class="form-select" name="id_palestrante" data-responsavel-externo="externo_{{ $atividade->id_programacao }}">
                                                <option value="">Nenhum palestrante selecionado</option>
                                                @foreach($palestrantes as $palestrante)
                                                    <option value="{{ $palestrante->id_usuario }}" @selected(($atividade->id_palestrante ?? null) == $palestrante->id_usuario)>{{ $palestrante->nome_usuario }}{{ $palestrante->area_atuacao_usuario ? ' · ' . $palestrante->area_atuacao_usuario : '' }}{{ $palestrante->status_usuario !== 'ATIVO' ? ' (inativo)' : '' }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="externo_{{ $atividade->id_programacao }}">Responsável externo</label>
                                        <input id="externo_{{ $atividade->id_programacao }}" class="form-control" name="palestrante_programacao" maxlength="150" value="{{ ($atividade->id_palestrante ?? null) ? '' : $atividade->palestrante_programacao }}" placeholder="Quando não houver palestrante cadastrado">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="local_{{ $atividade->id_programacao }}">Local/sala</label>
                                        <input id="local_{{ $atividade->id_programacao }}" class="form-control" name="local_programacao" maxlength="150" value="{{ $atividade->local_programacao }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label" for="descricao_{{ $atividade->id_programacao }}">Descrição</label>
                                        <textarea id="descricao_{{ $atividade->id_programacao }}" class="form-control" name="descricao_programacao" maxlength="3000" rows="2">{{ $atividade->descricao_programacao }}</textarea>
                                    </div>
                                    <div class="col-12"><button type="submit" class="btn btn-warning">Salvar alterações</button></div>
                                </form>
                            </details>
                        </div>
                    @empty
                        <p class="text-body-secondary mb-0">Nenhuma atividade cadastrada nesta edição.</p>
                    @endforelse
                @endunless
            </div>
        </section>

    </div>

</main>

<script>
    // Busca local nos palestrantes já cadastrados, sem requisições extras.
    document.querySelectorAll('[data-busca-palestrante]').forEach(function (busca) {
        const select = document.getElementById(busca.dataset.buscaPalestrante);
        if (!select) return;
        const opcoes = Array.from(select.options).map(function (opcao) {
            return { valor: opcao.value, texto: opcao.textContent };
        });
        const externo = document.getElementById(select.dataset.responsavelExterno);
        const normalizar = function (valor) {
            return (valor || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
        };
        function atualizar() {
            const atual = select.value;
            const termo = normalizar(busca.value.trim());
            select.replaceChildren();
            opcoes.forEach(function (opcao) {
                if (!opcao.valor || opcao.valor === atual || normalizar(opcao.texto).includes(termo)) {
                    const item = new Option(opcao.texto, opcao.valor);
                    select.add(item);
                }
            });
            select.value = atual;
            if (externo) {
                externo.disabled = Boolean(select.value);
                externo.title = select.value ? 'Remova o palestrante selecionado para informar um responsável externo.' : '';
            }
        }
        busca.addEventListener('input', atualizar);
        select.addEventListener('change', function () {
            busca.value = '';
            atualizar();
        });
        atualizar();
    });

    // Feedback exclusivo do cadastro de álbuns: não interfere nos demais formulários.
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('form-criar-album');
        if (!form) return;

        const titulo = document.getElementById('titulo_album');
        const aviso = document.getElementById('album-cliente-erro');
        const botao = document.getElementById('btn-criar-album');
        const enviando = document.getElementById('album-enviando');

        titulo.addEventListener('invalid', function () {
            aviso.classList.remove('d-none');
        });
        titulo.addEventListener('input', function () {
            if (titulo.value.trim()) aviso.classList.add('d-none');
        });

        form.addEventListener('submit', function (evento) {
            if (!titulo.value.trim()) {
                evento.preventDefault();
                aviso.classList.remove('d-none');
                titulo.focus();
                return;
            }
            botao.disabled = true;
            enviando.classList.remove('d-none');
        });

        // Impede que o botão permaneça desabilitado ao retornar pelo histórico.
        window.addEventListener('pageshow', function () {
            botao.disabled = false;
            enviando.classList.add('d-none');
        });
    });
</script>

@endsection
