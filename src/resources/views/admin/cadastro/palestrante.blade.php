@extends('admin.dash.dashboard')

@section('content')
<main class="app-main">
    {{-- Cabeçalho da Página --}}
    <div class="app-content-header pt-3">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0 text-white font-weight-bold">Gerenciamento de Palestrantes</h4>
                <p class="text-muted small mb-0">Pré-cadastre os palestrantes. Eles poderão completar o perfil (foto, bio, redes sociais) no primeiro acesso.</p>
            </div>
            <button type="button" class="btn btn-primary rounded-3 d-flex align-items-center px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalNovoPalestrante">
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
                                        <span class="badge bg-secondary rounded-2">Esp. em Inteligência Artificial</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark rounded-pill px-2" style="font-size: 0.7rem;">Pendente (Incompleto)</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-light rounded-2 me-1" title="Editar Cargo"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-sm btn-outline-danger rounded-2" title="Excluir Acesso"><i class="bi bi-trash"></i></button>
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
<div class="modal fade" id="modalNovoPalestrante" tabindex="-1" aria-labelledby="modalNovoPalestranteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title d-flex align-items-center" id="modalNovoPalestranteLabel">
                    <i class="bi bi-mic-fill text-primary me-2"></i> Criar Acesso para Palestrante
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Email --}}
                        <div class="col-12">
                            <label class="form-label text-muted small">E-mail de Acesso</label>
                            <input type="email" name="email" class="form-control bg-black text-white border-secondary rounded-3" placeholder="Ex: palestrante@empresa.com" required>
                        </div>

                        {{-- Cargo --}}
                        <div class="col-12">
                            <label class="form-label text-muted small">Cargo / Especialidade Principal</label>
                            <input type="text" name="cargo" class="form-control bg-black text-white border-secondary rounded-3" placeholder="Ex: Diretor de Inovação / Palestrante UX" required>
                        </div>

                        {{-- Senha Provisória --}}
                        <div class="col-12">
                            <label class="form-label text-muted small">Senha Inicial Provisória</label>
                            <input type="password" name="password" class="form-control bg-black text-white border-secondary rounded-3" placeholder="Mínimo 8 caracteres" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light rounded-3" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4">Liberar Acesso</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection