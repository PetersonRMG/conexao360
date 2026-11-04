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

                <a href="{{ route('admin.modificar.site') }}#eventos-pane" class="text-decoration-none d-inline-block mb-2">

                    <i class="bi bi-arrow-left"></i> Voltar para Modificações do Site

                </a>

                <h2 class="fw-bold mb-1" style="font-size:1.6rem;">{{ $evento->titulo_evento }}</h2>

                <div class="text-body-secondary" style="font-size:1rem;">

                    {{ $evento->edicao_evento }} · {{ $evento->endereco_evento }}

                </div>

                <p class="text-body-secondary mb-0 mt-2">Gerencie as fotos, os vídeos e as enquetes vinculadas a esta edição.</p>

            </div>

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

            <div class="col-12 col-md-4">

                <a href="#fotos" class="text-decoration-none">

                    <div class="card h-100 shadow-sm"><div class="card-body">

                        <i class="bi bi-images me-2"></i><strong>Galeria de fotos</strong>

                        <div class="fs-4 fw-bold mt-2">{{ $totalFotos }}</div>

                        <span class="text-body-secondary">{{ $albuns->count() }} álbuns deste evento</span>

                    </div></div>

                </a>

            </div>

            <div class="col-12 col-md-4">

                <a href="#videos" class="text-decoration-none">

                    <div class="card h-100 shadow-sm"><div class="card-body">

                        <i class="bi bi-camera-video me-2"></i><strong>Vídeos</strong>

                        <div class="fs-4 fw-bold mt-2">{{ $videos->count() }}</div>

                        <span class="text-body-secondary">Conteúdos ligados a esta edição</span>

                    </div></div>

                </a>

            </div>

            <div class="col-12 col-md-4">

                <a href="#enquetes" class="text-decoration-none">

                    <div class="card h-100 shadow-sm"><div class="card-body">

                        <i class="bi bi-ui-checks me-2"></i><strong>Enquetes</strong>

                        <div class="fs-4 fw-bold mt-2">{{ $enquetes->count() }}</div>

                        <span class="text-body-secondary">{{ $enquetesVinculadas ? 'Vinculadas a esta edição' : 'Vínculo ao evento ainda não configurado' }}</span>

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

                            @if($album->fotos->isNotEmpty())

                                <div class="row g-2 mb-3">

                                    @foreach($album->fotos as $foto)

                                        <div class="col-6 col-sm-4 col-lg-3">

                                            <a href="{{ asset('conexao360/uploads/galeria/' . $foto->arquivo_foto) }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none">

                                                <img src="{{ asset('conexao360/uploads/galeria/' . $foto->arquivo_foto) }}" alt="{{ $foto->titulo_foto }}" class="rounded border w-100" style="height:125px;object-fit:cover;" loading="lazy">

                                                <div class="small mt-1">{{ $foto->titulo_foto }}</div>

                                            </a>

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

        <section id="videos" class="card shadow-sm mb-4" style="scroll-margin-top:20px;">

            <div class="card-header py-3"><h3 class="h5 fw-bold mb-0"><i class="bi bi-camera-video me-2"></i>Vídeos</h3></div>

            <div class="card-body">

                <p class="text-body-secondary">Os vídeos já utilizam <code>tbl_conteudos.id_evento</code>. O cadastro continua no módulo existente; aqui você confere os vídeos associados a este evento.</p>

                @if(Route::has('admin.conteudos.videos'))

                    <a href="{{ route('admin.conteudos.videos') }}" class="btn btn-outline-warning mb-3"><i class="bi bi-box-arrow-up-right me-1"></i> Gerenciar vídeos</a>

                @endif

                @unless($videosDisponiveis)

                    <div class="alert alert-warning mb-0">A estrutura de vídeos ainda não está disponível neste banco.</div>

                @else

                    @forelse($videos as $video)

                        <div class="d-flex align-items-start justify-content-between gap-3 border-bottom py-3">

                            <div>

                                <strong>{{ $video->titulo_conteudo }}</strong>

                                <div class="text-body-secondary small">Status: {{ $video->status_conteudo ?? 'Não informado' }}</div>

                                @if(!empty($video->url_conteudo))

                                    @php($videoUrl = $video->url_conteudo)

                                    @if(filter_var($videoUrl, FILTER_VALIDATE_URL) && parse_url($videoUrl, PHP_URL_SCHEME) === 'https')

                                        <a href="{{ $videoUrl }}" target="_blank" rel="noopener noreferrer">Abrir vídeo</a>

                                    @endif

                                @endif

                            </div>

                        </div>

                    @empty

                        <p class="text-body-secondary mb-0">Nenhum vídeo associado a este evento.</p>

                    @endforelse

                @endunless

            </div>

        </section>

        <section id="enquetes" class="card shadow-sm mb-4" style="scroll-margin-top:20px;">

            <div class="card-header py-3"><h3 class="h5 fw-bold mb-0"><i class="bi bi-ui-checks me-2"></i>Enquetes</h3></div>

            <div class="card-body">

                @if(Route::has('admin.enquetes.index'))

                    <a href="{{ route('admin.enquetes.index') }}" class="btn btn-outline-warning mb-3"><i class="bi bi-box-arrow-up-right me-1"></i> Gerenciar enquetes</a>

                @endif

                @unless($enquetesVinculadas)

                    <div class="alert alert-info mb-0">

                        O módulo de enquetes já existe, mas esta base ainda não possui a coluna <code>tbl_enquetes.id_evento</code>.

                        Não foram vinculadas enquetes automaticamente, para evitar associações incorretas.

                    </div>

                @else

                    @forelse($enquetes as $enquete)

                        <div class="border-bottom py-3">

                            <strong>{{ $enquete->pergunta_enquete }}</strong>

                            <div class="small text-body-secondary">Status: {{ $enquete->status_enquete ?? 'Não informado' }}</div>

                        </div>

                    @empty

                        <p class="text-body-secondary mb-0">Nenhuma enquete vinculada a este evento.</p>

                    @endforelse

                @endunless

            </div>

        </section>

        <div class="alert alert-secondary" role="note">

            <strong>Programação:</strong> a estrutura atual ainda utiliza dados demonstrativos no aplicativo. Não será criado um cadastro novo até validarmos a fonte da programação no Laravel.

        </div>

    </div>

</main>

<script>
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
