@extends('layout.admin')
@section('title', 'Cadastro Palestrante')
@section('pg-titulo', 'Cadastro Palestrante')
@section('link-topo', 'Cadastro Palestrante')

@section('content')
    <main class="app-main">
        {{-- Cabeçalho da Página --}}
        <div class="app-content-header pt-3">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0 text-white font-weight-bold">Gerenciamento de Palestrantes</h4>
                    <p class="text-muted small mb-0">Pré-cadastre os palestrantes. Eles poderão completar o perfil (foto,
                        bio, redes sociais) no primeiro acesso.</p>
                </div>
                <button type="button" class="btn btn-primary rounded-3 d-flex align-items-center px-3 py-2"
                    data-bs-toggle="modal" data-bs-target="#modalNovoPalestrante">
                    <i class="bi bi-plus-circle me-2"></i> Pré-Cadastrar Palestrante
                </button>
            </div>
        </div>

        {{-- Conteúdo Principal --}}
        <div class="app-content ps-3 pt-3">
            <div class="container-fluid">

                <div class="card card-outline card-primary bg-dark text-white border-0 shadow-sm rounded-3">
                    <div class="card-header border-bottom border-secondary">
                        <h3 class="card-title text-white mb-0" style="font-size: 1.05rem;">
                            <i class="bi bi-mic me-2 text-primary"></i> Contas de Palestrantes
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0 align-middle">
                                <thead class="table-black text-muted small uppercase">
                                    <tr>
                                        <th class="ps-4">E-mail de Acesso</th>
                                        <th>Cargo / Função</th>
                                        <th>Perfil do Usuário</th>
                                        <th class="text-end pe-4" style="width: 150px;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="font-weight-bold text-white">palestrante@exemplo.com</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary rounded-2">Esp. em Inteligência
                                                Artificial</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning text-dark rounded-pill px-2"
                                                style="font-size: 0.7rem;">Pendente (Incompleto)</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-sm btn-outline-light rounded-2 me-1"
                                                title="Editar Cargo"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger rounded-2"
                                                title="Excluir Acesso"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    {{-- MODAL OTIMIZADO: PRÉ-CADASTRO DE PALESTRANTE --}}
    <div class="modal modal-lg fade" id="modalNovoPalestrante" tabindex="-1" aria-labelledby="modalNovoUsuarioLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white border-secondary">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title d-flex align-items-center" id="modalNovoPalestrante">
                        <i class="bi bi-person-plus-fill text-primary me-2"></i> Cadastrar Novo Usuário
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.palestrantes.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row g-3">
                            {{-- Nome --}}
                            <div class="col-12">
                                <label class="form-label text-muted small">Nome Completo</label>
                                <input type="text" name="nome_usuario"
                                    class="form-control bg-black text-white border-secondary rounded-3" required>
                            </div>

                            {{-- Foto --}}
                            <div class="col-12">
                                <label class="form-label text-muted small">Foto do Usuário</label>
                                <input type="file" name="foto_usuario"
                                    class="form-control bg-black text-white border-secondary rounded-3" accept="image/*"
                                    required>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="col-12">
                            <label class="form-label text-muted small">E-mail</label>
                            <input type="email" name="email_usuario"
                                class="form-control bg-black text-white border-secondary rounded-3" required>
                        </div>

                        {{-- Área de Atuação --}}
                        <div class="col-12">
                            <label class="form-label text-muted small">Área de Atuação</label>
                            <input type="text" name="area_atuacao_usuario"
                                class="form-control bg-black text-white border-secondary rounded-3" required>
                        </div>

                        {{-- Senha --}}
                        <div class="col-12">
                            <label class="form-label text-muted small">Senha</label>
                            <input type="password" name="senha_usuario"
                                class="form-control bg-black text-white border-secondary rounded-3" required>
                        </div>

                        {{-- Termos --}}
                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" name="termos_usuario" value="1"
                                    class="form-check-input bg-dark border-secondary" id="termos_usuario">
                                <label class="form-check-label text-muted small" for="termos_usuario">Aceito os termos de                                    uso</label>
                            </div>
                        </div>

                        {{-- Perfil --}}
                        <div class="col-12">
                            <label class="form-label text-muted small">Perfil</label>
                            <input type="text" name="perfil_usuario"
                                class="form-control bg-black text-white border-secondary rounded-3" 
                                 value="palestrante"    required>
                        </div>

                        {{-- Estado --}}
                        <div class="col-12">
                            <label class="form-label text-muted small">Estado (UF)</label>
                            <input type="text" name="estado_usuario"
                                class="form-control bg-black text-white border-secondary rounded-3" maxlength="2" required>
                        </div>

                        {{-- Sobre --}}
                        <div class="col-12">
                            <label class="form-label text-muted small">Sobre o Usuário</label>
                            <textarea name="sobre_usuario"
                                class="form-control bg-black text-white border-secondary rounded-3" required></textarea>
                        </div>

                        {{-- Status --}}
                            <div class="col-md-6 mb-3   ">
                                <label for="status_usuario" class="form-label">Status Banner</label>
                                <select class="form-select form-select" aria-label="Status" required name="status_usuario"
                                    id="status_hero">
                                    <option selected>Selecione Status do Palestrante</option>

                                    <option value="ATIVO">
                                        Ativo</option>
                                    <option value="INATIVO">
                                        Inativo</option>
                                </select>
                                <div id="emailHelp" class="form-text">Informe o Status do Banner.</div>
                            </div>
                    </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-outline-light rounded-3" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary rounded-3 px-4">Salvar Usuário</button>
            </div>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection