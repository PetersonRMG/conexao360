{{-- =============================================================
MODAIS — VISUALIZAR / EDITAR PALESTRANTES
============================================================== --}}

@foreach ($palestrante as $item)

    @php
        $fotoPalestrantePath = !empty($item->foto_usuario)
            ? 'dash/assets/img/' . $item->foto_usuario
            : null;

        $fotoPalestranteExiste =
            $fotoPalestrantePath &&
            file_exists(public_path($fotoPalestrantePath));
    @endphp


    <div
        class="modal fade admin-modal-shell"
        id="editarPalestrante{{ $item->id_usuario }}"
        tabindex="-1"
        aria-labelledby="editarPalestranteLabel{{ $item->id_usuario }}"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

            <div class="modal-content admin-modal">

                {{-- HEADER --}}
                <div class="modal-header admin-modal-header">

                    <div class="admin-modal-heading">

                        <span class="admin-modal-title-icon">
                            <i class="bi bi-pencil-square"></i>
                        </span>

                        <div class="admin-modal-title-copy">

                            <h5
                                class="modal-title admin-modal-title"
                                id="editarPalestranteLabel{{ $item->id_usuario }}"
                            >
                                Editar Palestrante
                            </h5>

                            <p class="admin-modal-subtitle">
                                Atualize os dados do palestrante selecionado.
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
                    action="{{ route('admin.palestrante.update', $item->id_usuario) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf
                    @method('PUT')


                    <div class="modal-body">

                        <div class="row g-3">


                            {{-- FOTO ATUAL --}}
                            <div class="col-12">

                                <div class="admin-modal-photo-preview">

                                    @if ($fotoPalestranteExiste)

                                        <img
                                            src="{{ asset($fotoPalestrantePath) }}"
                                            alt="Foto de {{ $item->nome_usuario }}"
                                        >

                                    @else

                                        <div class="admin-modal-photo-fallback">
                                            <i class="bi bi-person"></i>
                                        </div>

                                    @endif


                                    <div class="admin-modal-photo-copy">

                                        <strong>
                                            {{ $item->nome_usuario }}
                                        </strong>

                                        <span>
                                            {{ $item->email_usuario }}
                                        </span>

                                    </div>

                                </div>

                            </div>


                            {{-- NOME --}}
                            <div class="col-12 col-md-6">

                                <label
                                    class="form-label"
                                    for="nome_usuario_{{ $item->id_usuario }}"
                                >
                                    Nome Completo
                                </label>

                                <input
                                    type="text"
                                    name="nome_usuario"
                                    id="nome_usuario_{{ $item->id_usuario }}"
                                    class="form-control"
                                    value="{{ $item->nome_usuario }}"
                                    required
                                >

                            </div>


                            {{-- E-MAIL --}}
                            <div class="col-12 col-md-6">

                                <label
                                    class="form-label"
                                    for="email_usuario_{{ $item->id_usuario }}"
                                >
                                    E-mail
                                </label>

                                <input
                                    type="email"
                                    name="email_usuario"
                                    id="email_usuario_{{ $item->id_usuario }}"
                                    class="form-control"
                                    value="{{ $item->email_usuario }}"
                                    required
                                >

                            </div>


                            {{-- ÁREA DE ATUAÇÃO --}}
                            <div class="col-12 col-md-6">

                                <label
                                    class="form-label"
                                    for="area_atuacao_usuario_{{ $item->id_usuario }}"
                                >
                                    Área de Atuação
                                </label>

                                <input
                                    type="text"
                                    name="area_atuacao_usuario"
                                    id="area_atuacao_usuario_{{ $item->id_usuario }}"
                                    class="form-control"
                                    value="{{ $item->area_atuacao_usuario }}"
                                >

                            </div>


                            {{-- PERFIL --}}
                            <div class="col-12 col-md-6">

                                <label
                                    class="form-label"
                                    for="perfil_usuario_{{ $item->id_usuario }}"
                                >
                                    Perfil
                                </label>

                                <input
                                    type="text"
                                    name="perfil_usuario"
                                    id="perfil_usuario_{{ $item->id_usuario }}"
                                    class="form-control"
                                    value="{{ $item->perfil_usuario }}"
                                    readonly
                                >

                            </div>


                            {{-- ESTADO --}}
                            <div class="col-12 col-md-6">

                                <label
                                    class="form-label"
                                    for="estado_usuario_{{ $item->id_usuario }}"
                                >
                                    Estado
                                </label>

                                <input
                                    type="text"
                                    name="estado_usuario"
                                    id="estado_usuario_{{ $item->id_usuario }}"
                                    class="form-control"
                                    value="{{ $item->estado_usuario }}"
                                    maxlength="2"
                                >

                            </div>


                            {{-- STATUS --}}
                            <div class="col-12 col-md-6">

                                <label
                                    class="form-label"
                                    for="status_usuario_{{ $item->id_usuario }}"
                                >
                                    Status
                                </label>

                                <select
                                    name="status_usuario"
                                    id="status_usuario_{{ $item->id_usuario }}"
                                    class="form-select"
                                >

                                    <option
                                        value="ATIVO"
                                        {{ $item->status_usuario === 'ATIVO' ? 'selected' : '' }}
                                    >
                                        Ativo
                                    </option>

                                    <option
                                        value="INATIVO"
                                        {{ $item->status_usuario === 'INATIVO' ? 'selected' : '' }}
                                    >
                                        Inativo
                                    </option>

                                </select>

                            </div>


                            {{-- SOBRE --}}
                            <div class="col-12">

                                <label
                                    class="form-label"
                                    for="sobre_usuario_{{ $item->id_usuario }}"
                                >
                                    Sobre
                                </label>

                                <textarea
                                    name="sobre_usuario"
                                    id="sobre_usuario_{{ $item->id_usuario }}"
                                    class="form-control"
                                    rows="4"
                                >{{ $item->sobre_usuario }}</textarea>

                            </div>


                            {{-- ALTERAR FOTO --}}
                            <div class="col-12">

                                <label
                                    class="form-label"
                                    for="foto_usuario_{{ $item->id_usuario }}"
                                >
                                    Alterar Foto
                                </label>

                                <input
                                    type="file"
                                    name="foto_usuario"
                                    id="foto_usuario_{{ $item->id_usuario }}"
                                    class="form-control"
                                    accept="image/*"
                                >

                            </div>

                        </div>

                    </div>


                    {{-- FOOTER --}}
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
                            <i class="bi bi-check2"></i>

                            Salvar Palestrante
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endforeach