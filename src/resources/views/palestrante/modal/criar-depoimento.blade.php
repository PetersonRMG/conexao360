<div
    class="modal modal-lg fade admin-modal-shell"
    id="criarDepoimento"
    tabindex="-1"
    aria-labelledby="criarDepoimentoLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content admin-modal">

            <div class="modal-header admin-modal-header">

                <div class="admin-modal-heading">

                    <span class="admin-modal-title-icon">
                        <i class="bi bi-chat-quote-fill"></i>
                    </span>

                    <div class="admin-modal-title-copy">

                        <h5
                            class="modal-title admin-modal-title"
                            id="criarDepoimentoLabel"
                        >
                            Novo Depoimento
                        </h5>

                        <p class="admin-modal-subtitle">
                            Compartilhe sua experiência no Conexão 360º.
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Fechar"
                ></button>

            </div>


            <form
                action="{{ route('admin.palestrante.depoimento.create') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')


                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-12">

                            <label
                                class="form-label"
                                for="descricao_depoimento"
                            >
                                Depoimento
                            </label>

                            <textarea
                                class="form-control"
                                name="descricao_depoimento"
                                id="descricao_depoimento"
                                rows="7"
                                placeholder="Digite o depoimento..."
                            ></textarea>

                            <div class="form-text">
                                O depoimento ficará disponível conforme o fluxo de aprovação da plataforma.
                            </div>

                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="admin-secondary-action"
                        data-bs-dismiss="modal"
                    >
                        Cancelar
                    </button>


                    <button
                        type="submit"
                        class="admin-primary-action"
                    >
                        <i class="bi bi-send"></i>
                        Enviar Depoimento
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
