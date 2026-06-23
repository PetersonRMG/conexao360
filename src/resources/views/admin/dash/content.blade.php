<style>
    /* Estilização Geral do Painel Escuro */
    .app-main {
        background-color: #0f0f10;
        color: #f1f1f3;
    }
    
    /* Sanfonas / Cards Principais de Seções */
    .premium-accordion-card {
        background: #161719 !important;
        border: 1px solid #242629 !important;
        border-radius: 12px !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
        margin-bottom: 1.25rem !important;
        overflow: hidden;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    .premium-accordion-card:hover {
        border-color: #3b3e44 !important;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.35) !important;
    }
    
    /* Cabeçalhos das Seções */
    .premium-card-header {
        background: #1c1d21 !important;
        border-bottom: 1px solid #242629 !important;
        padding: 1.2rem 1.5rem !important;
    }
    .premium-card-title {
        color: #ffffff !important;
        font-size: 1.1rem !important;
        font-weight: 600 !important;
        letter-spacing: -0.3px;
        margin: 0 !important;
    }
    
    /* Botão de Adicionar (Estilo Dourado/Bronze Minimalista) */
    .btn-premium-add {
        background: rgba(212, 175, 55, 0.1) !important;
        color: #d4af37 !important;
        border: 1px solid rgba(212, 175, 55, 0.25) !important;
        font-weight: 500;
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .btn-premium-add:hover {
        background: #d4af37 !important;
        color: #111112 !important;
        border-color: #d4af37 !important;
    }

    /* Subcards dos Itens Cadastrados (Loops do @foreach) */
    .premium-item-card {
        background: #1c1d21 !important;
        border: 1px solid #2a2c31 !important;
        border-radius: 10px !important;
        padding: 1.25rem !important;
        height: 100%;
    }
    
    /* Customização de Inputs e Caixas de Texto */
    .premium-item-card .form-label {
        color: #a0a5b1 !important;
        font-size: 0.8rem !important;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.4rem;
    }
    .premium-item-card .form-control, 
    .premium-item-card .form-select {
        background-color: #111112 !important;
        border: 1px solid #2a2c31 !important;
        color: #ffffff !important;
        border-radius: 8px !important;
        font-size: 0.9rem;
        padding: 0.55rem 0.75rem;
    }
    .premium-item-card .form-control:focus, 
    .premium-item-card .form-select:focus {
        border-color: #d4af37 !important;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15) !important;
    }
    .premium-item-card .form-text {
        color: #6c727f !important;
        font-size: 0.75rem !important;
    }
    
    /* Mídias (Imagens, Iframes e Vídeos) */
    .media-preview-container {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        background: #111112;
        border: 1px solid #2a2c31;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .media-preview-container img, 
    .media-preview-container video, 
    .media-preview-container iframe {
        max-width: 100%;
        border-radius: 6px;
    }
    
    /* Botões de Ação do Item */
    .btn-premium-confirm {
        background-color: #d4af37 !important;
        color: #111112 !important;
        border: none !important;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.5rem 1.25rem;
        border-radius: 8px;
    }
    .btn-premium-confirm:hover {
        background-color: #bfa032 !important;
    }
</style>

<main class="app-main py-4">
  <div class="app-content-header mb-3">
    <div class="container-fluid px-4">
      <h4 class="text-white font-weight-bold mb-1" style="letter-spacing: -0.5px;">Editar HomePage Conexão</h4>
      <p class="text-muted small mb-0">Gerencie dinamicamente os eventos, temas estruturais e mídias de vídeo exibidos na página principal do site.</p>
    </div>
  </div>
  <div class="app-content">
    <div class="container-fluid px-4">
      <div class="row g-4">
        <div class="col-12 col-xl-10">

          {{-- 1. SEÇÃO: EDITAR EDIÇÃO DO EVENTO --}}
          <div class="card premium-accordion-card collapsed-card">
            <div class="card-header premium-card-header d-flex align-items-center justify-content-between">
              <h3 class="premium-card-title">
                <i class="bi bi-calendar-range me-2 text-muted"></i>Editar Edição do Evento
              </h3>
              <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-premium-add" data-bs-toggle="modal" data-bs-target="#criar">
                  <i class="bi bi-plus-circle me-1"></i> Novo Evento
                </button>
                <button type="button" class="btn btn-tool text-muted p-1" data-lte-toggle="card-collapse">
                  <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                  <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                </button>
              </div>
            </div>
            
            <div class="card-body bg-black-subtle p-4">
              <div class="row g-4">
                @foreach ($evento as $item)
                  <div class="col-12 col-lg-6">
                    <form method="POST" action="#" enctype="multipart/form-data" class="premium-item-card d-flex flex-column justify-content-between">
                      @csrf
                      @method('POST')
                      <div>
                        <div class="row g-2 mb-3">
                          <div class="col-5">
                            <div class="media-preview-container p-2" style="height: 110px;">
                              <img src="{{ asset('conexao360/img/' . $item->banner_evento) }}" alt="{{ $item->titulo_evento }}" style="object-fit: contain; max-height: 100%;">
                            </div>
                          </div>
                          <div class="col-7">
                            <div class="media-preview-container" style="height: 110px;">
                              <iframe src="{{ $item->url_evento }}" style="border:0; width:100%; height:100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                          </div>
                        </div>

                        <div class="mb-3">
                          <label for="banner_evento_{{ $item->id_evento ?? $loop->index }}" class="form-label">Substituir Banner</label>
                          <input class="form-control form-control-sm" id="banner_evento_{{ $item->id_evento ?? $loop->index }}" name="banner_evento" type="file" accept="image/png,image/jpeg,image/webp">
                        </div>

                        <div class="row g-2 mb-3">
                          <div class="col-8">
                            <label for="titulo_evento_{{ $item->id_evento ?? $loop->index }}" class="form-label">Título do Evento</label>
                            <input type="text" class="form-control" id="titulo_evento_{{ $item->id_evento ?? $loop->index }}" name="titulo_evento" value="{{ $item->titulo_evento }}">
                          </div>
                          <div class="col-4">
                            <label for="edicao_evento_{{ $item->id_evento ?? $loop->index }}" class="form-label">Edição Nº</label>
                            <input type="number" class="form-control" id="edicao_evento_{{ $item->id_evento ?? $loop->index }}" name="edicao_evento" value="{{ $item->edicao_evento }}">
                          </div>
                        </div>

                        <div class="mb-3">
                          <label for="descricao_evento_{{ $item->id_evento ?? $loop->index }}" class="form-label">Descrição Resumida</label>
                          <input type="text" class="form-control" id="descricao_evento_{{ $item->id_evento ?? $loop->index }}" name="descricao_evento" value="{{ $item->descricao_evento }}">
                        </div>

                        <div class="mb-4">
                          <label for="status_evento_{{ $item->id_evento ?? $loop->index }}" class="form-label">Visibilidade no Site</label>
                          <select class="form-select" name="status_evento" id="status_evento_{{ $item->id_evento ?? $loop->index }}" required>
                            <option value="ATIVO" {{ $item->status_evento == 'ATIVO' ? 'selected' : '' }}>Publicado (Ativo)</option>
                            <option value="INATIVO" {{ $item->status_evento == 'INATIVO' ? 'selected' : '' }}>Rascunho (Inativo)</option>
                          </select>
                        </div>
                      </div>

                      <div class="d-flex justify-content-end gap-2 border-top border-secondary pt-3 mt-auto">
                        <button type="submit" class="btn btn-premium-confirm">Salvar Alterações</button>
                      </div>
                    </form>
                  </div>
                @endforeach
              </div>
            </div>
          </div>

          {{-- 2. SEÇÃO: EDITAR TEMAS --}}
          <div class="card premium-accordion-card collapsed-card">
            <div class="card-header premium-card-header d-flex align-items-center justify-content-between">
              <h3 class="premium-card-title">
                <i class="bi bi-tags me-2 text-muted"></i>Editar Temas Estruturais
              </h3>
              <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-premium-add" data-bs-toggle="modal" data-bs-target="#criar-temas">
                  <i class="bi bi-plus-circle me-1"></i> Novo Tema
                </button>
                <button type="button" class="btn btn-tool text-muted p-1" data-lte-toggle="card-collapse">
                  <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                  <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                </button>
              </div>
            </div>
            
            <div class="card-body bg-black-subtle p-4">
              <div class="row g-4">
                @foreach ($temas as $item)
                  <div class="col-12 col-lg-6">
                    <form method="POST" action="{{ route('admin.update', $item->id_tema) }}" enctype="multipart/form-data" class="premium-item-card d-flex flex-column justify-content-between">
                      @csrf
                      @method('POST')
                      <div>
                        <div class="media-preview-container p-2 mb-3" style="height: 140px;">
                          <img src="{{ asset('conexao360/img/' . $item->foto_tema) }}" alt="{{ $item->titulo_tema }}" style="object-fit: contain; max-height: 100%;">
                        </div>

                        <div class="mb-3">
                          <label for="foto_tema_{{ $item->id_tema }}" class="form-label">Substituir Imagem do Tema</label>
                          <input class="form-control form-control-sm" id="foto_tema_{{ $item->id_tema }}" name="foto_tema" type="file" accept="image/png,image/jpeg,image/webp">
                        </div>

                        <div class="mb-3">
                          <label for="titulo_tema_{{ $item->id_tema }}" class="form-label">Título do Tema</label>
                          <input type="text" class="form-control" id="titulo_tema_{{ $item->id_tema }}" name="titulo_tema" value="{{ $item->titulo_tema }}">
                        </div>

                        <div class="mb-3">
                          <label for="breve_descricao_tema_{{ $item->id_tema }}" class="form-label">Breve Descrição</label>
                          <input type="text" class="form-control" id="breve_descricao_tema_{{ $item->id_tema }}" name="breve_descricao_tema" value="{{ $item->breve_descricao_tema }}">
                        </div>

                        <div class="mb-3">
                          <label for="subtitulo_tema_{{ $item->id_tema }}" class="form-label">Conteúdo Completo / Subtítulo</label>
                          <textarea class="form-control" id="subtitulo_tema_{{ $item->id_tema }}" name="subtitulo_tema" rows="4" style="resize: none;">{{ $item->subtitulo_tema }}</textarea>
                        </div>

                        <div class="mb-4">
                          <label for="status_tema_{{ $item->id_tema }}" class="form-label">Status de Exibição</label>
                          <select class="form-select" name="status_tema" id="status_tema_{{ $item->id_tema }}" required>
                            <option value="ATIVO" {{ $item->status_tema == 'ATIVO' ? 'selected' : '' }}>Ativo</option>
                            <option value="INATIVO" {{ $item->status_tema == 'INATIVO' ? 'selected' : '' }}>Inativo</option>
                          </select>
                        </div>
                      </div>

                      <div class="d-flex justify-content-end gap-2 border-top border-secondary pt-3 mt-auto">
                        <button type="submit" class="btn btn-premium-confirm">Atualizar Tema</button>
                      </div>
                    </form>
                  </div>
                @endforeach
              </div>
            </div>
          </div>

          {{-- 3. SEÇÃO: EDITAR VÍDEOS --}}
          <div class="card premium-accordion-card collapsed-card">
            <div class="card-header premium-card-header d-flex align-items-center justify-content-between">
              <h3 class="premium-card-title">
                <i class="bi bi-play-btn me-2 text-muted"></i>Editar Acervo de Vídeos
              </h3>
              <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-premium-add" data-bs-toggle="modal" data-bs-target="#criar-videos">
                  <i class="bi bi-plus-circle me-1"></i> Novo Vídeo
                </button>
                <button type="button" class="btn btn-tool text-muted p-1" data-lte-toggle="card-collapse">
                  <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                  <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                </button>
              </div>
            </div>
            
            <div class="card-body bg-black-subtle p-4">
              <div class="row g-4">
                @foreach ($video as $item)
                  <div class="col-12 col-lg-6">
                    <form method="POST" action="{{ route('admin.updateVideo', $item->id_video) }}" enctype="multipart/form-data" class="premium-item-card d-flex flex-column justify-content-between">
                      @csrf
                      @method('POST')
                      <div>
                        <div class="row g-2 mb-3">
                          <div class="col-5">
                            <label class="form-label d-block text-center text-muted m-0 mb-1" style="font-size:0.7rem !important;">Capa Atual</label>
                            <div class="media-preview-container p-1" style="height: 100px;">
                              <img src="{{ asset('conexao360/img/' . $item->capa_video) }}" alt="{{ $item->titulo_video }}" style="object-fit: cover; width:100%; height:100%;">
                            </div>
                          </div>
                          <div class="col-7">
                            <label class="form-label d-block text-center text-muted m-0 mb-1" style="font-size:0.7rem !important;">Player de Origem</label>
                            <div class="media-preview-container" style="height: 100px;">
                              <video style="width:100%; height:100%; object-fit:cover;" controls>
                                <source src="{{ asset('conexao360/img/' . $item->url_video) }}" type="video/mp4">
                              </video>
                            </div>
                          </div>
                        </div>

                        <div class="row g-2 mb-3">
                          <div class="col-6">
                            <label for="url_video_{{ $item->id_video }}" class="form-label">Alterar Arquivo .mp4</label>
                            <input class="form-control form-control-sm" id="url_video_{{ $item->id_video }}" name="url_video" type="file" accept="video/mp4,video/webm">
                          </div>
                          <div class="col-6">
                            <label for="capa_video_{{ $item->id_video }}" class="form-label">Substituir Capa (JPG/PNG)</label>
                            <input class="form-control form-control-sm" id="capa_video_{{ $item->id_video }}" name="capa_video" type="file" accept="image/png,image/jpeg,image/webp">
                          </div>
                        </div>

                        <div class="mb-3">
                          <label for="titulo_video_{{ $item->id_video }}" class="form-label">Título do Vídeo</label>
                          <input type="text" class="form-control" id="titulo_video_{{ $item->id_video }}" name="titulo_video" value="{{ $item->titulo_video }}">
                        </div>

                        <div class="mb-3">
                          <label for="subtitulo_video_{{ $item->id_video }}" class="form-label">Subtítulo Contextual</label>
                          <textarea class="form-control" id="subtitulo_video_{{ $item->id_video }}" name="subtitulo_video" rows="3" style="resize: none;">{{ $item->subtitulo_video }}</textarea>
                        </div>

                        <div class="row g-2 mb-3">
                          <div class="col-6">
                            <label for="breve_descricao_video_{{ $item->id_video }}" class="form-label">Breve Descrição</label>
                            <input type="text" class="form-control" id="breve_descricao_video_{{ $item->id_video }}" name="breve_descricao_video" value="{{ $item->breve_descricao_video }}">
                          </div>
                          <div class="col-6">
                            <label for="legenda_video_{{ $item->id_video }}" class="form-label">Legenda Interna</label>
                            <input type="text" class="form-control" id="legenda_video_{{ $item->id_video }}" name="legenda_video" value="{{ $item->legenda_video }}">
                          </div>
                        </div>

                        <div class="mb-4">
                          <label for="status_video_{{ $item->id_video }}" class="form-label">Status</label>
                          <select class="form-select" name="status_video" id="status_video_{{ $item->id_video }}" required>
                            <option value="ATIVO" {{ $item->status_video == 'ATIVO' ? 'selected' : '' }}>Ativo</option>
                            <option value="INATIVO" {{ $item->status_video == 'INATIVO' ? 'selected' : '' }}>Inativo</option>
                          </select>
                        </div>
                      </div>

                      <div class="d-flex justify-content-end gap-2 border-top border-secondary pt-3 mt-auto">
                        <button type="submit" class="btn btn-premium-confirm">Atualizar Mídia</button>
                      </div>
                    </form>
                  </div>
                @endforeach
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  </main>
{{-- Modais Incorporados via Includes --}}
@include('admin.modal.criar-temas')
@include('admin.modal.criar-videos')

{{-- Container Global das Notificações Toast do Laravel --}}
@if (session('success'))
  <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
    <div id="liveToast" class="toast bg-dark text-white border-success shadow" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
      <div class="toast-header bg-success text-white border-bottom border-light border-opacity-10">
        <i class="bi bi-check-circle-fill me-2"></i>
        <strong class="me-auto">Atualização Concluída</strong>
        <small class="text-white-50">Agora mesmo</small>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body" style="background: #1c1d21;">
        {{ session('success') }}
      </div>
    </div>
  </div>
@endif

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const toastEl = document.getElementById('liveToast');
    if (toastEl) {
      const toast = new bootstrap.Toast(toastEl);
      toast.show();
    }
  });
</script>