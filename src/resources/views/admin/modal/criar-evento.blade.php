<div class="modal modal-lg fade admin-modal-shell" id="criarEvento" tabindex="-1" aria-labelledby="criarEventoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content admin-modal">

            <div class="modal-header admin-modal-header">

                <div class="admin-modal-heading">

                    <span class="admin-modal-title-icon">
                        <i class="bi bi-calendar-event"></i>
                    </span>

                    <div class="admin-modal-title-copy">
                        <h5 class="modal-title admin-modal-title" id="criarEventoLabel">
                            Criar Novo Evento
                        </h5>

                        <p class="admin-modal-subtitle">
                            Cadastre período, localização e informações principais do evento.
                        </p>
                    </div>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>

            </div>


            <form method="POST" action="{{ route('admin.evento.create') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')


                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-12">
                            <label class="form-label" for="banner_evento">
                                Banner Evento
                            </label>

                            <input class="form-control" id="banner_evento" name="banner_evento" type="file"
                                accept="image/png,image/jpeg,image/webp">

                            <div class="form-text">
                                Escolha o banner do evento.
                            </div>
                        </div>


                        <div class="col-12 col-md-8">
                            <label class="form-label" for="titulo_evento">
                                Título Evento
                            </label>

                            <input type="text" class="form-control" id="titulo_evento" name="titulo_evento">

                            <div class="form-text">
                                Informe o título do evento.
                            </div>
                        </div>


                        <div class="col-12 col-md-4">
                            <label class="form-label" for="edicao_evento">
                                Edição Evento
                            </label>

                            <input type="text" class="form-control" id="edicao_evento" name="edicao_evento">

                            <div class="form-text">
                                Ex.: 1ª Edição, 2026.
                            </div>
                        </div>


                        <div class="col-12">
                            <label class="form-label" for="descricao_evento">
                                Descrição Evento
                            </label>

                            <textarea class="form-control" id="descricao_evento" rows="4"
                                name="descricao_evento"></textarea>
                        </div>


                        <div class="col-12">
                            <div class="admin-modal-section">

                                <h6 class="admin-modal-section-title">
                                    <i class="bi bi-clock"></i>
                                    Período do Evento
                                </h6>

                                <div class="row g-3">

                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="data_inicial_evento">
                                            Data Inicial
                                        </label>

                                        <input type="date" class="form-control" id="data_inicial_evento"
                                            name="data_inicial_evento">
                                    </div>


                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="hora_inicial_evento">
                                            Hora Inicial
                                        </label>

                                        <input type="time" class="form-control" id="hora_inicial_evento"
                                            name="hora_inicial_evento">
                                    </div>


                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="data_termino_evento">
                                            Data Término
                                        </label>

                                        <input type="date" class="form-control" id="data_termino_evento"
                                            name="data_termino_evento">
                                    </div>


                                    <div class="col-12 col-md-6">
                                        <label class="form-label" for="hora_termino_evento">
                                            Hora Término
                                        </label>

                                        <input type="time" class="form-control" id="hora_termino_evento"
                                            name="hora_termino_evento">
                                    </div>

                                </div>

                            </div>
                        </div>


                        <div class="col-12">
                            <label class="form-label" for="endereco_evento">
                                Endereço Evento
                            </label>

                            <input type="text" class="form-control" id="endereco_evento" name="endereco_evento">
                        </div>


                        <div class="col-12 col-md-8">
                            <label class="form-label" for="url_evento">
                                URL Evento
                            </label>

                            <input type="url" class="form-control" id="url_evento" name="url_evento"
                                placeholder="https://">
                        </div>


                        <div class="col-12 col-md-4">
                            <label class="form-label" for="status_evento">
                                Status
                            </label>

                            <select class="form-select" required name="status_evento" id="status_evento">
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
                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button type="button" class="admin-secondary-action" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="submit" class="admin-primary-action">
                        <i class="bi bi-check2"></i>
                        Criar Evento
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>