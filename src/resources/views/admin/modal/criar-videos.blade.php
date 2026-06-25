<<<<<<< HEAD
{{-- <div class="modal modal-lg fade" id="criar" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header  ">
                <h1 class="modal-title fs-5 " id="exampleModalLabel">Criar novo Tema</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form method="POST" action="{{ route('admin.create') }}" enctype="multipart/form-data">
                    {{-- O @csrf cria uma proteção para o form --}}
=======
<div class="modal modal-lg fade" id="criarVideo" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">
                    Criar Novo Vídeo
                </h1>

                <button type="button" class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>

            <div class="modal-body">

                <form method="POST"
                    action="{{ route('admin.video.create') }}"
                    enctype="multipart/form-data">
>>>>>>> 8532a288ff91fc142bec881a2eddf19935781021

                    @csrf
                    @method('PUT')

<<<<<<< HEAD

                    {{-- TEMAS --}}
=======
                    {{-- VIDEO --}}
>>>>>>> 8532a288ff91fc142bec881a2eddf19935781021

                    <div class="mb-3 col-md-12">

                        <div class="mb-3">
<<<<<<< HEAD
                            <label for="foto_tema{{ $item->id_tema }}" class="form-label">Foto Tema</label>
                            <input class="form-control  form-control-sm" id="foto_tema{{ $item->id_tema }}" name="foto_tema"
                                type="file" accept="image/png,image/jpeg,image/webp">
                            <div id="emailHelp" class="form-text">Escolha a foto do Produto.</div>
                        </div>

                        <label for="titulo_tema" class="form-label">Titulo Tema</label>
                        <input type="text" class="form-control" id="titulo_tema" name="titulo_tema">
                        <div id="emailHelp" class="form-text">Informe nome da Produto.</div>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="subtitulo_tema" class="form-label">Subtitulo Tema</label>
                        <textarea type="textarea" class="form-control" id="subtitulo_tema" name="subtitulo_tema" rows="5"></textarea>
                        <div id="emailHelp" class="form-text">Informe nome da Produto.</div>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="breve_descricao_tema" class="form-label">Breve Descrição
                            Tema</label>
                        <input type="text" class="form-control" id="breve_descricao_tema"
                            name="breve_descricao_tema">
                        <div id="emailHelp" class="form-text">Informe nome da Produto.</div>
                    </div>

                    <div class="col-md-6 mb-3   ">
                        <label for="status_tema" class="form-label">Status</label>
                        <select class="form-select form-select" aria-label="Status" required name="status_tema"
                            id="status_tema">
                            <option selected>Selecione Categoria do Produto</option>

                            <option value="ATIVO">
                                Ativo</option>
                            <option value="INATIVO">
                                Inativo</option>
                        </select>
                        <div id="emailHelp" class="form-text">Informe o Status do Produto.</div>
                    </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Editar Categoria</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div> --}}
=======
                            <label for="capa_video" class="form-label">
                                Capa do Vídeo
                            </label>

                            <input
                                class="form-control form-control-sm"
                                id="capa_video"
                                name="capa_video"
                                type="file"
                                accept="image/png,image/jpeg,image/webp">

                            <div id="emailHelp" class="form-text">
                                Escolha a capa do vídeo.
                            </div>
                        </div>

                        

                        <div class="mb-3">
                            <label for="url_video" class="form-label">
                                Arquivo do Vídeo
                            </label>

                            <input
                                class="form-control form-control-sm"
                                id="url_video"
                                name="url_video"
                                type="file"
                                accept="video/mp4,video/webm,video/quicktime">

                            <div id="emailHelp" class="form-text">
                                Escolha o vídeo.
                            </div>
                        </div>

                        <label for="titulo_video" class="form-label">
                            Título do Vídeo
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="titulo_video"
                            name="titulo_video">

                        <div id="emailHelp" class="form-text">
                            Informe o título do vídeo.
                        </div>

                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="subtitulo_video" class="form-label">
                            Subtítulo do Vídeo
                        </label>

                        <textarea
                            class="form-control"
                            id="subtitulo_video"
                            name="subtitulo_video"
                            rows="5"></textarea>

                        <div id="emailHelp" class="form-text">
                            Informe o subtítulo do vídeo.
                        </div>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="breve_descricao_video" class="form-label">
                            Breve Descrição do Vídeo
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="breve_descricao_video"
                            name="breve_descricao_video">

                        <div id="emailHelp" class="form-text">
                            Informe uma breve descrição.
                        </div>
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="legenda_video" class="form-label">
                            Legenda do Vídeo
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="legenda_video"
                            name="legenda_video">

                        <div id="emailHelp" class="form-text">
                            Informe uma breve descrição.
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status_video" class="form-label">
                            Status
                        </label>

                        <select
                            class="form-select"
                            aria-label="Status"
                            required
                            name="status_video"
                            id="status_video">

                            <option selected>
                                Selecione o Status
                            </option>

                            <option value="ATIVO">
                                Ativo
                            </option>

                            <option value="INATIVO">
                                Inativo
                            </option>

                        </select>

                        <div id="emailHelp" class="form-text">
                            Informe o Status do Vídeo.
                        </div>
                    </div>

                    <div class="modal-footer">

                        <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Fechar
                        </button>

                        <button type="submit"
                            class="btn btn-danger">
                            Criar Vídeo
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
>>>>>>> 8532a288ff91fc142bec881a2eddf19935781021
