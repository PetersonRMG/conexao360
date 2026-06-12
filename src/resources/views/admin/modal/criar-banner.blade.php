<div class="modal modal-lg fade" id="criarBanner" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header  ">
                <h1 class="modal-title fs-5 " id="exampleModalLabel">Novo Banner</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="{{ route('admin.hero.create') }}"
                        method="POST"
                        enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div  class="row">

                        <div class="col-md-8">

                            <div class="mb-3">
                                <label class="form-label" for="tagline_hero">Chamada Superior</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="tagline_hero"
                                    id="tagline_hero"

                                   >
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="titulo_hero">Título Principal</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="titulo_hero"
                                    id="titulo_hero"
                                    >
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="subtitulo_hero">Subtítulo</label>
                                <textarea
                                    class="form-control"
                                    name="subtitulo_hero"
                                    id="subtitulo_hero"
                                    rows="4"> </textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"  for="texto_botao_hero">Texto do Botão</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="texto_botao_hero"
                                    id="texto_botao_hero"
                                    >
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="link_botao_hero">Link do Botão</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="link_botao_hero"
                                    id="link_botao_hero" >
                            </div>

                        </div>

                        <div class="col-md-4">                     

                            <input
                                type="file"
                                name="foto_banner"
                                id="foto_banner"
                                class="form-control">

                            </div>

                            
                            <div class="col-md-6 mb-3   ">
                                <label for="status_hero" class="form-label">Status Banner</label>
                                <select class="form-select form-select" aria-label="Status" required name="status_hero"
                                    id="status_hero">
                                    <option selected>Selecione Status do Banner</option>

                                    <option value="ATIVO">
                                        Ativo</option>
                                    <option value="INATIVO">
                                        Inativo</option>
                                </select>
                                <div id="emailHelp" class="form-text">Informe o Status do Banner.</div>
                            </div>
                        </div>
                        

                    </div>

                    <button type="submit" class="btn btn-success">
                        Salvar Banner
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>