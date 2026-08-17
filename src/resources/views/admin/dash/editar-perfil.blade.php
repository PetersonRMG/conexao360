@extends('layout.admin')
@section('title', 'Depoimentos | ')
@section('pg-titulo', 'Perfil')
@section('link-topo', 'Perfil')

@section('content')
        <!-- Container Isolado e Customizado -->
        <div class="app-main"
            style="  min-height: 100vh; padding: 2rem 1.5rem; font-family: 'Source Sans 3', sans-serif;">

            <!-- Título e Topo da Página -->
            <div
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h3
                        style="font-family: 'Cinzel', serif; color: #dfcaa0; letter-spacing: 1px; font-weight: 600; margin: 0 0 0.25rem 0; font-size: 1.75rem;">
                       Editar Perfil
                    </h3>
                    <p style="color: #94a3b8; margin: 0; font-size: 0.9rem;">Gerencie e publique os feedbacks dos membros na
                        Landing Page.</p>
                </div>
            </div>

            <!-- Bloco Principal (Card de Moderação) -->
          <div>


    <!--end::Sidebar-->
    <main class="app-main" id="main" tabindex="-1">
    <div class="app-content-header">
        <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            <h3 class="mb-0">Configurações</h3>
            </div>

        </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
        <div class="row g-3">
            <!-- Left rail -->
            <div class="col-md-3">
            <div class="list-group list-group-flush nav nav-pills flex-column" id="settings-nav" role="tablist" aria-label="Navigation 18">
                <a href="#account" class="list-group-item list-group-item-action active" data-bs-toggle="pill" role="tab" aria-selected="true">
                <i class="bi bi-person me-2" aria-hidden="true"></i>Perfil
                </a>
                <a href="#notifications" class="list-group-item list-group-item-action" data-bs-toggle="pill" role="tab" aria-selected="false" tabindex="-1">
                <i class="bi bi-bell me-2" aria-hidden="true"></i>Notifications
                </a>
                <a href="#security" class="list-group-item list-group-item-action" data-bs-toggle="pill" role="tab" aria-selected="false" tabindex="-1">
                <i class="bi bi-shield-lock me-2" aria-hidden="true"></i>Security
                </a>
                <a href="#billing" class="list-group-item list-group-item-action" data-bs-toggle="pill" role="tab" aria-selected="false" tabindex="-1">
                <i class="bi bi-credit-card me-2" aria-hidden="true"></i>Billing
                </a>
                <a href="#danger" class="list-group-item list-group-item-action text-danger" data-bs-toggle="pill" role="tab" aria-selected="false" tabindex="-1">
                <i class="bi bi-exclamation-triangle me-2" aria-hidden="true"></i>
                Danger zone
                </a>
            </div>
            </div>

            <!-- Tab content -->
            <div class="col-md-9">
            <div class="tab-content">
                <!-- Account -->
                <form 
                {{--
                action=
                 "{{ route('admin.perfil.update', ['id' => $perfil->id_usuario]) }}"  --}}
                method="POST"     enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="tab-pane fade show active" id="account" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                        <h3 class="card-title">Conta</h3>
                        </div>
                        <div class="card-body">

                            <div  class="row g-3 col-md-12 ">

                                @if(session('success'))
                                    <div class="alert alert-sucess" role="alert">
                                    {{ session('success') }} 

                                    </div>

                                @endif 
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>ATENÇÃO</strong> verifique os campos do formulario !
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <div class="col-md-12 row bg-">
                                    <div class="rounded col-md-6">
                                        <img class="rounded w-25" src="{{asset('dash/assets/img/' . $perfil->foto_usuario) }}">
                                        <input type="file" class="form-control w-50" name="foto_usuario" id="foto_usuario" value="{{ $perfil->nome_usuario }}">
                                    </div>

                                    <div class="col-md-6 float-end ">
                                        <label class="form-label" for="nome_usuario"> Nome Completo </label>
                                        <input type="text" class="form-control" name="nome_usuario" id="nome_usuario" value="{{ $perfil->nome_usuario }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="email_usuario"> Email </label>
                                    <input type="email" class="form-control" name="email_usuario" id="email_usuario" value="{{ $perfil->email_usuario }}">
                                </div>
                                <div class="col-md-6">

                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Salvar </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    </div>
                </form>

                <!-- Notifications -->
                <div class="tab-pane fade" id="notifications" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">Notifications</h3>
                    </div>
                    <div class="card-body">
                    <p class="text-secondary">Choose what to be notified about.</p>
                    <div class="d-flex justify-content-between align-items-start py-2 border-bottom">
                        <div>
                        <p class="mb-0 fw-semibold">Product updates</p>
                        <small class="text-secondary">Major releases and changelogs</small>
                        </div>
                        <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" role="switch" id="notif-0" checked="">
                        <label class="visually-hidden" for="notif-0">
                            Toggle Product updates
                        </label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-start py-2 border-bottom">
                        <div>
                        <p class="mb-0 fw-semibold">Security alerts</p>
                        <small class="text-secondary">Sign-in attempts and account changes</small>
                        </div>
                        <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" role="switch" id="notif-1" checked="">
                        <label class="visually-hidden" for="notif-1">
                            Toggle Security alerts
                        </label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-start py-2 border-bottom">
                        <div>
                        <p class="mb-0 fw-semibold">Weekly digest</p>
                        <small class="text-secondary">A summary of activity in your workspace</small>
                        </div>
                        <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" role="switch" id="notif-2">
                        <label class="visually-hidden" for="notif-2">
                            Toggle Weekly digest
                        </label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-start py-2 border-bottom">
                        <div>
                        <p class="mb-0 fw-semibold">Mentions</p>
                        <small class="text-secondary">When a teammate @mentions you</small>
                        </div>
                        <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" role="switch" id="notif-3">
                        <label class="visually-hidden" for="notif-3"> Toggle Mentions </label>
                        </div>
                    </div>
                    <button class="btn btn-primary mt-3">Save preferences</button>
                    </div>
                </div>
                </div>

                <!-- Security -->
                <div class="tab-pane fade" id="security" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">Password</h3>
                    </div>
                    <div class="card-body">
                    <form class="row g-3">
                        <div class="col-md-12">
                        <label class="form-label" for="pwd-current"> Current password </label>
                        <input type="password" class="form-control"  name="senha_usuario" id="senha_usuario" value="{{ $perfil->senha_usuario }}">
                        </div>
                        <div class="col-md-6">
                        <label class="form-label" for="pwd-new"> New password </label>
                        <input type="password" class="form-control" id="pwd-new">
                        </div>
                        <div class="col-md-6">
                        <label class="form-label" for="pwd-confirm">
                            Confirm new password
                        </label>
                        <input type="password" class="form-control" id="pwd-confirm">
                        </div>
                        <div class="col-12">
                        <button type="submit" class="btn btn-primary">Update password</button>
                        </div>
                    </form>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                    <h3 class="card-title">Two-factor authentication</h3>
                    </div>
                    <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-0 fw-semibold">Authenticator app</p>
                        <small class="text-secondary">
                        Use an authenticator app such as 1Password or Authy.
                        </small>
                    </div>
                    <button class="btn btn-outline-primary">Enable</button>
                    </div>
                </div>
                </div>

                <!-- Billing -->
                <div class="tab-pane fade" id="billing" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">Current plan</h3>
                    </div>
                    <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                        <p class="mb-0 fw-semibold">Pro plan</p>
                        <small class="text-secondary">
                            $29 / month · Renews June 18, 2026
                        </small>
                        </div>
                        <a href="#" class="btn btn-outline-primary btn-sm"> Change plan </a>
                    </div>
                    <hr>
                    <p class="fw-semibold mb-2">Payment method</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                        <i class="bi bi-credit-card-2-front me-2" aria-hidden="true"></i>
                        Visa ending in 4242
                        </div>
                        <a href="#" class="btn btn-link btn-sm">Update</a>
                    </div>
                    </div>
                </div>
                </div>

                <!-- Danger zone -->
                <div class="tab-pane fade" id="danger" role="tabpanel">
                <div class="card border-danger">
                    <div class="card-header bg-danger-subtle">
                    <h3 class="card-title text-danger">Danger zone</h3>
                    </div>
                    <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                        <p class="mb-0 fw-semibold">Export account data</p>
                        <small class="text-secondary">
                            Download a copy of all your data as a ZIP archive.
                        </small>
                        </div>
                        <button class="btn btn-outline-secondary">Export</button>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                        <p class="mb-0 fw-semibold text-danger">Delete account</p>
                        <small class="text-secondary">
                            This will permanently delete your account and all associated data.
                            This cannot be undone.
                        </small>
                        </div>
                        <button class="btn btn-danger">Delete account</button>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </main>



    <div id="live-region" class="live-region" aria-live="polite" aria-atomic="true" role="status"></div></div>
        </div>



        <!-- Estilos e Efeitos Interativos Compartilhados -->
        <style>
            /* Forçar reset de listas para as abas */
            #customDepTabs li {
                list-style-type: none !important;
            }

            #customDepTabs li::before {
                content: "" !important;
                display: none !important;
            }

            /* Hovers dos Cards */
            .dep-card:hover {
                border-color: rgba(223, 202, 160, 0.3) !important;
                transform: translateY(-2px);
            }

            /* Hovers dos Botões de Ação */
            .btn-action-reject:hover {
                background-color: rgba(239, 68, 68, 0.08) !important;
            }

            .btn-action-approve:hover {
                background-color: rgba(34, 197, 94, 0.08) !important;
            }
        </style>

        <!-- Script Simples para alternar entre as abas sem depender do Bootstrap JS -->
        <script>
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    // Remove classes ativas dos botões
                    document.querySelectorAll('.tab-btn').forEach(b => {
                        b.style.color = '#94a3b8';
                        b.style.borderBottom = 'none';
                        b.style.fontWeight = '500';
                    });

                    // Ativa o botão clicado
                    this.style.color = '#dfcaa0';
                    this.style.borderBottom = '2px solid #dfcaa0';
                    this.style.fontWeight = '600';

                    // Esconde todos os painéis de conteúdo
                    document.querySelectorAll('.tab-content-panel').forEach(panel => {
                        panel.style.display = 'none';
                    });

                    // Mostra o painel correto
                    const target = this.getAttribute('data-target');
                    const targetPanel = document.querySelector(target);
                    if (targetPanel) {
                        if (target === '#pendentes') {
                            targetPanel.style.display = 'grid';
                        } else {
                            targetPanel.style.display = 'block';
                        }
                    }
                });
            });
        </script>
@endsection