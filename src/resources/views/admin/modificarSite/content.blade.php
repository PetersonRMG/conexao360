@extends('layout.admin')
@section('title', 'Modificação do Site')
@section('pg-titulo', 'Modificação do Site')
@section('link-topo', 'Modificação do Site')

@section('content')
        <main
        class="app-main dash-main--bg "
        style="--dash-main-bg-image: url('{{ asset('dash/assets/img/bg-dash.png') }}');"
    >

        <div class="app-content-header">
            <div class="container-fluid"></div>
        </div>

        <div class="app-content container-fluid mt-5">

<div class="site-editor">

    {{-- ==========================================================
         ABAS DE EDIÇÃO
    =========================================================== --}}
    <div class="site-editor-tabs">

        <div class="site-editor-tabs-header">

            <div class="site-editor-tabs-title">
                <i class="bi bi-layout-text-window-reverse"></i>

                <div>
                    <strong>Conteúdo do Site</strong>
                    <span>Gerencie cada seção da Landing Page</span>
                </div>
            </div>

            <ul class="nav nav-tabs site-editor-nav" id="siteEditorTabs" role="tablist">

                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link active"
                        id="banner-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#banner-pane"
                        type="button"
                        role="tab"
                        aria-controls="banner-pane"
                        aria-selected="true"
                    >
                        <i class="bi bi-image"></i>
                        <span>Banner</span>
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link"
                        id="eventos-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#eventos-pane"
                        type="button"
                        role="tab"
                        aria-controls="eventos-pane"
                        aria-selected="false"
                    >
                        <i class="bi bi-calendar-event"></i>
                        <span>Eventos</span>
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link"
                        id="temas-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#temas-pane"
                        type="button"
                        role="tab"
                        aria-controls="temas-pane"
                        aria-selected="false"
                    >
                        <i class="bi bi-palette"></i>
                        <span>Temas</span>
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link"
                        id="videos-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#videos-pane"
                        type="button"
                        role="tab"
                        aria-controls="videos-pane"
                        aria-selected="false"
                    >
                        <i class="bi bi-play-btn"></i>
                        <span>Vídeos</span>
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link"
                        id="dra-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#dra-pane"
                        type="button"
                        role="tab"
                        aria-controls="dra-pane"
                        aria-selected="false"
                    >
                        <i class="bi bi-person-badge"></i>
                        <span>Dra.</span>
                    </button>
                </li>

            </ul>

        </div>


        {{-- ==========================================================
             CONTEÚDO DAS ABAS
        =========================================================== --}}
        <div class="tab-content site-editor-tab-content" id="siteEditorTabContent">


            {{-- ======================================================
                 BANNER
            ======================================================= --}}
            <div
                class="tab-pane fade show active"
                id="banner-pane"
                role="tabpanel"
                aria-labelledby="banner-tab"
                tabindex="0"
            >

                <div class="site-editor-section-header">

                    <div>
                        <span class="site-editor-section-icon">
                            <i class="bi bi-image"></i>
                        </span>

                        <div>
                            <h4>Editar Banner</h4>
                            <p>Configure o conteúdo principal exibido na Landing Page.</p>
                        </div>
                    </div>

                    <button
                        type="button"
                        class="btn-site-editor-add"
                        data-bs-toggle="modal"
                        data-bs-target="#criarBanner"
                    >
                        <i class="bi bi-plus-circle"></i>
                        Novo Banner
                    </button>

                </div>


                <div class="site-editor-content">

                    <div class="row g-4 justify-content-center">

                        @foreach($hero as $item)

                            <div class="col-12">

                                <form
                                    action="{{ route('admin.hero.update', $item->id_hero_section) }}"
                                    method="POST"
                                    enctype="multipart/form-data"
                                >

                                    @csrf
                                    @method('PUT')

                                    <div class="site-editor-card">

                                        <div class="row g-4 align-items-start">

                                            <div class="col-12 col-lg-8">

                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Chamada Superior
                                                    </label>

                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="tagline_hero"
                                                        value="{{ $item->tagline_hero }}"
                                                    >
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Título Principal
                                                    </label>

                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="titulo_hero"
                                                        value="{{ $item->titulo_hero }}"
                                                    >
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Subtítulo
                                                    </label>

                                                    <textarea
                                                        class="form-control"
                                                        name="subtitulo_hero"
                                                        rows="4"
                                                    >{{ $item->subtitulo_hero }}</textarea>
                                                </div>

                                                <div class="row">

                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label">
                                                            Texto do Botão
                                                        </label>

                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            name="texto_botao_hero"
                                                            value="{{ $item->texto_botao_hero }}"
                                                        >
                                                    </div>

                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label">
                                                            Link do Botão
                                                        </label>

                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            name="link_botao_hero"
                                                            value="{{ $item->link_botao_hero }}"
                                                        >
                                                    </div>

                                                    <div class="col-12 col-md-6 mb-3">
                                                        <label class="form-label">
                                                            Status
                                                        </label>

                                                        <select
                                                            class="form-select"
                                                            name="status_hero"
                                                        >
                                                            <option
                                                                value="ATIVO"
                                                                {{ $item->status_hero == 'ATIVO' ? 'selected' : '' }}
                                                            >
                                                                Ativo
                                                            </option>

                                                            <option
                                                                value="INATIVO"
                                                                {{ $item->status_hero == 'INATIVO' ? 'selected' : '' }}
                                                            >
                                                                Inativo
                                                            </option>
                                                        </select>
                                                    </div>

                                                </div>

                                            </div>


                                            <div class="col-12 col-lg-4">

                                                <label class="form-label text-center d-block">
                                                    Banner Atual
                                                </label>

                                                <div class="media-preview-container mb-3">
                                                    <img
                                                        src="{{ asset('conexao360/img/' . $item->foto_banner) }}"
                                                        class="img-fluid"
                                                        alt="Banner atual"
                                                    >
                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">
                                                        Alterar Banner
                                                    </label>

                                                    <input
                                                        type="file"
                                                        class="form-control"
                                                        name="foto_banner"
                                                        accept="image/*"
                                                    >

                                                </div>

                                            </div>

                                        </div>


                                        <div class="site-editor-card-footer">

                                            <button
                                                type="submit"
                                                class="btn-site-editor-save"
                                            >
                                                <i class="bi bi-check-circle"></i>
                                                Salvar Banner
                                            </button>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>


            {{-- ======================================================
                 EVENTOS
            ======================================================= --}}
            <div
                class="tab-pane fade"
                id="eventos-pane"
                role="tabpanel"
                aria-labelledby="eventos-tab"
                tabindex="0"
            >

                <div class="site-editor-section-header">

                    <div>
                        <span class="site-editor-section-icon">
                            <i class="bi bi-calendar-event"></i>
                        </span>

                        <div>
                            <h4>Editar Eventos</h4>
                            <p>Gerencie os eventos exibidos na Landing Page.</p>
                        </div>
                    </div>

                    <button
                        type="button"
                        class="btn-site-editor-add"
                        data-bs-toggle="modal"
                        data-bs-target="#criarEvento"
                    >
                        <i class="bi bi-plus-circle"></i>
                        Novo Evento
                    </button>

                </div>

                <div class="site-editor-content">

                    <div class="row g-4">

                        @foreach ($evento as $item)

                            <div class="col-12 col-md-6">

                                <form
                                    method="POST"
                                    action="{{ route('admin.evento.update', $item->id_evento) }}"
                                    enctype="multipart/form-data"
                                >

                                    @csrf
                                    @method('PUT')

                                    <div class="site-editor-card h-100">

                                        {{-- MANTENHA AQUI O CONTEÚDO
                                             DO FORMULÁRIO DE EVENTOS
                                             QUE VOCÊ JÁ POSSUI --}}

                                        <div class="premium-item-card">

                                            <label class="form-label text-center d-block">
                                                Banner do Evento
                                            </label>

                                            <div class="media-preview-container mb-3">
                                                <iframe
                                                    src="{{ $item->url_evento }}"
                                                    width="600"
                                                    height="50"
                                                    style="border:0;"
                                                    allowfullscreen
                                                    loading="lazy"
                                                    referrerpolicy="no-referrer-when-downgrade"
                                                ></iframe>
                                            </div>

                                            <div class="mb-3">
                                                <input
                                                    type="file"
                                                    class="form-control"
                                                    name="banner_evento"
                                                    accept="image/png,image/jpeg,image/webp"
                                                >
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Título Evento
                                                </label>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="titulo_evento"
                                                    value="{{ $item->titulo_evento }}"
                                                >
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Edição Evento
                                                </label>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="edicao_evento"
                                                    value="{{ $item->edicao_evento }}"
                                                >
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Descrição
                                                </label>

                                                <textarea
                                                    class="form-control"
                                                    rows="4"
                                                    name="descricao_evento"
                                                >{{ $item->descricao_evento }}</textarea>
                                            </div>

                                            <div class="row">

                                                <div class="col-6 mb-3">
                                                    <label class="form-label">
                                                        Data Início
                                                    </label>

                                                    <input
                                                        type="date"
                                                        class="form-control"
                                                        name="data_inicial_evento"
                                                        value="{{ $item->data_inicial_evento }}"
                                                    >
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label class="form-label">
                                                        Hora Início
                                                    </label>

                                                    <input
                                                        type="time"
                                                        class="form-control"
                                                        name="hora_inicial_evento"
                                                        value="{{ $item->hora_inicial_evento }}"
                                                    >
                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-6 mb-3">
                                                    <label class="form-label">
                                                        Data Término
                                                    </label>

                                                    <input
                                                        type="date"
                                                        class="form-control"
                                                        name="data_termino_evento"
                                                        value="{{ $item->data_termino_evento }}"
                                                    >
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <label class="form-label">
                                                        Hora Término
                                                    </label>

                                                    <input
                                                        type="time"
                                                        class="form-control"
                                                        name="hora_termino_evento"
                                                        value="{{ $item->hora_termino_evento }}"
                                                    >
                                                </div>

                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Endereço
                                                </label>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="endereco_evento"
                                                    value="{{ $item->endereco_evento }}"
                                                >
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    URL Evento
                                                </label>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="url_evento"
                                                    value="{{ $item->url_evento }}"
                                                >
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Status
                                                </label>

                                                <select
                                                    class="form-select"
                                                    name="status_evento"
                                                >
                                                    <option value="ATIVO" {{ $item->status_evento == 'ATIVO' ? 'selected' : '' }}>
                                                        Ativo
                                                    </option>

                                                    <option value="INATIVO" {{ $item->status_evento == 'INATIVO' ? 'selected' : '' }}>
                                                        Inativo
                                                    </option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="site-editor-card-footer">

                                            <button
                                                type="submit"
                                                class="btn-site-editor-save w-100"
                                            >
                                                <i class="bi bi-check-circle"></i>
                                                Salvar Evento
                                            </button>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>


            {{-- ======================================================
                 TEMAS
            ======================================================= --}}
            <div
                class="tab-pane fade"
                id="temas-pane"
                role="tabpanel"
                aria-labelledby="temas-tab"
                tabindex="0"
            >

                <div class="site-editor-section-header">

                    <div>
                        <span class="site-editor-section-icon">
                            <i class="bi bi-palette"></i>
                        </span>

                        <div>
                            <h4>Editar Temas</h4>
                            <p>Configure os temas e conteúdos relacionados.</p>
                        </div>
                    </div>

                    <button
                        type="button"
                        class="btn-site-editor-add"
                        data-bs-toggle="modal"
                        data-bs-target="#criarTemas"
                    >
                        <i class="bi bi-plus-circle"></i>
                        Novo Tema
                    </button>

                </div>

                <div class="site-editor-content">

                    <div class="row g-4">

                        @foreach ($temas as $item)

                            <div class="col-12 col-md-6">

                                <form
                                    method="POST"
                                    action="{{ route('admin.tema.update', $item->id_tema) }}"
                                    enctype="multipart/form-data"
                                >

                                    @csrf
                                    @method('PUT')

                                    <div class="site-editor-card h-100">

                                        <div class="premium-item-card">

                                            <label class="form-label d-block text-center">
                                                Foto do Tema
                                            </label>

                                            <div
                                                class="media-preview-container mb-3"
                                                style="height: 100px; width: 100px; margin: 0 auto;"
                                            >
                                                <img
                                                    src="{{ asset('conexao360/img/' . $item->foto_tema) }}"
                                                    alt="{{ $item->titulo_tema }}"
                                                >
                                            </div>

                                            <div class="mb-3">

                                                <input
                                                    class="form-control"
                                                    name="foto_tema"
                                                    type="file"
                                                    accept="image/png,image/jpeg,image/webp"
                                                >

                                                <div class="form-text">
                                                    Escolha a foto do Tema.
                                                </div>

                                            </div>

                                            <div class="mb-3">

                                                <label class="form-label">
                                                    Título Tema
                                                </label>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="titulo_tema"
                                                    value="{{ $item->titulo_tema }}"
                                                >

                                            </div>

                                            <div class="mb-3">

                                                <label class="form-label">
                                                    Subtítulo Tema
                                                </label>

                                                <textarea
                                                    class="form-control"
                                                    name="subtitulo_tema"
                                                    rows="4"
                                                >{{ $item->subtitulo_tema }}</textarea>

                                            </div>

                                            <div class="mb-3">

                                                <label class="form-label">
                                                    Breve Descrição
                                                </label>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="breve_descricao_tema"
                                                    value="{{ $item->breve_descricao_tema }}"
                                                >

                                            </div>

                                            <div class="mb-3">

                                                <label class="form-label">
                                                    Status
                                                </label>

                                                <select
                                                    class="form-select"
                                                    required
                                                    name="status_tema"
                                                >

                                                    <option value="ATIVO" {{ $item->status_tema == 'ATIVO' ? 'selected' : '' }}>
                                                        Ativo
                                                    </option>

                                                    <option value="INATIVO" {{ $item->status_tema == 'INATIVO' ? 'selected' : '' }}>
                                                        Inativo
                                                    </option>

                                                </select>

                                            </div>

                                        </div>

                                        <div class="site-editor-card-footer">

                                            <button
                                                type="submit"
                                                class="btn-site-editor-save"
                                            >
                                                <i class="bi bi-check-circle"></i>
                                                Salvar Tema
                                            </button>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>


            {{-- ======================================================
                 VÍDEOS
            ======================================================= --}}
            <div
                class="tab-pane fade"
                id="videos-pane"
                role="tabpanel"
                aria-labelledby="videos-tab"
                tabindex="0"
            >

                <div class="site-editor-section-header">

                    <div>
                        <span class="site-editor-section-icon">
                            <i class="bi bi-play-btn"></i>
                        </span>

                        <div>
                            <h4>Editar Vídeos</h4>
                            <p>Gerencie os vídeos apresentados no site.</p>
                        </div>
                    </div>

                    <button
                        type="button"
                        class="btn-site-editor-add"
                        data-bs-toggle="modal"
                        data-bs-target="#criarVideo"
                    >
                        <i class="bi bi-plus-circle"></i>
                        Novo Vídeo
                    </button>

                </div>

                <div class="site-editor-content">

                    {{-- COLOQUE AQUI O SEU @foreach ($video as $item)
                         COM O FORMULÁRIO ORIGINAL --}}

                    @foreach ($video as $item)

                        <div class="row g-4">

                            <div class="col-12">

                                <form
                                    method="POST"
                                    action="{{ route('admin.video.update', $item->id_video) }}"
                                    enctype="multipart/form-data"
                                >

                                    @csrf
                                    @method('PUT')

                                    <div class="site-editor-card">

                                        <div class="row g-4">

                                            <div class="col-12 col-lg-8">

                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Título do Vídeo
                                                    </label>

                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="titulo_video"
                                                        value="{{ $item->titulo_video }}"
                                                    >
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Subtítulo
                                                    </label>

                                                    <textarea
                                                        class="form-control"
                                                        name="subtitulo_video"
                                                        rows="3"
                                                    >{{ $item->subtitulo_video }}</textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Breve Descrição
                                                    </label>

                                                    <textarea
                                                        class="form-control"
                                                        name="breve_descricao_video"
                                                        rows="4"
                                                    >{{ $item->breve_descricao_video }}</textarea>
                                                </div>

                                                <div class="row">

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">
                                                            Legenda
                                                        </label>

                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            name="legenda_video"
                                                            value="{{ $item->legenda_video }}"
                                                        >
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">
                                                            Status
                                                        </label>

                                                        <select
                                                            class="form-select"
                                                            name="status_video"
                                                        >

                                                            <option value="ATIVO" {{ $item->status_video == 'ATIVO' ? 'selected' : '' }}>
                                                                Ativo
                                                            </option>

                                                            <option value="INATIVO" {{ $item->status_video == 'INATIVO' ? 'selected' : '' }}>
                                                                Inativo
                                                            </option>

                                                        </select>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-12 col-lg-4">

                                                <label class="form-label">
                                                    Capa Atual
                                                </label>

                                                <div class="media-preview-container mb-3">
                                                    <img
                                                        src="{{ asset('conexao360/img/' . $item->capa_video) }}"
                                                        alt="{{ $item->titulo_video }}"
                                                    >
                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">
                                                        Alterar Capa
                                                    </label>

                                                    <input
                                                        type="file"
                                                        class="form-control"
                                                        name="capa_video"
                                                        accept="image/png,image/jpeg,image/webp"
                                                    >

                                                </div>

                                                <label class="form-label">
                                                    Vídeo Atual
                                                </label>

                                                <div class="media-preview-container mb-3">

                                                    <video
                                                        class="w-100 rounded"
                                                        controls
                                                    >
                                                        <source
                                                            src="{{ asset('conexao360/img/' . $item->url_video) }}"
                                                            type="video/mp4"
                                                        >
                                                    </video>

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">
                                                        Alterar Vídeo
                                                    </label>

                                                    <input
                                                        type="file"
                                                        class="form-control"
                                                        name="url_video"
                                                        accept="video/mp4,video/webm,video/quicktime"
                                                    >

                                                </div>

                                            </div>

                                        </div>

                                        <div class="site-editor-card-footer">

                                            <button
                                                type="submit"
                                                class="btn-site-editor-save"
                                            >
                                                <i class="bi bi-check-circle"></i>
                                                Salvar Vídeo
                                            </button>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>


            {{-- ======================================================
                 DRA
            ======================================================= --}}
            <div
                class="tab-pane fade"
                id="dra-pane"
                role="tabpanel"
                aria-labelledby="dra-tab"
                tabindex="0"
            >

                <div class="site-editor-section-header">

                    <div>
                        <span class="site-editor-section-icon">
                            <i class="bi bi-person-badge"></i>
                        </span>

                        <div>
                            <h4>Editar Dra.</h4>
                            <p>Gerencie as informações apresentadas na seção da Dra.</p>
                        </div>
                    </div>

                    <button
                        type="button"
                        class="btn-site-editor-add"
                        data-bs-toggle="modal"
                        data-bs-target="#criarDra"
                    >
                        <i class="bi bi-plus-circle"></i>
                        Nova Dra.
                    </button>

                </div>

                <div class="site-editor-content">

                    @foreach ($dra as $item)

                        <div class="row g-4">

                            <div class="col-12">

                                <form
                                    method="POST"
                                    action="{{ route('admin.dra.update', $item->id_dra) }}"
                                    enctype="multipart/form-data"
                                >

                                    @csrf
                                    @method('PUT')

                                    <div class="site-editor-card">

                                        <div class="row g-4">

                                            <div class="col-12 col-lg-8">

                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Título
                                                    </label>

                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="titulo_dra"
                                                        value="{{ $item->titulo_dra }}"
                                                    >
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Subtítulo
                                                    </label>

                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="sub_titulo_dra"
                                                        value="{{ $item->sub_titulo_dra }}"
                                                    >
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Descrição
                                                    </label>

                                                    <textarea
                                                        class="form-control"
                                                        name="descricao_dra"
                                                        rows="6"
                                                    >{{ $item->descricao_dra }}</textarea>
                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">
                                                        Status
                                                    </label>

                                                    <select
                                                        class="form-select"
                                                        name="status_dra"
                                                    >

                                                        <option value="ATIVO" {{ $item->status_dra == 'ATIVO' ? 'selected' : '' }}>
                                                            Ativo
                                                        </option>

                                                        <option value="INATIVO" {{ $item->status_dra == 'INATIVO' ? 'selected' : '' }}>
                                                            Inativo
                                                        </option>

                                                    </select>

                                                </div>

                                            </div>

                                            <div class="col-12 col-lg-4">

                                                <label class="form-label text-center d-block">
                                                    Foto Atual
                                                </label>

                                                <div class="media-preview-container mb-3">

                                                    <img
                                                        src="{{ asset('conexao360/img/' . $item->foto_dra) }}"
                                                        alt="{{ $item->titulo_dra }}"
                                                    >

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">
                                                        Alterar Foto
                                                    </label>

                                                    <input
                                                        type="file"
                                                        class="form-control"
                                                        name="foto_dra"
                                                        accept="image/png,image/jpeg,image/webp"
                                                    >

                                                </div>

                                            </div>

                                        </div>

                                        <div class="site-editor-card-footer">

                                            <button
                                                type="submit"
                                                class="btn-site-editor-save"
                                            >
                                                <i class="bi bi-check-circle"></i>
                                                Salvar Alterações
                                            </button>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

</div>

        </div>

    </main>

        @include('admin.modal.criar-videos')
        @include('admin.modal.criar-banner')
        @include('admin.modal.criar-evento')
        @include('admin.modal.criar-temas')
        @include('admin.modal.criar-dra')

        {{-- Container global para Toasts fora das estruturas de repetição --}}
        @if (session('success'))
            <div class="toast-container dash-toast-container position-fixed bottom-0 end-0 p-3">
                <div id="liveToast" class="toast show bg-dark text-white border-0 shadow-lg" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="toast-header bg-dark text-warning border-bottom border-secondary">
                        <i class="bi bi-bookmark-star-fill me-2"></i>
                        <strong class="me-auto">Alterado com Sucesso</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body text-light-50">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif
@endsection