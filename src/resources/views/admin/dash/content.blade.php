


<main class="app-main">

  <!--begin::App Content Header-->
  <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">

    </div>
    <!--end::Container-->
  </div>



  <div class="app-content ps-3 pt-2">
    <h5 class="mb-2">Editar HomePage Conexão</h5>

      
    <div class="row ms-3  g-4 mb-4 row-gap-3 col-md-3 col-md-9 ">

      {{-- EDITAR BANNER PRINCIPAL --}}
      <div class="card card-outline card-light   collapsed-card">

        <div class="card-header">

          <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">

              <h3 class="card-title mb-0">
                  Editar Banner
              </h3>

              <div class="card-tools d-flex gap-2">

                  <button
                      type="button"
                      class="btn btn-light btn-sm"
                      data-bs-toggle="modal"
                      data-bs-target="#criarBanner">

                      <i class="bi bi-plus-circle"></i>
                      Novo Banner

                  </button>

                  <button
                      type="button"
                      class="btn btn-tool"
                      data-lte-toggle="card-collapse">

                      <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                      <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>

                  </button>

              </div>

          </div>

        </div>

        <!-- /.card-header -->
        <div class="card-body     ">
          <div class="row justify-content-around p-3">
          @foreach($hero as $item)
          
            <form action="{{ route('admin.hero.update', $item->id_hero_section) }}"
                  method="POST"
                  enctype="multipart/form-data">
            
                @csrf
                @method('PUT')
            
                <div class="card shadow-sm border-0 p-3">

                    <div class="row g-4 align-items-start">

                        <!-- FORMULÁRIO -->
                        <div class="col-12 col-lg-8">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Chamada Superior
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="tagline_hero"
                                    value="{{ $item->tagline_hero }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Título Principal
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="titulo_hero"
                                    value="{{ $item->titulo_hero }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Subtítulo
                                </label>

                                <textarea
                                    class="form-control"
                                    name="subtitulo_hero"
                                    rows="4">{{ $item->subtitulo_hero }}</textarea>
                            </div>

                            <div class="row">

                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Texto do Botão
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="texto_botao_hero"
                                        value="{{ $item->texto_botao_hero }}">
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Link do Botão
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="link_botao_hero"
                                        value="{{ $item->link_botao_hero }}">
                                </div>

                            </div>

                        </div>

                        <!-- PREVIEW -->
                        <div class="col-12 col-lg-4">

                            <div class="card border">

                                <div class="card-header text-center">
                                    <strong>Banner Atual</strong>
                                </div>

                                <div class="card-body">

                                    <img
                                        src="{{ asset('conexao360/img/' . $item->foto_banner) }}"
                                        class="img-fluid rounded shadow-sm w-100">

                                    <div class="mt-3">

                                        <label class="form-label fw-semibold">
                                            Alterar Banner
                                        </label>

 

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <hr>



                </div>
            
                <button type="submit" class="btn btn-success">
                    Salvar Banner
                </button>
            
            </form>
          @endforeach  
          </div>
        </div>
        <!-- /.card-body -->
      </div>

      {{-- EDITAR LOCAL --}}
      <div class="card card-outline card-success collapsed-card">
        <div class="card-header">

          <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">

              <h3 class="card-title mb-0">
                  Editar Eventos
              </h3>

              <div class="card-tools d-flex gap-2">

                  <button
                      type="button"
                      class="btn btn-success btn-sm"
                      data-bs-toggle="modal"
                      data-bs-target="#criarEvento">

                      <i class="bi bi-plus-circle"></i>
                      Novo Evento

                  </button>

                  <button
                      type="button"
                      class="btn btn-tool"
                      data-lte-toggle="card-collapse">

                      <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                      <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>

                  </button>

              </div>

          </div>

        </div>

        <div class="card-body">

            <div class="row justify-content-around p-3">

                @foreach ($evento as $item)

                    <div class="col-12 col-md-6">

                        <form method="POST"
                            action="{{ route('admin.evento.update', $item->id_evento) }}"
                            enctype="multipart/form-data">

                            @csrf
                            @method('PUT')

                            <div class="card p-3 my-3">

                                {{-- Banner --}}
                                <div class="mb-3">
                                    <img src="{{ asset('conexao360/img/' . $item->banner_evento) }}"
                                        class="img-fluid mb-3"
                                        alt="{{ $item->titulo_evento }}">

                                    <label class="form-label">Banner Evento</label>
                                    <input type="file"
                                        class="form-control"
                                        name="banner_evento"
                                        accept="image/png,image/jpeg,image/webp">
                                </div>

                                {{-- Título --}}
                                <div class="mb-3">
                                    <label class="form-label">Título Evento</label>
                                    <input type="text"
                                        class="form-control"
                                        name="titulo_evento"
                                        value="{{ $item->titulo_evento }}">
                                </div>

                                {{-- Edição --}}
                                <div class="mb-3">
                                    <label class="form-label">Edição Evento</label>
                                    <input type="text"
                                        class="form-control"
                                        name="edicao_evento"
                                        value="{{ $item->edicao_evento }}">
                                </div>

                                {{-- Descrição --}}
                                <div class="mb-3">
                                    <label class="form-label">Descrição</label>
                                    <textarea class="form-control"
                                        rows="4"
                                        name="descricao_evento">{{ $item->descricao_evento }}</textarea>
                                </div>

                                {{-- Data/Hora Início --}}
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data Início</label>
                                        <input type="date"
                                            class="form-control"
                                            name="data_inicial_evento"
                                            value="{{ $item->data_inicial_evento }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Hora Início</label>
                                        <input type="time"
                                            class="form-control"
                                            name="hora_inicial_evento"
                                            value="{{ $item->hora_inicial_evento }}">
                                    </div>

                                </div>

                                {{-- Data/Hora Término --}}
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Data Término</label>
                                        <input type="date"
                                            class="form-control"
                                            name="data_termino_evento"
                                            value="{{ $item->data_termino_evento }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Hora Término</label>
                                        <input type="time"
                                            class="form-control"
                                            name="hora_termino_evento"
                                            value="{{ $item->hora_termino_evento }}">
                                    </div>

                                </div>

                                {{-- Endereço --}}
                                <div class="mb-3">
                                    <label class="form-label">Endereço</label>
                                    <input type="text"
                                        class="form-control"
                                        name="endereco_evento"
                                        value="{{ $item->endereco_evento }}">
                                </div>

                                {{-- URL --}}
                                <div class="mb-3">
                                    <label class="form-label">URL Evento</label>
                                    <input type="url"
                                        class="form-control"
                                        name="url_evento"
                                        value="{{ $item->url_evento }}">
                                </div>

                                {{-- Status --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>

                                    <select class="form-select"
                                        name="status_evento">

                                        <option value="ATIVO"
                                            {{ $item->status_evento == 'ATIVO' ? 'selected' : '' }}>
                                            Ativo
                                        </option>

                                        <option value="INATIVO"
                                            {{ $item->status_evento == 'INATIVO' ? 'selected' : '' }}>
                                            Inativo
                                        </option>

                                    </select>

                                </div>

                                <div class="mt-3">

                                    <button type="submit"
                                        class="btn btn-primary">
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


      {{-- EDITAR TEMAS --}}
      <div class="card card-outline card-warning collapsed-card">
      

        <div class="card-header">

          <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">

              <h3 class="card-title mb-0">
                  Editar Temas
              </h3>

              <div class="card-tools d-flex gap-2">

                  <button
                      type="button"
                      class="btn btn-warning btn-sm"
                      data-bs-toggle="modal"
                      data-bs-target="#criarTemas">

                      <i class="bi bi-plus-circle"></i>
                      Novo Tema

                  </button>

                  <button
                      type="button"
                      class="btn btn-tool"
                      data-lte-toggle="card-collapse">

                      <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                      <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>

                  </button>

              </div>

          </div>

        </div>

        

        <!-- /.card-header -->
        <div class="card-body     ">
          <div class="row justify-content-around p-3">
            @foreach ($temas as $item)
              <div class="col-12 col-md-6">
                <form method="POST" action="{{ route('admin.tema.update', $item->id_tema) }}" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="card  p-2 my-3 ">
                    <div class="mb-3 col-md-12">
                      <div>
                        <div class="mb-3">
                          <img src="{{ asset('conexao360/img/' . $item->foto_tema) }}"     alt="{{ $item->titulo_tema }}">


                          <input class="form-control  form-control-sm mt-3" id="foto_tema"
                              name="foto_tema" type="file"
                              accept="image/png,image/jpeg,image/webp">
                          <div id="emailHelp" class="form-text">Escolha a foto do Tema.
                          </div>
                        </div>
                      </div>
                      <label for="titulo_tema" class="form-label">Titulo Tema</label>
                      <input type="text" class="form-control" id="titulo_tema"  name="titulo_tema" value="{{ $item->titulo_tema }}">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="subtitulo_tema" class="form-label">Subtitulo Tema</label>
                        <textarea type="textarea" class="form-control" id="subtitulo_tema" name="subtitulo_tema" rows="5">{{ $item->subtitulo_tema }}</textarea>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="breve_descricao_tema" class="form-label">Breve Descrição
                            Tema</label>
                        <input type="text" class="form-control" id="breve_descricao_tema"
                            name="breve_descricao_tema"
                            value="{{ $item->breve_descricao_tema }}">
                    </div>

                    <div class="col-md-6 mb-3   ">
                        <label for="status_tema" class="form-label">Status</label>
                        <select class="form-select form-select" aria-label="Status" required
                            name="status_tema" id="status_tema">
                            <option value="ATIVO"
                                {{ $item->status_tema == 'ATIVO' ? 'selected' : '' }}>
                                Ativo</option>
                            <option
                                value="INATIVO"{{ $item->status_tema == 'INATIVO' ? 'selected' : '' }}>
                                Inativo</option>
                        </select>
                        <div id="emailHelp" class="form-text">Informe o Status do Produto.</div>
                    </div>

                    <div class="">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary"
                            id="liveToast">Confirmar</button>
                        @if (session('success'))
                            <div class="toast-container position-fixed bottom-0 end-0 p-3">

                                <div id="liveToast" class="toast" role="alert"
                                    aria-live="assertive" aria-atomic="true">

                                    <div class="toast-header">

                                        <strong class="me-auto">
                                            Tema Alterado com Sucesso
                                        </strong>

                                        <button type="button" class="btn-close"
                                            data-bs-dismiss="toast" aria-label="Close">
                                        </button>

                                    </div>

                                    <div class="toast-body">
                                        {{ session('success') }}
                                    </div>

                                </div>

                            </div>
                        @endif

                        <div class="toast-container position-fixed bottom-0 end-0 p-3">
                            <div id="liveToast" class="toast" role="alert"
                                aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                    <img src="..." class="rounded me-2" alt="...">
                                    <strong class="me-auto">Tema Alterado com Sucesso</strong>
                                    <small>11 mins ago</small>
                                    <button type="button" class="btn-close"
                                        data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    Hello, world! This is a toast message.
                                </div>
                            </div>
                        </div>
                    </div>

                  </div>
                </form>
              </div>
            @endforeach
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      

      {{-- EDITAR VIDEO --}}
      <div class="card card-outline card-danger collapsed-card">

        <div class="card-header">

          <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">

              <h3 class="card-title mb-0">
                  Editar Vídeos
              </h3>

              <div class="card-tools d-flex gap-2">

                  <button
                      type="button"
                      class="btn btn-danger btn-sm"
                      data-bs-toggle="modal"
                      data-bs-target="#criarVideo">

                      <i class="bi bi-plus-circle"></i>
                      Novo Vídeo

                  </button>

                  <button
                      type="button"
                      class="btn btn-tool"
                      data-lte-toggle="card-collapse">

                      <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                      <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>

                  </button>

              </div>

          </div>

        </div>
        <!-- /.card-header -->
        <div class="card-body     ">
          <div class="row justify-content-around p-3">
            @foreach ($video as $item)
              <div class="col-12 col-md-12">
                <form method="POST" 
                action="{{ route('admin.video.update', $item->id_video) }}" 
                 enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="card shadow-sm border-0 p-3">

                      <div class="row g-4 align-items-start">

                          <!-- FORMULÁRIO -->
                          <div class="col-12 col-lg-8">

                              <div class="mb-3">
                                  <label class="form-label fw-semibold">
                                      Título do Vídeo
                                  </label>

                                  <input
                                      type="text"
                                      class="form-control"
                                      name="titulo_video"
                                      value="{{ $item->titulo_video }}">
                              </div>

                              <div class="mb-3">
                                  <label class="form-label fw-semibold">
                                      Subtítulo
                                  </label>

                                  <textarea
                                      class="form-control"
                                      name="subtitulo_video"
                                      rows="3">{{ $item->subtitulo_video }}</textarea>
                              </div>

                              <div class="mb-3">
                                  <label class="form-label fw-semibold">
                                      Breve Descrição
                                  </label>

                                  <textarea
                                      class="form-control"
                                      name="breve_descricao_video"
                                      rows="4">{{ $item->breve_descricao_video }}</textarea>
                              </div>

                              <div class="row">

                                  <div class="col-12 col-md-6 mb-3">
                                      <label class="form-label fw-semibold">
                                          Legenda
                                      </label>

                                      <input
                                          type="text"
                                          class="form-control"
                                          name="legenda_video"
                                          value="{{ $item->legenda_video }}">
                                  </div>

                                  <div class="col-12 col-md-6 mb-3">
                                      <label class="form-label fw-semibold">
                                          Status
                                      </label>

                                      <select
                                          class="form-select"
                                          name="status_video">

                                          <option
                                              value="ATIVO"
                                              {{ $item->status_video == 'ATIVO' ? 'selected' : '' }}>
                                              Ativo
                                          </option>

                                          <option
                                              value="INATIVO"
                                              {{ $item->status_video == 'INATIVO' ? 'selected' : '' }}>
                                              Inativo
                                          </option>

                                      </select>

                                  </div>

                              </div>

                          </div>

                          <!-- PREVIEW -->
                          <div class="col-12 col-lg-4">

                              <div class="card border">

                                  <div class="card-header text-center">
                                      <strong>Pré-visualização</strong>
                                  </div>

                                  <div class="card-body">

                                      <!-- CAPA -->
                                      <label class="form-label fw-semibold">
                                          Capa Atual
                                      </label>

                                      <img
                                          src="{{ asset('conexao360/img/' . $item->capa_video) }}"
                                          alt="{{ $item->titulo_video }}"
                                          class="img-fluid rounded shadow-sm w-100 mb-3">

                                      <input
                                          type="file"
                                          name="capa_video"
                                          class="form-control form-control-sm mb-4"
                                          accept="image/png,image/jpeg,image/webp">

                                      <!-- VÍDEO -->
                                      <label class="form-label fw-semibold">
                                          Vídeo Atual
                                      </label>

                                      <video
                                          class="w-100 rounded shadow-sm mb-3"
                                          controls>

                                          <source
                                              src="{{ asset('conexao360/img/' . $item->url_video) }}"
                                              type="video/mp4">

                                      </video>

                                      <input
                                          type="file"
                                          name="url_video"
                                          class="form-control form-control-sm"
                                          accept="video/mp4,video/webm,video/quicktime">

                                  </div>

                              </div>

                          </div>

                      </div>

                      <hr>

                      <div class="d-flex justify-content-end">

                          <button
                              type="submit"
                              class="btn btn-danger px-4">

                              <i class="bi bi-play-btn"></i>
                              Salvar Vídeo

                          </button>

                      </div>

                  </div>
                </form>
              </div>
            @endforeach
          </div>
        </div>
        <!-- /.card-body -->
      </div>


        {{-- EDITAR DRA --}}
    <div class="card card-outline card-primary collapsed-card">

    <div class="card-header">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">

            <h3 class="card-title mb-0">
                Editar Dra
            </h3>

            <div class="card-tools d-flex gap-2">

                <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#criarDra">

                    <i class="bi bi-plus-circle"></i>
                    Nova Dra

                </button>

                <button
                    type="button"
                    class="btn btn-tool"
                    data-lte-toggle="card-collapse">

                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>

                </button>

            </div>

        </div>

    </div>

    <div class="card-body">

        <div class="row justify-content-around p-3">

            @foreach ($dra as $item)

                <div class="col-12">

                    <form
                        method="POST"
                        action="{{ route('admin.dra.update', $item->id_dra) }}"
                        enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="card shadow-sm border-0 p-3">

                            <div class="row g-4 align-items-start">

                                <!-- FORMULÁRIO -->
                                <div class="col-12 col-lg-8">

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">
                                            Título
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="titulo_dra"
                                            value="{{ $item->titulo_dra }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">
                                            Subtítulo
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            name="sub_titulo_dra"
                                            value="{{ $item->sub_titulo_dra }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">
                                            Descrição
                                        </label>

                                        <textarea
                                            class="form-control"
                                            name="descricao_dra"
                                            rows="6">{{ $item->descricao_dra }}</textarea>
                                    </div>

                                    <div class="row">

                                        <div class="col-12 col-md-6 mb-3">

                                            <label class="form-label fw-semibold">
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

                                <!-- FOTO -->
                                <div class="col-12 col-lg-4">

                                    <div class="card border">

                                        <div class="card-header text-center">
                                            <strong>Foto Atual</strong>
                                        </div>

                                        <div class="card-body">

                                            <img
                                                src="{{ asset('conexao360/img/' . $item->foto_dra) }}"
                                                alt="{{ $item->titulo_dra }}"
                                                class="img-fluid rounded shadow-sm w-100 mb-3">

                                            <input
                                                type="file"
                                                name="foto_dra"
                                                class="form-control form-control-sm"
                                                accept="image/png,image/jpeg,image/webp">

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <hr>

                            <div class="d-flex justify-content-end">

                                <button
                                    type="submit"
                                    class="btn btn-primary px-4">

                                    <i class="bi bi-person-badge"></i>
                                    Salvar Alterações

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            @endforeach

        </div>

    </div>

    </div>


    </div>  


  </div>
  
  <!--end::App Content-->
</main>
<!--end::App Main-->

{{-- @include('admin.modal.criar') --}}
@include('admin.modal.criar-temas')
@include('admin.modal.criar-videos')
@include('admin.modal.criar-banner')
@include('admin.modal.criar-evento')
@include('admin.modal.criar-dra')



{{-- SCRIPT PARA FUNCIONAMENTO DAS SETAS --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const collapseButtons = document.querySelectorAll('[data-card-widget="collapse"]');
  document.addEventListener('DOMContentLoaded', function() {

        collapseButtons.forEach(button => {
            button.addEventListener('click', function () {
                const card = this.closest('.card');
                const cardBody = card.querySelector('.card-body');
                const icon = this.querySelector('i');

                if (cardBody.style.display === "none") {
                    cardBody.style.display = "block";
                    card.classList.remove('collapsed-card');
                    icon.classList.replace('fa-plus', 'fa-minus');
                } else {
                    cardBody.style.display = "none";
                    card.classList.add('collapsed-card');
                    icon.classList.replace('fa-minus', 'fa-plus');
                }
            });
        });
    });
    if (toastEl) {

      const toast = new bootstrap.Toast(toastEl);

      toast.show();
    }
  });
</script>
</script>
