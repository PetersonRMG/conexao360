<div class="modal modal-lg fade admin-modal-shell" id="criarDra" tabindex="-1" aria-labelledby="criarDraLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content admin-modal">

            <div class="modal-header admin-modal-header">

                <div class="admin-modal-heading">

                    <span class="admin-modal-title-icon">
                        <i class="bi bi-person-badge"></i>
                    </span>

                    <div class="admin-modal-title-copy">
                        <h5 class="modal-title admin-modal-title" id="criarDraLabel">
                            Criar Nova Dra
                        </h5>

                        <p class="admin-modal-subtitle">
                            Cadastre as informações apresentadas na seção da palestrante.
                        </p>
                    </div>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>

            </div>


            <form method="POST" action="{{ route('admin.dra.create') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')


                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-12">
                            <label class="form-label" for="foto_dra">
                                Foto Dra
                            </label>

                            <input class="form-control" id="foto_dra" name="foto_dra" type="file"
                                accept="image/png,image/jpeg,image/webp">

                            <div class="form-text">
                                Escolha a foto da Dra.
                            </div>
                        </div>


                        <div class="col-12 col-md-6">
                            <label class="form-label" for="titulo_dra">
                                Título
                            </label>

                            <input type="text" class="form-control" id="titulo_dra" name="titulo_dra">

                            <div class="form-text">
                                Informe o título.
                            </div>
                        </div>


                        <div class="col-12 col-md-6">
                            <label class="form-label" for="sub_titulo_dra">
                                Subtítulo
                            </label>

                            <input type="text" class="form-control" id="sub_titulo_dra" name="sub_titulo_dra">

                            <div class="form-text">
                                Informe o subtítulo.
                            </div>
                        </div>


                        <div class="col-12">
                            <label class="form-label" for="descricao_dra">
                                Descrição
                            </label>

                            <textarea class="form-control" id="descricao_dra" name="descricao_dra" rows="5"></textarea>

                            <div class="form-text">
                                Informe a descrição.
                            </div>
                        </div>


                        <div class="col-12 col-md-5">
                            <label class="form-label" for="status_dra">
                                Status
                            </label>

                            <select class="form-select" required name="status_dra" id="status_dra">
                                <option value="" selected disabled>
                                    Selecione o status
                                </option>

                                <option value="ATIVO">
                                    Ativo
                                </option>

                                <option value="INATIVO">
                                    Inativo
                                </option>
                            </select>

                            <div class="form-text">
                                Informe o status.
                            </div>
                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button" class="admin-secondary-action" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="submit" class="admin-primary-action">
                        <i class="bi bi-check2"></i>
                        Criar Dra
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>