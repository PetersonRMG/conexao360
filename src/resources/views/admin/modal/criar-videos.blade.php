<div class="modal modal-lg fade admin-modal-shell" id="criarVideo" tabindex="-1" aria-labelledby="criarVideoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content admin-modal">

            <div class="modal-header admin-modal-header">

                <div class="admin-modal-heading">

                    <span class="admin-modal-title-icon">
                        <i class="bi bi-play-btn"></i>
                    </span>

                    <div class="admin-modal-title-copy">
                        <h5 class="modal-title admin-modal-title" id="criarVideoLabel">
                            Criar Novo Vídeo
                        </h5>

                        <p class="admin-modal-subtitle">
                            Adicione o vídeo, a capa e as informações exibidas no site.
                        </p>
                    </div>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>

            </div>


            <form method="POST" action="{{ route('admin.video.create') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')


                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="capa_video">
                                Capa do Vídeo
                            </label>

                            <input class="form-control" id="capa_video" name="capa_video" type="file"
                                accept="image/png,image/jpeg,image/webp">

                            <div class="form-text">
                                Escolha a capa do vídeo.
                            </div>
                        </div>


                        <div class="col-12 col-md-6">
                            <label class="form-label" for="url_video">
                                Arquivo do Vídeo
                            </label>

                            <input class="form-control" id="url_video" name="url_video" type="file"
                                accept="video/mp4,video/webm,video/quicktime">

                            <div class="form-text">
                                Escolha o vídeo.
                            </div>
                        </div>


                        <div class="col-12">
                            <label class="form-label" for="titulo_video">
                                Título do Vídeo
                            </label>

                            <input type="text" class="form-control" id="titulo_video" name="titulo_video">

                            <div class="form-text">
                                Informe o título do vídeo.
                            </div>
                        </div>


                        <div class="col-12">
                            <label class="form-label" for="subtitulo_video">
                                Subtítulo do Vídeo
                            </label>

                            <textarea class="form-control" id="subtitulo_video" name="subtitulo_video"
                                rows="4"></textarea>

                            <div class="form-text">
                                Informe o subtítulo do vídeo.
                            </div>
                        </div>


                        <div class="col-12 col-md-6">
                            <label class="form-label" for="breve_descricao_video">
                                Breve Descrição do Vídeo
                            </label>

                            <input type="text" class="form-control" id="breve_descricao_video"
                                name="breve_descricao_video">

                            <div class="form-text">
                                Informe uma breve descrição.
                            </div>
                        </div>


                        <div class="col-12 col-md-6">
                            <label class="form-label" for="legenda_video">
                                Legenda do Vídeo
                            </label>

                            <input type="text" class="form-control" id="legenda_video" name="legenda_video">

                            <div class="form-text">
                                Informe a legenda do vídeo.
                            </div>
                        </div>


                        <div class="col-12 col-md-5">
                            <label class="form-label" for="status_video">
                                Status
                            </label>

                            <select class="form-select" aria-label="Status do Vídeo" required name="status_video"
                                id="status_video">
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
                                Informe o status do vídeo.
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
                        Criar Vídeo
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>