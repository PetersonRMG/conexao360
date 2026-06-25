<div class="modal modal-lg fade" id="criarEvento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">
                    Criar Novo Evento
                </h1>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <div class="modal-body">

                <form method="POST" action="{{ route('admin.evento.create') }}" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- Banner --}}
                    <div class="mb-3">
                        <label class="form-label">Banner Evento</label>

                        <input class="form-control" name="banner_evento" type="file"
                            accept="image/png,image/jpeg,image/webp">

                        <div class="form-text">
                            Escolha o banner do evento.
                        </div>
                    </div>

                    {{-- Título --}}
                    <div class="mb-3">
                        <label class="form-label">Título Evento</label>

                        <input type="text" class="form-control" name="titulo_evento">

                        <div class="form-text">
                            Informe o título do evento.
                        </div>
                    </div>

                    {{-- Edição --}}
                    <div class="mb-3">
                        <label class="form-label">Edição Evento</label>

                        <input type="text" class="form-control" name="edicao_evento">

                        <div class="form-text">
                            Ex: 1ª Edição, 2026, etc.
                        </div>
                    </div>

                    {{-- Descrição --}}
                    <div class="mb-3">
                        <label class="form-label">Descrição Evento</label>

                        <textarea class="form-control" rows="4" name="descricao_evento"></textarea>
                    </div>

                    {{-- Data/Hora Início --}}
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Inicial</label>

                            <input type="date" class="form-control" name="data_inicial_evento">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hora Inicial</label>

                            <input type="time" class="form-control" name="hora_inicial_evento">
                        </div>

                    </div>

                    {{-- Data/Hora Término --}}
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data Término</label>

                            <input type="date" class="form-control" name="data_termino_evento">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hora Término</label>

                            <input type="time" class="form-control" name="hora_termino_evento">
                        </div>

                    </div>

                    {{-- Endereço --}}
                    <div class="mb-3">
                        <label class="form-label">Endereço Evento</label>

                        <input type="text" class="form-control" name="endereco_evento">
                    </div>

                    {{-- URL --}}
                    <div class="mb-3">
                        <label class="form-label">URL Evento</label>

                        <input type="url" class="form-control" name="url_evento" placeholder="https://">
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>

                        <select class="form-select" required name="status_evento">

                            <option selected disabled>
                                Selecione o Status
                            </option>

                            <option value="ATIVO">
                                Ativo
                            </option>

                            <option value="INATIVO">
                                Inativo
                            </option>

                        </select>
                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Fechar
                        </button>

                        <button type="submit" class="btn btn-success">
                            Criar Evento
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>