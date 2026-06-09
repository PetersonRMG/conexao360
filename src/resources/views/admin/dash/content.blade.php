<div class="container-fluid px-4 mt-3">

    {{-- Exibição de Mensagens --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- CARD 1: BANNER TOPO --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card card-outline card-success collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Editar Seção Principal (Banner Topo)</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <form method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3"><label class="form-label">Chamada Superior</label><input type="text"
                                        class="form-control" name="tagline" value="{{ $hero->tagline ?? '' }}"></div>
                                <div class="mb-3"><label class="form-label">Título Principal</label><input type="text"
                                        class="form-control" name="titulo" value="{{ $hero->titulo ?? '' }}"></div>
                                <div class="mb-3"><label class="form-label">Subtítulo</label><textarea
                                        class="form-control" name="subtitulo"
                                        rows="3">{{ $hero->subtitulo ?? '' }}</textarea></div>
                            </div>
                            <div class="col-md-4 text-center">
                                <label class="form-label fw-bold">Imagem de Destaque</label>
                                <input class="form-control" name="foto_banner" type="file">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Salvar Banner</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD 2: SEÇÃO DRA. SIMONE --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card card-outline card-info collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Editar Seção Dra. Simone</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <form method="POST" action="{{ route('admin.dra.update') }}" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Cargo</label>
                                    <input type="text" class="form-control" name="cargo_dra"
                                        value="{{ $dra->cargo_dra ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Texto</label>
                                    <textarea class="form-control" name="texto_dra"
                                        rows="3">{{ $dra->texto_dra ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <label class="form-label fw-bold">Foto da Dra. Simone</label>
                                {{-- Exibe a foto atual se existir --}}
                                @if(!empty($dra->foto_dra))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $dra->foto_dra) }}" alt="Foto atual"
                                            style="max-height: 100px;" class="img-thumbnail">
                                    </div>
                                @endif
                                <input type="file" class="form-control" name="foto_dra">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info">Salvar Dra. Simone</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD 3: EDITAR TEMAS --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card card-outline card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Editar Temas</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                class="fas fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <div class="row p-2">
                        @foreach ($temas as $item)
                            <div class="col-12 col-md-6 mb-4">
                                <form method="POST" " enctype=" multipart/form-data">
                                    @csrf @method('PUT')
                                    <div class="card p-3 shadow-sm">
                                        <div class="mb-3"><label class="form-label fw-bold">Título</label><input type="text"
                                                class="form-control" name="titulo_tema" value=""></div>
                                        <div class="mb-3"><label class="form-label fw-bold">Status</label>
                                            <select class="form-select" name="status_tema">
                                                <option value="ATIVO">Ativo</option>
                                                <option value="INATIVO">Inativo</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">Confirmar Alterações</button>
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

{{-- CARD: EDIÇÃO SEÇÃO CONEXÃO 360 --}}
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card card-outline card-warning collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Editar Seção Conexão 360° (Logo e Título)</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: none;">
                {{-- Certifique-se de criar a rota 'admin.conexao.update' no seu web.php --}}
                <form method="POST" action="{{ route('admin.conexao.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Título da Edição</label>
                                <input type="text" class="form-control" name="titulo_edicao"
                                    value="{{ $conexao->titulo_edicao ?? '3° EDIÇÃO' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slogan</label>
                                <input type="text" class="form-control" name="slogan"
                                    value="{{ $conexao->slogan ?? 'ADVOCACIA EXPONENCIAL' }}">
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <label class="form-label">Logo Conexão 360°</label>
                            @if(!empty($conexao->logo_conexao))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $conexao->logo_conexao) }}" style="max-height: 80px;"
                                        class="img-fluid">
                                </div>
                            @endif
                            <input type="file" class="form-control" name="logo_conexao">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning">Salvar Alterações Conexão 360</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- CARD: EDIÇÃO LOCALIZAÇÃO E EVENTO --}}
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card card-outline card-danger collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Editar Localização e Evento</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: none;">
                <form method="POST" action="{{ route('admin.evento.update') }}">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Data e Horário</label>
                                <input type="text" class="form-control" name="data_evento"
                                    value="{{ $evento->data_evento ?? '14 e 15 de Março de 2026, às 19h.' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Endereço</label>
                                <input type="text" class="form-control" name="local_evento"
                                    value="{{ $evento->local_evento ?? 'Alameda Araguaia 2104 - Alphaville industrial' }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link do Google Maps (Embed)</label>
                        <textarea class="form-control" name="link_maps"
                            rows="2">{{ $evento->link_maps ?? '' }}</textarea>
                        <small class="text-muted">Cole aqui o código de incorporação do Google Maps.</small>
                    </div>
                    <button type="submit" class="btn btn-danger">Salvar Evento</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- CARD: EDIÇÃO BANNER PRINCIPAL --}}
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card card-outline card-success collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Editar Seção Principal (Banner de Fundo)</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: none;">
                <form method="POST" action="{{ route('admin.hero.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label">Título Principal</label>
                                <textarea class="form-control" name="titulo"
                                    rows="2">{{ $hero->titulo ?? '' }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Subtítulo/Texto de Apoio</label>
                                <textarea class="form-control" name="subtitulo"
                                    rows="3">{{ $hero->subtitulo ?? '' }}</textarea>
                            </div>
                        </div>



                        <div class="mb-3">
                            <label class="form-label">Link do Botão (URL de destino)</label>
                            <input type="url" class="form-control" name="link_botao"
                                value="{{ $evento->link_botao ?? '' }}" placeholder="https://...">
                        </div>



                        <div class="col-md-5 text-center">
                            <label class="form-label fw-bold">Imagem de Fundo Atual</label>
                            @if(!empty($hero->foto_fundo))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $hero->foto_fundo) }}"
                                        style="max-height: 120px; width: 100%; object-fit: cover;" class="img-thumbnail">
                                </div>
                            @endif
                            <input type="file" class="form-control" name="foto_fundo">
                            <small class="text-muted">Formatos: JPG, PNG. Tamanho máx: 2MB.</small>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Salvar Alterações do Banner</button>
                </form>
            </div>
        </div>
    </div>
</div>




{{-- SCRIPT PARA FUNCIONAMENTO DAS SETAS --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const collapseButtons = document.querySelectorAll('[data-card-widget="collapse"]');

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
</script>