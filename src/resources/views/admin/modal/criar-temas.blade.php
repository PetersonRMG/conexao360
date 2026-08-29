<div class="modal modal-lg fade admin-modal-shell" id="criarTemas" tabindex="-1" aria-labelledby="criarTemasLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content admin-modal">

            <div class="modal-header admin-modal-header">

                <div class="admin-modal-heading">

                    <span class="admin-modal-title-icon">
                        <i class="bi bi-palette"></i>
                    </span>

                    <div class="admin-modal-title-copy">
                        <h5 class="modal-title admin-modal-title" id="criarTemasLabel">
                            Criar Novo Tema
                        </h5>

                        <p class="admin-modal-subtitle">
                            Cadastre um novo tema que será apresentado no site.
                        </p>
                    </div>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>

            </div>


            <form method="POST" action="{{ route('admin.tema.create') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')


                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-12">
                            <label class="form-label" for="foto_tema">
                                Foto Tema
                            </label>

                            <input class="form-control" id="foto_tema" name="foto_tema" type="file"
                                accept="image/png,image/jpeg,image/webp">

                            <div class="form-text">
                                Escolha a foto do tema.
                            </div>
                        </div>


                        <div class="col-12">
                            <label class="form-label" for="titulo_tema">
                                Título Tema
                            </label>

                            <input type="text" class="form-control" id="titulo_tema" name="titulo_tema">

                            <div class="form-text">
                                Informe o título do tema.
                            </div>
                        </div>


                        <div class="col-12">
                            <label class="form-label" for="subtitulo_tema">
                                Subtítulo Tema
                            </label>

                            <textarea class="form-control" id="subtitulo_tema" name="subtitulo_tema"
                                rows="4"></textarea>

                            <div class="form-text">
                                Informe o subtítulo do tema.
                            </div>
                        </div>


                        <div class="col-12 col-md-8">
                            <label class="form-label" for="breve_descricao_tema">
                                Breve Descrição Tema
                            </label>

                            <input type="text" class="form-control" id="breve_descricao_tema"
                                name="breve_descricao_tema">

                            <div class="form-text">
                                Informe uma breve descrição do tema.
                            </div>
                        </div>


                        <div class="col-12 col-md-4">
                            <label class="form-label" for="status_tema">
                                Status
                            </label>

                            <select class="form-select" aria-label="Status do Tema" required name="status_tema"
                                id="status_tema">
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
                                Informe o status do tema.
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
                        Criar Tema
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>