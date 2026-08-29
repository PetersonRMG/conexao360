<div class="modal modal-lg fade admin-modal-shell" id="criarBanner" tabindex="-1" aria-labelledby="criarBannerLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content admin-modal">

            <div class="modal-header admin-modal-header">

                <div class="admin-modal-heading">

                    <span class="admin-modal-title-icon">
                        <i class="bi bi-image"></i>
                    </span>

                    <div class="admin-modal-title-copy">
                        <h5 class="modal-title admin-modal-title" id="criarBannerLabel">
                            Novo Banner
                        </h5>

                        <p class="admin-modal-subtitle">
                            Configure a chamada principal exibida no topo do site.
                        </p>
                    </div>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>

            </div>


            <form action="{{ route('admin.hero.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')


                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="tagline_hero">
                                Chamada Superior
                            </label>

                            <input type="text" class="form-control" name="tagline_hero" id="tagline_hero">
                        </div>


                        <div class="col-12 col-md-6">
                            <label class="form-label" for="titulo_hero">
                                Título Principal
                            </label>

                            <input type="text" class="form-control" name="titulo_hero" id="titulo_hero">
                        </div>


                        <div class="col-12">
                            <label class="form-label" for="subtitulo_hero">
                                Subtítulo
                            </label>

                            <textarea class="form-control" name="subtitulo_hero" id="subtitulo_hero"
                                rows="4"></textarea>
                        </div>


                        <div class="col-12 col-md-6">
                            <label class="form-label" for="texto_botao_hero">
                                Texto do Botão
                            </label>

                            <input type="text" class="form-control" name="texto_botao_hero" id="texto_botao_hero">
                        </div>


                        <div class="col-12 col-md-6">
                            <label class="form-label" for="link_botao_hero">
                                Link do Botão
                            </label>

                            <input type="text" class="form-control" name="link_botao_hero" id="link_botao_hero">
                        </div>


                        <div class="col-12 col-md-8">
                            <label class="form-label" for="foto_banner">
                                Imagem do Banner
                            </label>

                            <input type="file" name="foto_banner" id="foto_banner" class="form-control"
                                accept="image/*">

                            <div class="form-text">
                                Selecione a imagem principal do banner.
                            </div>
                        </div>


                        <div class="col-12 col-md-4">
                            <label class="form-label" for="status_hero">
                                Status
                            </label>

                            <select class="form-select" aria-label="Status do Banner" required name="status_hero"
                                id="status_hero">
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
                                Informe o status do banner.
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
                        Criar Banner
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>