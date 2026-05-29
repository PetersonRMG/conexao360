<div class="modal modal-lg fade" id="criar" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header  ">
                <h1 class="modal-title fs-5 " id="exampleModalLabel">Criar novo Tema</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form method="POST" action="{{ route('admin.create') }}" enctype="multipart/form-data">
                    {{-- O @csrf cria uma proteção para o form --}}

                    @csrf
                    @method('PUT')


                    {{-- TEMAS --}}

                    <div class="mb-3 col-md-12">

                        <div class="mb-3">
                            <label for="foto_tema{{ $item->id_tema }}" class="form-label">Foto Tema</label>
                            <input class="form-control  form-control-sm" id="foto_tema{{ $item->id_tema }}" name="foto_tema"
                                type="file" accept="image/png,image/jpeg,image/webp">
                            <div id="emailHelp" class="form-text">Escolha a foto do Produto.</div>
                        </div>

                        <label for="titulo_tema" class="form-label">Titulo Tema</label>
                        <input type="text" class="form-control" id="titulo_tema" name="titulo_tema">
                        <div id="emailHelp" class="form-text">Informe nome da Produto.</div>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="subtitulo_tema" class="form-label">Subtitulo Tema</label>
                        <textarea type="textarea" class="form-control" id="subtitulo_tema" name="subtitulo_tema" rows="5"></textarea>
                        <div id="emailHelp" class="form-text">Informe nome da Produto.</div>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="breve_descricao_tema" class="form-label">Breve Descrição
                            Tema</label>
                        <input type="text" class="form-control" id="breve_descricao_tema"
                            name="breve_descricao_tema">
                        <div id="emailHelp" class="form-text">Informe nome da Produto.</div>
                    </div>

                    <div class="col-md-6 mb-3   ">
                        <label for="status_tema" class="form-label">Status</label>
                        <select class="form-select form-select" aria-label="Status" required name="status_tema"
                            id="status_tema">
                            <option selected>Selecione Categoria do Produto</option>

                            <option value="ATIVO">
                                Ativo</option>
                            <option value="INATIVO">
                                Inativo</option>
                        </select>
                        <div id="emailHelp" class="form-text">Informe o Status do Produto.</div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Editar Categoria</button>
            </div>

            </form>
        </div>
    </div>
</div>
</div>
