```blade
<div class="modal modal-lg fade" id="criarDepoimento" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Novo Depoimento</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <form  action="{{ route('admin.palestrante.depoimento.create') }}"   method="POST"  enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="row">


                        <div class="col-12 mb-3">
                            <label class="form-label" for="descricao_depoimento">
                                Depoimento
                            </label>

                            <textarea class="form-control" name="descricao_depoimento" id="descricao_depoimento"
                                rows="6" placeholder="Digite o depoimento..."></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Fechar
                        </button>

                        <button type="submit" class="btn btn-light">
                            Criar Depoimento
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
```