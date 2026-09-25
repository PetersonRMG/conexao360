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


                        <button
                            type="button"
                            class="admin-primary-action"
                            data-bs-toggle="modal"
                            data-bs-target="#modalNovoPalestrante"
                        >
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

                                                    <button
                                                        type="button"
                                                        class="admin-icon-action"
                                                        title="Editar Palestrante"
                                                        aria-label="Editar {{ $item->email_usuario }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editarPalestrante{{ $item->id_usuario }}"
                                                    >
                                                        <i class="bi bi-pencil"></i>
                                                    </button>

                                                </div>

                                            </td>


                                            {{-- STATUS --}}
                                            <td class="speaker-status-cell">

                                                @if ($item->status_usuario === 'ATIVO')

                                                    <form
                                                        action="{{ route('admin.palestrante.desativar', $item->id_usuario) }}"
                                                        method="POST"
                                                        class="speaker-status-form"
                                                    >
                                                        @csrf
                                                        @method('PATCH')

                                                        <div class="speaker-status-wrap">

                                                            <div class="form-check form-switch m-0">

                                                                <input
                                                                    class="form-check-input speaker-status-switch"
                                                                    type="checkbox"
                                                                    role="switch"
                                                                    checked
                                                                    aria-label="Desativar palestrante"
                                                                    onchange="this.form.submit()"
                                                                >

                                                            </div>

                                                            <span class="speaker-status-label is-active">
                                                                Ativo
                                                            </span>

                                                        </div>

                                                    </form>

                                                @else

                                                    <form
                                                        action="{{ route('admin.palestrante.ativar', $item->id_usuario) }}"
                                                        method="POST"
                                                        class="speaker-status-form"
                                                    >
                                                        @csrf
                                                        @method('PATCH')

                                                        <div class="speaker-status-wrap">

                                                            <div class="form-check form-switch m-0">

                                                                <input
                                                                    class="form-check-input speaker-status-switch"
                                                                    type="checkbox"
                                                                    role="switch"
                                                                    aria-label="Ativar palestrante"
                                                                    onchange="this.form.submit()"
                                                                >

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

 


    {{-- MODAIS DE VISUALIZAÇÃO / EDIÇÃO --}}
    @include('admin.modal.visualizar-palestrante', [
        'palestrante' => $palestrante
    ])

@endsection