@section('title', 'Modificação do Site')
@section('pg-titulo', 'Modificação do Site')
@section('link-topo', 'Modificação do Site')

<main class="app-main"  style="
  background-image: url({{ asset('dash/assets/img/bg-dash.png') }});
  background-repeat: no-repeat;
  background-position: right 200px ;
  background-size: 1000px;
  
">
    <div class="app-content-header">
        <div class="container-fluid"></div>
    </div>

    <div class="app-content container-fluid  mt-5 " >
        <div class="row g-4">
            <div class="col-12 col-xl-10 ">

                {{-- EDITAR BANNER PRINCIPAL --}}
                <details class="premium-accordion-wrapper">
                    <summary class="premium-card-header">
                        <h3 class="premium-card-title">
                            <i class="bi bi-image"></i> Editar Banner
                        </h3>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn-premium-add" data-bs-toggle="modal"
                                data-bs-target="#criarBanner" onclick="event.stopPropagation();">
                                <i class="bi bi-plus-circle"></i> Novo Banner
                            </button>
                            <i class="bi bi-chevron-down fs-5"></i>
                        </div>
                    </summary>

                    <div class="premium-card-body-content p-4">
                        <div class="row g-4 justify-content-center">
                            @foreach($hero as $item)
                                <div class="col-12">
                                    <form action="{{ route('admin.hero.update', $item->id_hero_section) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="premium-item-card">
                                            <div class="row g-4 align-items-start">
                                                <div class="col-12 col-lg-8">
                                                    <div class="mb-3">
                                                        <label class="form-label">Chamada Superior</label>
                                                        <input type="text" class="form-control" name="tagline_hero"
                                                            value="{{ $item->tagline_hero }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Título Principal</label>
                                                        <input type="text" class="form-control" name="titulo_hero"
                                                            value="{{ $item->titulo_hero }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Subtítulo</label>
                                                        <textarea class="form-control" name="subtitulo_hero"
                                                            rows="4">{{ $item->subtitulo_hero }}</textarea>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 col-md-6 mb-3">
                                                            <label class="form-label">Texto do Botão</label>
                                                            <input type="text" class="form-control" name="texto_botao_hero"
                                                                value="{{ $item->texto_botao_hero }}">
                                                        </div>

                                                        <div class="col-12 col-md-6 mb-3">
                                                            <label class="form-label">Link do Botão</label>
                                                            <input type="text" class="form-control" name="link_botao_hero"
                                                                value="{{ $item->link_botao_hero }}">
                                                        </div>

                                                        <div class="col-12 col-md-6 mb-3">
                                                            <label class="form-label">Status</label>
                                                            <select class="form-select" name="status_hero">
                                                                <option value="ATIVO" {{ $item->status_hero == 'ATIVO' ? 'selected' : '' }}>Ativo</option>
                                                                <option value="INATIVO" {{ $item->status_hero == 'INATIVO' ? 'selected' : '' }}>Inativo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-lg-4">
                                                    <label class="form-label text-center d-block">Banner Atual</label>
                                                    <div class="media-preview-container mb-3">
                                                        <img src="{{ asset('conexao360/img/' . $item->foto_banner) }}"
                                                            class="img-fluid">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Alterar Banner</label>
                                                        <input type="file" class="form-control" name="foto_banner"
                                                            accept="image/*">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="border-top border-secondary pt-3 mt-3 text-end">
                                                <button type="submit" class="btn-premium-confirm">
                                                    <i class="bi bi-check-circle me-1"></i> Salvar Banner
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </details>

                {{-- EDITAR LOCAL / EVENTOS --}}
                <details class="premium-accordion-wrapper">
                    <summary class="premium-card-header">
                        <h3 class="premium-card-title">
                            <i class="bi bi-calendar-event"></i> Editar Eventos
                        </h3>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn-premium-add" data-bs-toggle="modal"
                                data-bs-target="#criarEvento" onclick="event.stopPropagation();">
                                <i class="bi bi-plus-circle"></i> Novo Evento
                            </button>
                            <i class="bi bi-chevron-down fs-5"></i>
                        </div>
                    </summary>

                    <div class="premium-card-body-content p-4">
                        <div class="row g-4">
                            @foreach ($evento as $item)
                                <div class="col-12 col-md-6">
                                    <form method="POST" action="{{ route('admin.evento.update', $item->id_evento) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="premium-item-card d-flex flex-column justify-content-between">
                                            <div>
                                                <label class="form-label text-center d-block">Banner do Evento</label>
                                                <div class="media-preview-container mb-3">                                                  
                                                   
                                                    <iframe src="{{$item->url_evento    }}" width="600" height="50" style="border:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                </div>

                                                <div class="mb-3">
                                                    <input type="file" class="form-control" name="banner_evento"
                                                        accept="image/png,image/jpeg,image/webp">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Título Evento</label>
                                                    <input type="text" class="form-control" name="titulo_evento"
                                                        value="{{ $item->titulo_evento }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Edição Evento</label>
                                                    <input type="text" class="form-control" name="edicao_evento"
                                                        value="{{ $item->edicao_evento }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Descrição</label>
                                                    <textarea class="form-control" rows="4"
                                                        name="descricao_evento">{{ $item->descricao_evento }}</textarea>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6 mb-3">
                                                        <label class="form-label">Data Início</label>
                                                        <input type="date" class="form-control" name="data_inicial_evento"
                                                            value="{{ $item->data_inicial_evento }}">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label class="form-label">Hora Início</label>
                                                        <input type="time" class="form-control" name="hora_inicial_evento"
                                                            value="{{ $item->hora_inicial_evento }}">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6 mb-3">
                                                        <label class="form-label">Data Término</label>
                                                        <input type="date" class="form-control" name="data_termino_evento"
                                                            value="{{ $item->data_termino_evento }}">
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label class="form-label">Hora Término</label>
                                                        <input type="time" class="form-control" name="hora_termino_evento"
                                                            value="{{ $item->hora_termino_evento }}">
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Endereço</label>
                                                    <input type="text" class="form-control" name="endereco_evento"
                                                        value="{{ $item->endereco_evento }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">URL Evento</label>
                                                    <input type="text" class="form-control" name="url_evento"
                                                        value="{{ $item->url_evento }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select class="form-select" name="status_evento">
                                                        <option value="ATIVO" {{ $item->status_evento == 'ATIVO' ? 'selected' : '' }}>Ativo</option>
                                                        <option value="INATIVO" {{ $item->status_evento == 'INATIVO' ? 'selected' : '' }}>Inativo</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="border-top border-secondary pt-3 mt-2 text-end">
                                                <button type="submit" class="btn-premium-confirm w-100">
                                                    <i class="bi bi-check-circle me-1"></i> Salvar Evento
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </details>

                {{-- EDITAR TEMAS --}}
                <details class="premium-accordion-wrapper">
                    <summary class="premium-card-header">
                        <h3 class="premium-card-title">
                            <i class="bi bi-palette"></i> Editar Temas
                        </h3>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn-premium-add" data-bs-toggle="modal"
                                data-bs-target="#criarTemas" onclick="event.stopPropagation();">
                                <i class="bi bi-plus-circle"></i> Novo Tema
                            </button>
                            <i class="bi bi-chevron-down fs-5"></i>
                        </div>
                    </summary>

                    <div class="premium-card-body-content p-4">
                        <div class="row g-4">
                            @foreach ($temas as $item)
                                <div class="col-12 col-md-6">
                                    <form method="POST" action="{{ route('admin.tema.update', $item->id_tema) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="premium-item-card d-flex flex-column justify-content-between">
                                            <div>
                                                <label class="form-label d-block text-center">Foto do Tema</label>
                                                <div class="media-preview-container mb-3" style="height: 80px; width:80px">
                                                    <img src="{{ asset('conexao360/img/' . $item->foto_tema) }}"
                                                        alt="{{ $item->titulo_tema }}">
                                                </div>

                                                <div class="mb-3">
                                                    <input class="form-control" name="foto_tema" type="file"
                                                        accept="image/png,image/jpeg,image/webp">
                                                    <div class="form-text">Escolha a foto do Tema.</div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="titulo_tema" class="form-label">Título Tema</label>
                                                    <input type="text" class="form-control" name="titulo_tema"
                                                        value="{{ $item->titulo_tema }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="subtitulo_tema" class="form-label">Subtítulo Tema</label>
                                                    <textarea class="form-control" name="subtitulo_tema"
                                                        rows="4">{{ $item->subtitulo_tema }}</textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="breve_descricao_tema" class="form-label">Breve Descrição
                                                        Tema</label>
                                                    <input type="text" class="form-control" name="breve_descricao_tema"
                                                        value="{{ $item->breve_descricao_tema }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="status_tema" class="form-label">Status</label>
                                                    <select class="form-select" required name="status_tema">
                                                        <option value="ATIVO" {{ $item->status_tema == 'ATIVO' ? 'selected' : '' }}>Ativo</option>
                                                        <option value="INATIVO" {{ $item->status_tema == 'INATIVO' ? 'selected' : '' }}>Inativo</option>
                                                    </select>
                                                    <div class="form-text">Informe o Status do Produto.</div>
                                                </div>
                                            </div>

                                            <div
                                                class="border-top border-secondary pt-3 mt-2 d-flex gap-2 justify-content-end">
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-light border-0 text-muted"
                                                    data-bs-dismiss="modal">Fechar</button>
                                                <button type="submit" class="btn-premium-confirm px-4">Confirmar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </details>

                {{-- EDITAR VÍDEOS --}}
                <details class="premium-accordion-wrapper">
                    <summary class="premium-card-header">
                        <h3 class="premium-card-title">
                            <i class="bi bi-play-btn"></i> Editar Vídeos
                        </h3>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button"
                                class="btn-premium-add"
                                data-bs-toggle="modal"
                                data-bs-target="#criarVideo"
                                onclick="event.stopPropagation();">
                                <i class="bi bi-plus-circle"></i> Novo Vídeo
                            </button>

                            <i class="bi bi-chevron-down fs-5"></i>
                        </div>
                    </summary>

                    <div class="premium-card-body-content p-4">
                        <div class="row g-4 justify-content-center">
                            @foreach ($video as $item)
                                <div class="col-12">
                                    <form method="POST"
                                        action="{{ route('admin.video.update', $item->id_video) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="premium-item-card">
                                            <div class="row g-4 align-items-start">

                                                {{-- FORMULÁRIO --}}
                                                <div class="col-12 col-lg-8">

                                                    <div class="mb-3">
                                                        <label class="form-label">Título do Vídeo</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            name="titulo_video"
                                                            value="{{ $item->titulo_video }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Subtítulo</label>
                                                        <textarea
                                                            class="form-control"
                                                            name="subtitulo_video"
                                                            rows="3">{{ $item->subtitulo_video }}</textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Breve Descrição</label>
                                                        <textarea
                                                            class="form-control"
                                                            name="breve_descricao_video"
                                                            rows="4">{{ $item->breve_descricao_video }}</textarea>
                                                    </div>

                                                    <div class="row">

                                                        <div class="col-12 col-md-6 mb-3">
                                                            <label class="form-label">Legenda</label>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                name="legenda_video"
                                                                value="{{ $item->legenda_video }}">
                                                        </div>

                                                        <div class="col-12 col-md-6 mb-3">
                                                            <label class="form-label">Status</label>

                                                            <select
                                                                class="form-select"
                                                                name="status_video">

                                                                <option value="ATIVO"
                                                                    {{ $item->status_video == 'ATIVO' ? 'selected' : '' }}>
                                                                    Ativo
                                                                </option>

                                                                <option value="INATIVO"
                                                                    {{ $item->status_video == 'INATIVO' ? 'selected' : '' }}>
                                                                    Inativo
                                                                </option>

                                                            </select>
                                                        </div>

                                                    </div>

                                                </div>

                                                {{-- PREVIEW --}}
                                                <div class="col-12 col-lg-4">

                                                    <label class="form-label text-center d-block">
                                                        Capa Atual
                                                    </label>

                                                    <div class="media-preview-container mb-3">
                                                        <img
                                                            src="{{ asset('conexao360/img/' . $item->capa_video) }}"
                                                            alt="{{ $item->titulo_video }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Alterar Capa
                                                        </label>

                                                        <input
                                                            type="file"
                                                            class="form-control"
                                                            name="capa_video"
                                                            accept="image/png,image/jpeg,image/webp">
                                                    </div>

                                                    <label class="form-label text-center d-block">
                                                        Vídeo Atual
                                                    </label>

                                                    <div class="media-preview-container mb-3">
                                                        <video
                                                            class="w-100 rounded"
                                                            controls>

                                                            <source
                                                                src="{{ asset('conexao360/img/' . $item->url_video) }}"
                                                                type="video/mp4">

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
                                                            accept="video/mp4,video/webm,video/quicktime">
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="border-top border-secondary pt-3 mt-3 text-end">
                                                <button
                                                    type="submit"
                                                    class="btn-premium-confirm">

                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Salvar Vídeo

                                                </button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </details>

                {{-- EDITAR DRA --}}
                <details class="premium-accordion-wrapper">
                    <summary class="premium-card-header">
                        <h3 class="premium-card-title">
                            <i class="bi bi-person-badge"></i> Editar Dra
                        </h3>

                        <div class="d-flex align-items-center gap-2 ">
                            <button
                                type="button"
                                class="btn-premium-add"
                                data-bs-toggle="modal"
                                data-bs-target="#criarDra"
                                onclick="event.stopPropagation();">

                                <i class="bi bi-plus-circle"></i>
                                Nova Dra

                            </button>

                            <i class="bi bi-chevron-down fs-5"></i>
                        </div>
                    </summary>

                    <div class="premium-card-body-content p-4">

                        <div class="row g-4 justify-content-center">

                            @foreach ($dra as $item)

                                <div class="col-12">

                                    <form
                                        method="POST"
                                        action="{{ route('admin.dra.update', $item->id_dra) }}"
                                        enctype="multipart/form-data">

                                        @csrf
                                        @method('PUT')

                                        <div class="premium-item-card">

                                            <div class="row g-4 align-items-start">

                                                {{-- FORMULÁRIO --}}
                                                <div class="col-12 col-lg-8">

                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Título
                                                        </label>

                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            name="titulo_dra"
                                                            value="{{ $item->titulo_dra }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Subtítulo
                                                        </label>

                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            name="sub_titulo_dra"
                                                            value="{{ $item->sub_titulo_dra }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Descrição
                                                        </label>

                                                        <textarea
                                                            class="form-control"
                                                            name="descricao_dra"
                                                            rows="6">{{ $item->descricao_dra }}</textarea>
                                                    </div>

                                                    <div class="row">

                                                        <div class="col-12 col-md-6 mb-3">

                                                            <label class="form-label">
                                                                Status
                                                            </label>

                                                            <select
                                                                class="form-select"
                                                                name="status_dra">

                                                                <option
                                                                    value="ATIVO"
                                                                    {{ $item->status_dra == 'ATIVO' ? 'selected' : '' }}>
                                                                    Ativo
                                                                </option>

                                                                <option
                                                                    value="INATIVO"
                                                                    {{ $item->status_dra == 'INATIVO' ? 'selected' : '' }}>
                                                                    Inativo
                                                                </option>

                                                            </select>

                                                        </div>

                                                    </div>

                                                </div>

                                                {{-- FOTO --}}
                                                <div class="col-12 col-lg-4">

                                                    <label class="form-label text-center d-block">
                                                        Foto Atual
                                                    </label>

                                                    <div class="media-preview-container mb-3">
                                                        <img
                                                            src="{{ asset('conexao360/img/' . $item->foto_dra) }}"
                                                            alt="{{ $item->titulo_dra }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Alterar Foto
                                                        </label>

                                                        <input
                                                            type="file"
                                                            class="form-control"
                                                            name="foto_dra"
                                                            accept="image/png,image/jpeg,image/webp">
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="border-top border-secondary pt-3 mt-3 text-end">

                                                <button
                                                    type="submit"
                                                    class="btn-premium-confirm">

                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Salvar Alterações

                                                </button>

                                            </div>

                                        </div>

                                    </form>

                                </div>

                            @endforeach

                        </div>

                    </div>
                </details>



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
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
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