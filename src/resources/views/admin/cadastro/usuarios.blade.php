<<<<<<< HEAD
@extends('admin.dash.dashboard')

@section('content')
<main class="app-main">
    {{-- Cabeçalho da Página --}}
    <div class="app-content-header pt-3">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0 text-white font-weight-bold">Gerenciamento de Usuários</h4>
                <p class="text-muted small mb-0">Crie os acessos iniciais para os novos membros da equipe administrativa.</p>
            </div>
            <button type="button" class="btn btn-primary rounded-3 d-flex align-items-center px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalNovoUsuario">
                <i class="bi bi-person-plus me-2"></i> Pré-Cadastrar Usuário
            </button>
        </div>
    </div>

    {{-- Conteúdo Principal --}}
    <div class="app-content ps-3 pt-3">
        <div class="container-fluid">
            
            <div class="card card-outline card-primary bg-dark text-white border-0 shadow-sm rounded-3">
                <div class="card-header border-bottom border-secondary">
                    <h3 class="card-title text-white mb-0" style="font-size: 1.05rem;">
                        <i class="bi bi-people me-2 text-primary"></i> Operadores de Sistema
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0 align-middle">
                            <thead class="table-black text-muted small uppercase">
                                <tr>
                                    <th class="ps-4">E-mail de Acesso</th>
                                    <th>Cargo / Função administrativa</th>
                                    <th>Status do Perfil</th>
                                    <th class="text-end pe-4" style="width: 150px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4">
                                        <div class="font-weight-bold text-white">suporte@conexao360.com</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary rounded-2">Moderador de Conteúdo</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success rounded-pill px-2" style="font-size: 0.7rem;">Ativo / Configurado</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-light rounded-2 me-1" title="Editar Cargo"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-outline-danger rounded-2" title="Bloquear Conta"><i class="bi bi-toggle-on"></i></button>
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

{{-- MODAL OTIMIZADO: PRÉ-CADASTRO DE USUÁRIO --}}
<div class="modal fade" id="modalNovoUsuario" tabindex="-1" aria-labelledby="modalNovoUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title d-flex align-items-center" id="modalNovoUsuarioLabel">
                    <i class="bi bi-person-plus-fill text-primary me-2"></i> Conceder Acesso ao Painel
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Email --}}
                        <div class="col-12">
                            <label class="form-label text-muted small">E-mail Institucional</label>
                            <input type="email" name="email" class="form-control bg-black text-white border-secondary rounded-3" placeholder="Ex: admin@conexao360.com" required>
                        </div>

                        {{-- Cargo --}}
                        <div class="col-12">
                            <label class="form-label text-muted small">Cargo / Departamento</label>
                            <input type="text" name="cargo" class="form-control bg-black text-white border-secondary rounded-3" placeholder="Ex: Suporte / Gerente de Marketing" required>
                        </div>

                        {{-- Senha Inicial --}}
                        <div class="col-12">
                            <label class="form-label text-muted small">Senha Provisória de Acesso</label>
                            <input type="password" name="password" class="form-control bg-black text-white border-secondary rounded-3" placeholder="Mínimo 8 caracteres" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light rounded-3" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4">Criar Conta</button>
                </div>
            </form>
        </div>
    </div>
</div>
=======
@extends('layout.admin')
@section('title', 'Cadastro Usuários')
@section('pg-titulo', 'Cadastro Usuários')
@section('link-topo', 'Cadastro Usuários')

@section('content')
    <main class="app-main">
        {{-- Cabeçalho da Página --}}
        <div class="app-content-header pt-3">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0 text-white font-weight-bold">Gerenciamento de Usuários</h4>
                    <p class="text-muted small mb-0">Crie os acessos iniciais para os novos membros da equipe
                        administrativa.</p>
                </div>
                <button type="button" class="btn btn-primary rounded-3 d-flex align-items-center px-3 py-2"
                    data-bs-toggle="modal" data-bs-target="#modalNovoUsuario">
                    <i class="bi bi-person-plus me-2"></i> Pré-Cadastrar Usuário
                </button>
            </div>
        </div>

        {{-- Conteúdo Principal --}}
        <div class="app-content ps-3 pt-3">
            <div class="container-fluid">

                <div class="card card-outline card-primary bg-dark text-white border-0 shadow-sm rounded-3">
                    <div class="card-header border-bottom border-secondary">
                        <h3 class="card-title text-white mb-0" style="font-size: 1.05rem;">
                            <i class="bi bi-people me-2 text-primary"></i> Operadores de Sistema
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0 align-middle">
                                <thead class="table-black text-muted small uppercase">
                                    <tr>
                                        <th class="ps-4">E-mail de Acesso</th>
                                        <th>Cargo / Função administrativa</th>
                                        <th>Status do Perfil</th>
                                        <th class="text-end pe-4" style="width: 150px;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="font-weight-bold text-white">suporte@conexao360.com</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary rounded-2">Moderador de Conteúdo</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success rounded-pill px-2"
                                                style="font-size: 0.7rem;">Ativo / Configurado</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-sm btn-outline-light rounded-2 me-1"
                                                title="Editar Cargo"><i class="bi bi-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger rounded-2"
                                                title="Bloquear Conta"><i class="bi bi-toggle-on"></i></button>
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

    {{-- MODAL OTIMIZADO: PRÉ-CADASTRO DE USUÁRIO --}}
    <div class="modal fade" id="modalNovoUsuario" tabindex="-1" aria-labelledby="modalNovoUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-white border-secondary">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title d-flex align-items-center" id="modalNovoUsuarioLabel">
                        <i class="bi bi-person-plus-fill text-primary me-2"></i> Conceder Acesso ao Painel
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            {{-- Email --}}
                            <div class="col-12">
                                <label class="form-label text-muted small">E-mail Institucional</label>
                                <input type="email" name="email"
                                    class="form-control bg-black text-white border-secondary rounded-3"
                                    placeholder="Ex: admin@conexao360.com" required>
                            </div>

                            {{-- Cargo --}}
                            <div class="col-12">
                                <label class="form-label text-muted small">Cargo / Departamento</label>
                                <input type="text" name="cargo"
                                    class="form-control bg-black text-white border-secondary rounded-3"
                                    placeholder="Ex: Suporte / Gerente de Marketing" required>
                            </div>

                            {{-- Senha Inicial --}}
                            <div class="col-12">
                                <label class="form-label text-muted small">Senha Provisória de Acesso</label>
                                <input type="password" name="password"
                                    class="form-control bg-black text-white border-secondary rounded-3"
                                    placeholder="Mínimo 8 caracteres" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-outline-light rounded-3"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary rounded-3 px-4">Criar Conta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
>>>>>>> 8532a288ff91fc142bec881a2eddf19935781021
@endsection