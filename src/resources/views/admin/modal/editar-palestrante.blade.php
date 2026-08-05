{{-- MODAL DE EDIÇÃO --}}
<div class="modal modal-lg fade" id="editarPalestrante{{ $palestrante->id_usuario }}" tabindex="-1"
    aria-labelledby="editarPalestrante" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title d-flex align-items-center" id="editarPalestrante">
                    <i class="bi bi-person-plus-fill text-primary me-2"></i> Editar Palestrante
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.palestrante.update', $palestrante->id_usuario) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Foto --}}
                         <div class="col-12">
                            <div class="col-12 text-start">
                                <img id="previewFoto{{ $palestrante->id_usuario }}"
                                    src="{{ asset('dash/assets/img/' . $palestrante->foto_usuario) }}"
                                    alt="Foto do palestrante" class="img-thumbnail"
                                    style="max-width:180px; max-height:180px; object-fit:cover;">
                            </div>
                            {{-- 

                            <div class="col-12">
                                <label class="form-label text-muted small">Foto do Usuário</label>

                                <input type="file" name="foto_usuario"
                                    class="form-control bg-black text-white border-secondary rounded-3" accept="image/*"
                                    onchange="previewImagem(event, {{ $palestrante->id_usuario }})">
                            </div>

                        </div> --}}
                    </div>
                    {{-- Nome --}}
                    <div class="col-12">
                        <label class="form-label text-muted small">Nome Completo</label>
                        <input type="text" name="nome_usuario"
                            class="form-control bg-black text-white border-secondary rounded-3"
                            value="{{ $palestrante->nome_usuario }}">
                    </div>

                    {{-- Email --}}
                    <div class="col-12">
                        <label class="form-label text-muted small">E-mail</label>
                        <input type="email" name="email_usuario"
                            class="form-control bg-black text-white border-secondary rounded-3"
                            value="{{ $palestrante->email_usuario }}">
                    </div>

                    {{-- Área de Atuação --}}
                    {{-- <div class="col-12">
                        <label class="form-label text-muted small">Área de Atuação</label>
                        <input type="text" name="area_atuacao_usuario" value="{{ $palestrante->area_atuacao_usuario }}"
                            class="form-control bg-black text-white border-secondary rounded-3">
                    </div> --}}





                    {{-- Perfil --}}
                    {{-- <div class="col-12">
                        <label class="form-label text-muted small">Perfil</label>
                        <input type="text" name="perfil_usuario"
                            class="form-control bg-black text-white border-secondary rounded-3 inable" value="{{ $palestrante->perfil_usuario }}"
                            readonly>
                    </div> --}}

                    {{-- Estado --}}
                    {{-- <div class="col-12">
                        <label class="form-label text-muted small">Estado (UF)</label>
                        <input type="text" name="estado_usuario" value="{{ $palestrante->estado_usuario }}"
                            class="form-control bg-black text-white border-secondary rounded-3" maxlength="2">
                    </div> --}}

                    {{-- Sobre --}}
                    {{-- <div class="col-12">
                        <label class="form-label text-muted small">Sobre o Usuário</label>
                        <textarea name="sobre_usuario" value="{{ $palestrante->sobre_usuario }}"
                            class="form-control bg-black text-white border-secondary rounded-3"></textarea>
                    </div> --}}


                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light rounded-3"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4">Salvar Palestrante</button>
                </div>
        </div>
        </form>
    </div>
</div>

<script>
    function previewImagem(event, id) {

        const input = event.target;

        if (input.files && input.files[0]) {

            const reader = new FileReader();

            reader.onload = function (e) {

                document.getElementById('previewFoto' + id).src = e.target.result;

            }

            reader.readAsDataURL(input.files[0]);

        }

    }
</script>