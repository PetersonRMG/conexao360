<div class="modal modal-lg fade"
    id="criarDra"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h1 class="modal-title fs-5" id="exampleModalLabel">
                    Criar Nova Dra
                </h1>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>

            <div class="modal-body">

                <form
                    method="POST"
                    action="{{ route('admin.dra.create') }}"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- FOTO --}}
                    <div class="mb-3 col-md-12">

                        <div class="mb-3">

                            <label
                                for="foto_dra"
                                class="form-label">

                                Foto Dra

                            </label>

                            <input
                                class="form-control form-control-sm"
                                id="foto_dra"
                                name="foto_dra"
                                type="file"
                                accept="image/png,image/jpeg,image/webp">

                            <div class="form-text">
                                Escolha a foto da Dra.
                            </div>

                        </div>

                        <label
                            for="titulo_dra"
                            class="form-label">

                            Título

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="titulo_dra"
                            name="titulo_dra">

                        <div class="form-text">
                            Informe o título.
                        </div>

                    </div>

                    {{-- SUBTÍTULO --}}
                    <div class="mb-3 col-md-12">

                        <label
                            for="sub_titulo_dra"
                            class="form-label">

                            Subtítulo

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="sub_titulo_dra"
                            name="sub_titulo_dra">

                        <div class="form-text">
                            Informe o subtítulo.
                        </div>

                    </div>

                    {{-- DESCRIÇÃO --}}
                    <div class="mb-3 col-md-12">

                        <label
                            for="descricao_dra"
                            class="form-label">

                            Descrição

                        </label>

                        <textarea
                            class="form-control"
                            id="descricao_dra"
                            name="descricao_dra"
                            rows="5"></textarea>

                        <div class="form-text">
                            Informe a descrição.
                        </div>

                    </div>

                    {{-- EVENTO --}}
                    <div class="mb-3 col-md-12">

                        <label
                            for="id_evento"
                            class="form-label">

                            Evento

                        </label>


                        <div class="form-text">
                            Vincule a Dra a um evento.
                        </div>

                    </div>

                    {{-- STATUS --}}
                    <div class="col-md-6 mb-3">

                        <label
                            for="status_dra"
                            class="form-label">

                            Status

                        </label>

                        <select
                            class="form-select"
                            required
                            name="status_dra"
                            id="status_dra">

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

                        <div class="form-text">
                            Informe o status.
                        </div>

                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                            Fechar

                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            Criar Dra

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>