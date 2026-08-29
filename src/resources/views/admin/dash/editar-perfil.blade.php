@extends('layout.admin')

@section('title', 'Perfil')
@section('pg-titulo', 'Perfil')
@section('link-topo', 'Perfil')

@section('content')

    @php
        $nomePerfil = trim($perfil->nome_usuario ?? 'Usuário');

        $partesNome = preg_split('/\s+/', $nomePerfil);

        $inicial1 = mb_substr($partesNome[0] ?? '', 0, 1);
        $inicial2 = isset($partesNome[1])
            ? mb_substr($partesNome[1], 0, 1)
            : mb_substr($partesNome[0] ?? '', 1, 1);

        $iniciaisPerfil = strtoupper($inicial1 . $inicial2);

        $fotoPerfilPath = !empty($perfil->foto_usuario)
            ? 'dash/assets/img/' . $perfil->foto_usuario
            : null;

        $fotoPerfilExiste = $fotoPerfilPath
            && file_exists(public_path($fotoPerfilPath));

        $statusPerfil = strtoupper(trim($perfil->status_usuario ?? ''));
    @endphp


    <main class="app-main admin-standard-main profile-admin-main">

        <div class="app-content container-fluid admin-standard-content">

            <div class="admin-standard-page">

                <section class="admin-standard-panel profile-panel">

                    {{-- =========================================================
                    CABEÇALHO
                    ========================================================== --}}
                    <header class="admin-standard-panel-header">

                        <div class="admin-standard-heading">

                            <span class="admin-standard-heading-icon">
                                <i class="bi bi-person"></i>
                            </span>

                            <div class="admin-standard-heading-copy">
                                <h2 class="admin-standard-title">
                                    Informações do Perfil
                                </h2>

                                <p class="admin-standard-description">
                                    Atualize seus dados pessoais e a foto exibida no painel.
                                </p>
                            </div>

                        </div>

                    </header>


                    {{-- =========================================================
                    CONTEÚDO
                    ========================================================== --}}
                    <div class="profile-panel-body">

                        <form method="POST" enctype="multipart/form-data" class="profile-layout">
                            @method('PUT')
                            @csrf


                            {{-- =================================================
                            COLUNA DE IDENTIDADE
                            ================================================== --}}
                            <aside class="profile-identity-card">

                                <div class="profile-avatar-wrap">

                                    @if ($fotoPerfilExiste)

                                        <img src="{{ asset($fotoPerfilPath) }}" alt="{{ $nomePerfil }}" class="profile-avatar"
                                            id="profileAvatarPreview">

                                    @else

                                        <div class="profile-avatar-fallback" id="profileAvatarFallback"
                                            aria-label="{{ $nomePerfil }}">
                                            {{ $iniciaisPerfil }}
                                        </div>

                                        <img src="" alt="{{ $nomePerfil }}" class="profile-avatar d-none"
                                            id="profileAvatarPreview">

                                    @endif


                                    <div class="profile-identity-copy">

                                        <strong>
                                            {{ $nomePerfil }}
                                        </strong>

                                        <span>
                                            {{ $perfil->email_usuario }}
                                        </span>

                                    </div>

                                </div>


                                <div class="profile-meta-list">

                                    <div class="profile-meta-item">
                                        <span>Perfil</span>

                                        <strong>
                                            {{ $perfil->perfil_usuario ?? 'Não informado' }}
                                        </strong>
                                    </div>


                                    @if (!empty($perfil->area_atuacao_usuario))
                                        <div class="profile-meta-item">
                                            <span>Área de Atuação</span>

                                            <strong>
                                                {{ $perfil->area_atuacao_usuario }}
                                            </strong>
                                        </div>
                                    @endif


                                    @if (!empty($perfil->estado_usuario))
                                        <div class="profile-meta-item">
                                            <span>Estado</span>

                                            <strong>
                                                {{ $perfil->estado_usuario }}
                                            </strong>
                                        </div>
                                    @endif


                                    <div class="profile-meta-item">
                                        <span>Status</span>

                                        <strong class="profile-status {{ $statusPerfil === 'ATIVO' ? 'is-active' : '' }}">
                                            {{ $perfil->status_usuario ?? 'Não informado' }}
                                        </strong>
                                    </div>

                                </div>


                                <div class="profile-photo-field">

                                    <label class="form-label" for="foto_usuario">
                                        Alterar Foto
                                    </label>

                                    <input type="file" class="form-control" name="foto_usuario" id="foto_usuario"
                                        accept="image/*">

                                </div>

                            </aside>


                            {{-- =================================================
                            FORMULÁRIO
                            ================================================== --}}
                            <section class="profile-form-card">

                                <div class="profile-form-heading">

                                    <strong>
                                        Dados da Conta
                                    </strong>

                                    <span>
                                        Mantenha seu nome e e-mail atualizados.
                                    </span>

                                </div>


                                <div class="profile-form-grid">

                                    {{-- SUCESSO --}}
                                    @if (session('success'))

                                        <div class="alert profile-alert profile-alert--success" role="alert">
                                            <i class="bi bi-check-circle me-1"></i>
                                            {{ session('success') }}
                                        </div>

                                    @endif


                                    {{-- ERROS --}}
                                    @if ($errors->any())

                                        <div class="alert alert-danger alert-dismissible fade show profile-alert" role="alert">
                                            <strong>ATENÇÃO:</strong>
                                            verifique os campos do formulário.

                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Fechar"></button>
                                        </div>

                                    @endif


                                    {{-- NOME --}}
                                    <div class="profile-field profile-field--full">

                                        <label class="form-label" for="nome_usuario">
                                            Nome Completo
                                        </label>

                                        <input type="text" class="form-control" name="nome_usuario" id="nome_usuario"
                                            value="{{ $perfil->nome_usuario }}">

                                    </div>


                                    {{-- E-MAIL --}}
                                    <div class="profile-field profile-field--full">

                                        <label class="form-label" for="email_usuario">
                                            E-mail
                                        </label>

                                        <input type="email" class="form-control" name="email_usuario" id="email_usuario"
                                            value="{{ $perfil->email_usuario }}">

                                    </div>


                                    {{-- AÇÕES --}}
                                    <div class="profile-form-actions">

                                        <button type="reset" class="admin-secondary-action">
                                            Cancelar Alterações
                                        </button>

                                        <button type="submit" class="admin-primary-action">
                                            <i class="bi bi-check2-circle"></i>
                                            Salvar Alterações
                                        </button>

                                    </div>

                                </div>

                            </section>

                        </form>

                    </div>

                </section>

            </div>

        </div>

    </main>


    {{-- =============================================================
    PRÉVIA LOCAL DA NOVA FOTO
    Não altera o backend; apenas mostra a imagem escolhida antes de salvar.
    ============================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const inputFoto = document.getElementById('foto_usuario');
            const preview = document.getElementById('profileAvatarPreview');
            const fallback = document.getElementById('profileAvatarFallback');

            if (!inputFoto || !preview) {
                return;
            }

            inputFoto.addEventListener('change', () => {

                const arquivo = inputFoto.files?.[0];

                if (!arquivo) {
                    return;
                }

                const urlTemporaria = URL.createObjectURL(arquivo);

                preview.src = urlTemporaria;
                preview.classList.remove('d-none');

                if (fallback) {
                    fallback.classList.add('d-none');
                }

                preview.onload = () => {
                    URL.revokeObjectURL(urlTemporaria);
                };

            });

        });
    </script>

@endsection