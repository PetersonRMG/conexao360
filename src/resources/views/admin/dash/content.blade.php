<!--begin::App Main-->
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

      {{-- EDITAR TEMAS --}}
      <div class="card card-outline card-primary collapsed-card">

        <div class="card-header">

          <h3 class="card-title">Editar Temas</h3>
          
          <div class="card-tools col-md-10 d-flex   align-items-center justify-content-end">    

            <div class="col-md-4">
              <button type="button" class="card-tools btn btn-warning " data-bs-toggle="modal"data-bs-target="#criar">
              <i class="bi bi-plus-circle"></i> Novo Tema
              </button>
            </div>

            <div>
              <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
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
                <form method="POST" action="{{ route('admin.update', $item->id_tema) }}" enctype="multipart/form-data">
                  @csrf
                  @method('POST')
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

                            <div id="liveToast" class="toast" role="alert"                                aria-live="assertive" aria-atomic="true">

                              <div class="toast-header">

                                <strong class="me-auto">
                                  Tema Alterado com Sucesso
                                </strong>

                                <button type="button" class="btn-close"                                      data-bs-dismiss="toast" aria-label="Close">
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

          <h3 class="card-title">Editar Videos</h3>

          <div class="card-tools col-md-10 d-flex   align-items-center justify-content-end">

            <div class="col-md-4">
              <button type="button" class="card-tools btn btn-warning " data-bs-toggle="modal"data-bs-target="#criar">
              <i class="bi bi-plus-circle"></i> Novo Video
              </button>
            </div>

            <div>
              <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
              </button>
            </div>

            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body     ">
          <div class="row justify-content-around p-3">
            @foreach ($video as $item)
              <div class="col-12 col-md-6">
                <form method="POST" 
                {{-- action="{{ route('admin.updateVideo', $item->id_video) }}"  --}}
                 enctype="multipart/form-data">
                  @csrf
                  @method('POST')
                  <div class="card  p-2 my-3 ">
                    <div class="mb-3 col-md-12">
                      <div>
                        <div class="mb-3">
                          <img src="{{ asset('conexao360/img/' . $item->capa_video) }}" alt="{{ $item->titulo_video }}" style="width:100px">

                          <video width="320" height="180" controls>

                            <source src="{{ asset('conexao360/img/' . $item->url_video) }}" type="video/mp4">

                          </video>

                          <input    class="form-control form-control-sm mt-3"    id="url_video"    name="url_video"    type="file"    accept="video/mp4,video/webm,video/quicktime">

                          <div id="emailHelp" class="form-text">Escolha o Video.</div>

                          <input class="form-control  form-control-sm mt-3" id="capa_video" name="capa_video" type="file" accept="image/png,image/jpeg,image/webp">
                          <div id="emailHelp" class="form-text">Escolha a foto de Capa do Video.
                          </div>
                        </div>
                      </div>
                      <label for="titulo_video" class="form-label">Titulo Video</label>
                      <input type="text" class="form-control" id="titulo_video"  name="titulo_video" value="{{ $item->titulo_video }}">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="subtitulo_video" class="form-label">Subtitulo Video</label>
                        <textarea type="textarea" class="form-control" id="subtitulo_video" name="subtitulo_video" rows="5">{{ $item->subtitulo_video }}</textarea>
                    </div>

                    <div class="mb-3 col-md-12">
                      <label for="breve_descricao_video" class="form-label">
                        Breve Descrição Video
                      </label>
                      <input type="text" class="form-control" id="breve_descricao_video" name="breve_descricao_video"  value="{{ $item->breve_descricao_video }}">
                    </div>

                    <div class="mb-3 col-md-12">
                      <label for="legenda_video" class="form-label">
                        Legenda Video
                      </label>
                      <input type="text" class="form-control" id="legenda_video" name="legenda_video"  value="{{ $item->legenda_video }}">
                    </div>

                    <div class="col-md-6 mb-3   ">
                      <label for="status_video" class="form-label">Status</label>
                      <select class="form-select form-select" aria-label="Status" required  name="status_video" id="status_video">

                        <option value="ATIVO"  {{ $item->status_tema == 'ATIVO' ? 'selected' : '' }}>
                          Ativo
                        </option>

                        <option  value="INATIVO"{{ $item->status_tema == 'INATIVO' ? 'selected' : '' }}>
                          Inativo
                        </option>

                      </select>
                      <div id="emailHelp" class="form-text">Informe o Status do Produto.</div>
                    </div>

                    <div class="">
                      <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Fechar</button>
                      <button type="submit" class="btn btn-primary"  id="liveToast">Confirmar</button>
                      @if (session('success'))
                        <div class="toast-container position-fixed bottom-0 end-0 p-3">

                          <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">

                            <div class="toast-header">

                              <strong class="me-auto">
                                Tema Alterado com Sucesso
                              </strong>

                              <button type="button" class="btn-close"  data-bs-dismiss="toast" aria-label="Close"></button>

                            </div>

                            <div class="toast-body">
                              {{ session('success') }}
                            </div>

                          </div>

                        </div>
                      @endif

                      <div class="toast-container position-fixed bottom-0 end-0 p-3">
                        <div id="liveToast" class="toast" role="alert"                                aria-live="assertive" aria-atomic="true">
                          <div class="toast-header">
                            <img src="..." class="rounded me-2" alt="...">
                            <strong class="me-auto">Tema Alterado com Sucesso</strong>
                            <small>11 mins ago</small>
                            <button type="button" class="btn-close"                                        data-bs-dismiss="toast" aria-label="Close"></button>
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

    </div>  


  </div>
  
  <!--end::App Content-->
</main>
<!--end::App Main-->

{{-- @include('admin.modal.criar') --}}
@include('admin.modal.criar-temas')
@include('admin.modal.criar-videos')

<script>
  document.addEventListener('DOMContentLoaded', function() {

    const toastEl = document.getElementById('liveToast');

    if (toastEl) {

      const toast = new bootstrap.Toast(toastEl);

      toast.show();
    }
  });
</script>
