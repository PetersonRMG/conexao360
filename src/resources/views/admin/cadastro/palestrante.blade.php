@extends('layout.admin')

@section('title', 'Gerenciamento de Palestrantes')
@section('pg-titulo', 'Gerenciamento de Palestrantes')
@section('link-topo', 'Gerenciamento de Palestrantes')

@section('content')

    <main class="app-main admin-standard-main speaker-admin-main">

        <div class="app-content container-fluid admin-standard-content">

            <div class="admin-standard-page">

                {{-- =========================================================
                PAINEL PRINCIPAL
                ========================================================== --}}
                <section class="admin-standard-panel speaker-panel">

                    <header class="admin-standard-panel-header">

                        <div class="admin-standard-heading">

                            <span class="admin-standard-heading-icon">
                                <i class="bi bi-mic"></i>
                            </span>

                            <div class="admin-standard-heading-copy">
                                <h2 class="admin-standard-title">
                                    Contas de Palestrantes
                                </h2>

                                <p class="admin-standard-description">
                                    Gerencie os acessos, áreas de atuação e status dos palestrantes.
                                </p>
                            </div>

                        </div>

                        <button type="button" class="admin-primary-action" data-bs-toggle="modal"
                            data-bs-target="#modalNovoPalestrante">
                            <i class="bi bi-plus-circle"></i>
                            Pré-Cadastrar Palestrante
                        </button>

                    </header>


                    <div class="speaker-panel-body">

                        <div class="speaker-table-wrap">

                            <table class="speaker-table">

                                <thead>
                                    <tr>
                                        <th>E-mail de Acesso</th>
                                        <th>Cargo / Função</th>
                                        <th>Perfil do Usuário</th>
                                        <th class="text-end">Editar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse ($palestrante as $item)

                                        <tr>

                                            {{-- E-MAIL --}}
                                            <td>
                                                <div class="speaker-email">
                                                    <span class="speaker-email-icon">
                                                        <i class="bi bi-envelope"></i>
                                                    </span>

                                                    <span>
                                                        {{ $item->email_usuario }}
                                                    </span>
                                                </div>
                                            </td>


                                            {{-- ÁREA --}}
                                            <td>
                                                <span class="speaker-badge">
                                                    {{ $item->area_atuacao_usuario ?: 'Não informado' }}
                                                </span>
                                            </td>


                                            {{-- PERFIL --}}
                                            <td>
                                                <span class="speaker-badge speaker-badge--profile">
                                                    {{ $item->perfil_usuario }}
                                                </span>
                                            </td>


                                            {{-- EDITAR --}}
                                            <td>
                                                <div class="speaker-actions">

                                                    <button type="button" class="admin-icon-action" title="Editar Palestrante"
                                                        aria-label="Editar {{ $item->email_usuario }}" data-bs-toggle="modal"
                                                        data-bs-target="#editarPalestrante{{ $item->id_usuario }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>

                                                    @include(
                                                        'admin.modal.editar-palestrante',
                                                        ['palestrante' => $item]
                                                    )

                                                </div>
                                            </td>


                                            {{-- STATUS --}}
                                            <td class="speaker-status-cell">

                                                @if ($item->status_usuario === 'ATIVO')

                                                    <form action="{{ route('admin.palestrante.desativar', $item->id_usuario) }}"
                                                        method="POST" class="speaker-status-form">
                                                        @csrf
                                                        @method('PATCH')

                                                        <div class="speaker-status-wrap">

                                                            <div class="form-check form-switch m-0">
                                                                <input class="form-check-input speaker-status-switch"
                                                                    type="checkbox" role="switch" checked
                                                                    aria-label="Desativar palestrante"
                                                                    onchange="this.form.submit()">
                                                            </div>

                                                            <span class="speaker-status-label is-active">
                                                                Ativo
                                                            </span>

                                                        </div>

                                                    </form>

                                                @else

                                                    <form action="{{ route('admin.palestrante.ativar', $item->id_usuario) }}"
                                                        method="POST" class="speaker-status-form">
                                                        @csrf
                                                        @method('PATCH')

                                                        <div class="speaker-status-wrap">

                                                            <div class="form-check form-switch m-0">
                                                                <input class="form-check-input speaker-status-switch"
                                                                    type="checkbox" role="switch" aria-label="Ativar palestrante"
                                                                    onchange="this.form.submit()">
                                                            </div>

                                                            <span class="speaker-status-label">
                                                                Inativo
                                                            </span>

                                                        </div>

                                                    </form>

                                                @endif

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>
                                            <td colspan="5" class="speaker-empty">

                                                <span class="speaker-empty-icon">
                                                    <i class="bi bi-mic"></i>
                                                </span>

                                                <strong>
                                                    Nenhum palestrante cadastrado.
                                                </strong>

                                                <span>
                                                    Os palestrantes pré-cadastrados aparecerão aqui.
                                                </span>

                                            </td>
                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </section>

            </div>

        </div>

    </main>


    {{-- =============================================================
    MODAL — PRÉ-CADASTRO DE PALESTRANTE
    ============================================================== --}}
    <div class="modal modal-lg fade admin-modal-shell" id="modalNovoPalestrante" tabindex="-1"
        aria-labelledby="modalNovoPalestranteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

            <div class="modal-content admin-modal">

                <div class="modal-header admin-modal-header">

                    <div class="admin-modal-heading">

                        <span class="admin-modal-title-icon">
                            <i class="bi bi-person-plus-fill"></i>
                        </span>

                        <div class="admin-modal-title-copy">
                            <h5 class="modal-title admin-modal-title" id="modalNovoPalestranteLabel">
                                Pré-Cadastrar Palestrante
                            </h5>

                            <p class="admin-modal-subtitle">
                                Cadastre os dados de acesso e as informações iniciais do palestrante.
                            </p>
                        </div>

                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>

                </div>


                <form action="{{ route('admin.palestrante.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')


                    <div class="modal-body">

                        <div class="row g-3">

                            <div class="col-12 col-md-6">
                                <label class="form-label" for="nome_usuario">
                                    Nome Completo
                                </label>

                                <input type="text" name="nome_usuario" id="nome_usuario" class="form-control" required>
                            </div>


                            <div class="col-12 col-md-6">
                                <label class="form-label" for="email_usuario">
                                    E-mail
                                </label>

                                <input type="email" name="email_usuario" id="email_usuario" class="form-control" required>
                            </div>


                            <div class="col-12">
                                <label class="form-label" for="foto_usuario">
                                    Foto do Usuário
                                </label>

                                <input type="file" name="foto_usuario" id="foto_usuario" class="form-control"
                                    accept="image/*" required>
                            </div>


                            <div class="col-12 col-md-6">
                                <label class="form-label" for="area_atuacao_usuario">
                                    Área de Atuação
                                </label>

                                <input type="text" name="area_atuacao_usuario" id="area_atuacao_usuario"
                                    class="form-control" required>
                            </div>


                            <div class="col-12 col-md-6">
                                <label class="form-label" for="perfil_usuario">
                                    Perfil
                                </label>

                                <input type="text" name="perfil_usuario" id="perfil_usuario" class="form-control"
                                    value="palestrante" required>
                            </div>


                            <div class="col-12 col-md-6">
                                <label class="form-label" for="senha_usuario">
                                    Senha
                                </label>

                                <input type="password" name="senha_usuario" id="senha_usuario" class="form-control"
                                    required>
                            </div>


                            <div class="col-12 col-md-6">
                                <label class="form-label" for="estado_usuario">
                                    Estado (UF)
                                </label>

                                <input type="text" name="estado_usuario" id="estado_usuario" class="form-control"
                                    maxlength="2" required>
                            </div>


                            <div class="col-12">
                                <label class="form-label" for="sobre_usuario">
                                    Sobre o Usuário
                                </label>

                                <textarea name="sobre_usuario" id="sobre_usuario" class="form-control" rows="4"
                                    required></textarea>
                            </div>


                            <div class="col-12 col-md-6">
                                <label class="form-label" for="status_usuario">
                                    Status do Palestrante
                                </label>

                                <select class="form-select" name="status_usuario" id="status_usuario" required>
                                    <option value="" selected disabled>
                                        Selecione o status
                                    </option>

                                    <option value="ATIVO">
                                        Ativo
                                    </option>

                                    <option value="INATIVO">
                                        Inativo
                                    </option>
                                </select>
                            </div>


                            <div class="col-12 col-md-6 d-flex align-items-end">

                                <div class="form-check">

                                    <input type="checkbox" name="termos_usuario" value="1" class="form-check-input"
                                        id="termos_usuario">

                                    <label class="form-check-label" for="termos_usuario">
                                        Aceito os termos de uso
                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button" class="admin-secondary-action" data-bs-dismiss="modal">
                            Cancelar
                        </button>

                        <button type="submit" class="admin-primary-action">
                            <i class="bi bi-check2"></i>
                            Salvar Palestrante
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

@endsection