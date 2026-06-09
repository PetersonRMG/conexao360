{{-- CARD: EDIÇÃO SEÇÃO FORMULÁRIO/LISTA VIP --}}
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card card-outline card-primary collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Editar Seção Lista Prioritária (Formulário)</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: none;">
                <form method="POST" action="{{ route('admin.lista.update') }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Título da Seção</label>
                        <input type="text" class="form-control" name="titulo_lista" value="{{ $lista->titulo_lista ?? 'Entre para a lista prioritária da Conexão 360º' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea class="form-control" name="descricao_lista" rows="2">{{ $lista->descricao_lista ?? 'Conteúdos estratégicos, acesso antecipado e prioridade nas vagas.' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link do Grupo VIP (Destino do Botão)</label>
                        <input type="url" class="form-control" name="link_grupo" value="{{ $lista->link_grupo ?? '' }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Seção da Lista</button>
                </form>
            </div>
        </div>
    </div>
</div>