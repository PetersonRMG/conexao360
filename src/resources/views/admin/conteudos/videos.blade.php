@extends('layout.admin')

@section('pg-titulo', 'Vídeos das Palestras')
@section('link-topo', 'Vídeos')

@section('content')

<div class="site-editor-main content-manager-page">
    <div class="site-editor-page">
        <div class="site-editor">

            <div class="site-editor-tabs-header mb-4">
                <div class="site-editor-tabs-title">
                    <i class="bi bi-camera-reels-fill"></i>

                    <div>
                        <strong>Vídeos das palestras</strong>
                        <span>
                            Cadastre o link do vídeo sem enviar arquivos pesados para o servidor.
                        </span>
                    </div>
                </div>

                <a href="{{ route('admin.conteudos.index') }}" class="content-manager-back-link">
                    <i class="bi bi-arrow-left"></i>
                    Conteúdos
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success mb-4">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <strong>
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Verifique os campos:
                    </strong>

                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="mb-4">
                <div class="site-editor-section-header">
                    <div>
                        <div class="site-editor-section-icon">
                            <i class="bi bi-plus-lg"></i>
                        </div>

                        <div>
                            <h4>Novo vídeo</h4>
                            <p>
                                Use uma URL do Instagram, YouTube, Vimeo ou de outra plataforma externa.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="site-editor-card">
                    <form action="{{ route('admin.conteudos.videos.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            <div class="col-lg-6">
                                <label for="titulo_conteudo" class="form-label">
                                    Título do vídeo
                                </label>

                                <input
                                    type="text"
                                    name="titulo_conteudo"
                                    id="titulo_conteudo"
                                    class="form-control"
                                    maxlength="150"
                                    value="{{ old('titulo_conteudo') }}"
                                    placeholder="Ex.: Estratégias para posicionamento profissional"
                                    required>
                            </div>

                            <div class="col-lg-6">
                                <label for="id_evento" class="form-label">
                                    Evento relacionado
                                </label>

                                <select
                                    name="id_evento"
                                    id="id_evento"
                                    class="form-select"
                                    required>

                                    <option value="">Selecione um evento</option>

                                    @foreach ($eventos as $evento)
                                        <option
                                            value="{{ $evento->id_evento }}"
                                            @selected(old('id_evento') == $evento->id_evento)>
                                            {{ $evento->titulo_evento }}
                                            @if ($evento->edicao_evento)
                                                — {{ $evento->edicao_evento }}ª edição
                                            @endif
                                        </option>
                                    @endforeach
                                </select>

                                <div class="form-text">
                                    O banco atual exige que o conteúdo esteja ligado a um evento.
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <label for="url_conteudo" class="form-label">
                                    URL do vídeo
                                </label>

                                <div class="content-manager-url-field">
                                    <span class="content-manager-url-icon">
                                        <i class="bi bi-link-45deg"></i>
                                    </span>

                                    <input
                                        type="url"
                                        name="url_conteudo"
                                        id="url_conteudo"
                                        class="form-control"
                                        maxlength="255"
                                        value="{{ old('url_conteudo') }}"
                                        placeholder="https://www.instagram.com/reel/..."
                                        required>
                                </div>

                                <div class="form-text">
                                    Você pode colar links do Instagram, YouTube, Vimeo ou de outra plataforma.
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label for="liberado_em_conteudo" class="form-label">
                                    Liberar em
                                </label>

                                <input
                                    type="datetime-local"
                                    name="liberado_em_conteudo"
                                    id="liberado_em_conteudo"
                                    class="form-control"
                                    value="{{ old('liberado_em_conteudo', now()->format('Y-m-d\\TH:i')) }}"
                                    required>

                                <div class="form-text">
                                    Define a data de liberação do conteúdo.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="descricao_conteudo" class="form-label">
                                    Descrição
                                </label>

                                <textarea
                                    name="descricao_conteudo"
                                    id="descricao_conteudo"
                                    rows="4"
                                    class="form-control"
                                    maxlength="3000"
                                    placeholder="Descreva brevemente o conteúdo do vídeo..."
                                    required>{{ old('descricao_conteudo') }}</textarea>
                            </div>
                        </div>

                        <div class="content-manager-form-note">
                            <i class="bi bi-info-circle"></i>
                            <span>
                                O vídeo continuará hospedado na plataforma de origem. O Conexão 360° armazenará apenas o link e os dados de organização.
                            </span>
                        </div>

                        <div class="site-editor-card-footer">
                            <button type="submit" class="btn-site-editor-save">
                                <i class="bi bi-plus-circle-fill"></i>
                                Cadastrar vídeo
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <section>
                <div class="site-editor-section-header">
                    <div>
                        <div class="site-editor-section-icon">
                            <i class="bi bi-collection-play"></i>
                        </div>

                        <div>
                            <h4>Vídeos cadastrados</h4>
                            <p>
                                Consulte a origem do vídeo, evento relacionado e status de exibição.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="content-video-grid">
                    @forelse ($videos as $video)
                        <article class="content-video-card">
                            <div class="content-video-card-head">
                                <div class="content-video-platform content-video-platform--{{ strtolower($video->plataforma) }}">
                                    @if ($video->plataforma === 'Instagram')
                                        <i class="bi bi-instagram"></i>
                                    @elseif ($video->plataforma === 'YouTube')
                                        <i class="bi bi-youtube"></i>
                                    @elseif ($video->plataforma === 'Vimeo')
                                        <i class="bi bi-play-btn"></i>
                                    @else
                                        <i class="bi bi-link-45deg"></i>
                                    @endif

                                    {{ $video->plataforma }}
                                </div>

                                @if ($video->status_conteudo === 'ATIVO')
                                    <span class="content-status content-status--active">
                                        <i class="bi bi-circle-fill"></i>
                                        Ativo
                                    </span>
                                @else
                                    <span class="content-status content-status--inactive">
                                        <i class="bi bi-circle-fill"></i>
                                        Inativo
                                    </span>
                                @endif
                            </div>

                            <div class="content-video-card-body">
                                <h3>{{ $video->titulo_conteudo }}</h3>

                                <p>{{ $video->descricao_conteudo }}</p>

                                <div class="content-video-meta">
                                    <span>
                                        <i class="bi bi-calendar-event"></i>
                                        {{ $video->evento?->titulo_evento ?? 'Evento não encontrado' }}
                                    </span>

                                    <span>
                                        <i class="bi bi-person"></i>
                                        {{ $video->usuario?->nome_usuario ?? 'Usuário não encontrado' }}
                                    </span>

                                    <span>
                                        <i class="bi bi-clock"></i>
                                        {{ optional($video->liberado_em_conteudo)->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                            </div>

                            <div class="content-video-card-footer">
                                <a
                                    href="{{ $video->url_conteudo }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="content-secondary-action">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                    Abrir vídeo
                                </a>

                                <form
                                    action="{{ route('admin.conteudos.videos.status', $video->id_conteudos) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')

                                    @if ($video->status_conteudo === 'ATIVO')
                                        <input type="hidden" name="status_conteudo" value="INATIVO">

                                        <button type="submit" class="content-status-action content-status-action--deactivate">
                                            <i class="bi bi-eye-slash"></i>
                                            Inativar
                                        </button>
                                    @else
                                        <input type="hidden" name="status_conteudo" value="ATIVO">

                                        <button type="submit" class="content-status-action content-status-action--activate">
                                            <i class="bi bi-eye"></i>
                                            Ativar
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </article>
                    @empty
                        <div class="content-manager-empty">
                            <span class="content-manager-empty-icon">
                                <i class="bi bi-camera-reels"></i>
                            </span>

                            <h5>Nenhum vídeo cadastrado</h5>
                            <p>Os vídeos das palestras aparecerão aqui após o primeiro cadastro.</p>
                        </div>
                    @endforelse
                </div>
            </section>

        </div>
    </div>
</div>

@endsection
