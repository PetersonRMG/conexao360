@extends('layout.admin')
@section('title', 'Depoimentos | ')
@section('pg-titulo', 'Depoimentos')
@section('link-topo', 'Depoimentos')

@section('content')
    <!-- Container Isolado e Customizado -->
    <div
        style="background-color: #0d0f14; min-height: 100vh; padding: 2rem 1.5rem; font-family: 'Source Sans 3', sans-serif;">

        <!-- Título e Topo da Página -->
        <div
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h3
                    style="font-family: 'Cinzel', serif; color: #dfcaa0; letter-spacing: 1px; font-weight: 600; margin: 0 0 0.25rem 0; font-size: 1.75rem;">
                    Moderação de Depoimentos
                </h3>
                <p style="color: #94a3b8; margin: 0; font-size: 0.9rem;">Gerencie e publique os feedbacks dos membros na
                    Landing Page.</p>
            </div>
        </div>

        <!-- Bloco Principal (Card de Moderação) -->
        <div
            style="background-color: #11141a; border: 1px solid #1e2330; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.25);">

            <!-- Menu de Abas (Customizado para não quebrar em formato de lista) -->
            <div style="background-color: #0d0f14; border-bottom: 1px solid #1e2330; padding: 0 1rem;">
                <ul id="customDepTabs"
                    style="list-style: none !important; padding: 0; margin: 0; display: flex; gap: 1.5rem;">
                    <li style="margin: 0;">
                        <button class="tab-btn active" data-target="#pendentes"
                            style="background: transparent; border: none; color: #dfcaa0; padding: 1.2rem 1rem; font-weight: 600; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; position: relative; border-bottom: 2px solid #dfcaa0;">
                            <i class="bi bi-clock-history" style="color: #ffc107;"></i> Pendentes
                            <span
                                style="background-color: rgba(255, 193, 7, 0.15); color: #ffc107; font-size: 0.75rem; padding: 0.15rem 0.5rem; border-radius: 10px; font-weight: 700;">
                                {{$depoimentosPend->count()  }}</span>
                        </button>
                    </li>
                    <li style="margin: 0;">
                        <button class="tab-btn" data-target="#aprovados"
                            style="background: transparent; border: none; color: #94a3b8; padding: 1.2rem 1rem; font-weight: 500; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="bi bi-check-circle-fill" style="color: #28a745;"></i> Aprovados
                            <span
                                style="background-color: rgba(40, 167, 69, 0.15); color: #28a745; font-size: 0.75rem; padding: 0.15rem 0.5rem; border-radius: 10px; font-weight: 700;">
                                {{$depoimentosAceitos->count()  }}</span>
                        </button>
                    </li>

                    <li style="margin: 0;">
                        <button class="tab-btn" data-target="#reprovados"
                            style="background: transparent; border: none; color: #94a3b8; padding: 1.2rem 1rem; font-weight: 500; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="bi bi-x-circle-fill" style="color: #af3f3fff;"></i>Reprovados
                            <span
                                style="background-color: rgba(40, 167, 69, 0.15); color: #af3f3fff; font-size: 0.75rem; padding: 0.15rem 0.5rem; border-radius: 10px; font-weight: 700;">{{$depoimentosRegei->count()  }}</span></span>
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Área de Conteúdo das Abas -->
            <div style="padding: 2rem;">

                <!-- CONTEÚDO: PENDENTES -->
                <div id="pendentes" class="tab-content-panel active"
                    style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">

                    @forelse ($depoimentosPend as $item)
                        <!-- Card 1 -->
                        <div class="dep-card"
                            style="background-color: #161a23; border: 1px solid #262d3d; border-radius: 10px; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; transition: transform 0.2s, border-color 0.2s;">
                            <div style="padding: 1.5rem;">
                                <!-- Perfil do Autor -->
                                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                                    <img src="{{ asset('dash/assets/img/' . $item->usuario->foto_usuario) }}"
                                        style="width: 48px; height: 48px; object-fit: cover; border-radius: 50%; border: 1px solid #dfcaa0;"
                                        alt="Avatar">
                                    <div>
                                        <h5
                                            style="color: #ffffff; margin: 0 0 0.15rem 0; font-size: 0.95rem; font-weight: 600;">
                                            {{ $item->usuario->nome_usuario }}
                                        </h5>
                                        <small
                                            style="color: #94a3b8; font-size: 0.78rem;">{{ $item->usuario->areat_atuacao_usuario }}
                                            • {{ $item->usuario->estado_usuario }}</small>
                                    </div>
                                </div>
                                <!-- Texto do Depoimento -->
                                <p style="color: #cbd5e1; font-size: 0.88rem; line-height: 1.5; font-style: italic; margin: 0;">
                                    "{{ $item->descricao_depoimento }}"
                                </p>
                            </div>

                            <!-- Rodapé do Card -->
                            <div>
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; padding: 0 1.5rem 1rem 1.5rem; font-size: 0.75rem;">
                                    <span
                                        style="background-color: rgba(148, 163, 184, 0.1); color: #94a3b8; padding: 0.25rem 0.6rem; border-radius: 4px; font-weight: 500;">
                                        @if($item->usuario->perfil_usuario === 'palestrante')
                                            Logado
                                        @else
                                            Via Landing Page
                                        @endif
                                    </span>
                                    <span style="color: #64748b;">{{ $item->criado_em_depoimento }}</span>
                                </div>
                                <!-- Ações -->
                                <div style="display: flex; border-top: 1px solid #262d3d;">
                                    <form action="{{ route('admin.depoimentos.recusar', $item->id_depoimentos) }}" method="POST"
                                        enctype="multipart/form-data">

                                        @csrf
                                        @method('PUT')
                                        <button class="btn-action-reject" type="submit"
                                            style="width: 50%; background: transparent; border: none; padding: 0.8rem; color: #ef4444; font-weight: 600; font-size: 0.85rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                            <i class="bi bi-x-lg"></i> Recusar
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.depoimentos.aceitar', $item->id_depoimentos) }}" method="POST"
                                        enctype="multipart/form-data">

                                        @csrf
                                        @method('PUT')
                                        <button class="btn-action-approve" type="submit"
                                            style="width: 50%; background: transparent; border: none; border-left: 1px solid #262d3d; padding: 0.8rem; color: #22c55e; font-weight: 600; font-size: 0.85rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                            <i class="bi bi-check-lg"></i> Aprovar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty

                        <div class="text-center py-5">
                            <i class="bi bi-chat-square-text fs-1 text-secondary"></i>
                            <h5 class="mt-3 text-secondary">
                                Nenhum depoimento pendente.
                            </h5>
                        </div>

                    @endforelse




                </div>

                <!-- CONTEÚDO: APROVADOS (Escondido por padrão) -->

                <div id="aprovados" class="tab-content-panel" style="display: none;">
                    @forelse ($depoimentosAceitos as $item)

                        <!-- Card 1 -->
                        <div class="dep-card"
                            style="background-color: #161a23; border: 1px solid #262d3d; border-radius: 10px; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; transition: transform 0.2s, border-color 0.2s;">
                            <div style="padding: 1.5rem;">
                                <!-- Perfil do Autor -->
                                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                                    <img src="{{ asset('dash/assets/img/' . $item->usuario->foto_usuario) }}"
                                        style="width: 48px; height: 48px; object-fit: cover; border-radius: 50%; border: 1px solid #dfcaa0;"
                                        alt="Avatar">
                                    <div>
                                        <h5
                                            style="color: #ffffff; margin: 0 0 0.15rem 0; font-size: 0.95rem; font-weight: 600;">
                                            {{ $item->usuario->nome_usuario }}
                                        </h5>
                                        <small
                                            style="color: #94a3b8; font-size: 0.78rem;">{{ $item->usuario->areat_atuacao_usuario }}
                                            • {{ $item->usuario->estado_usuario }}</small>
                                    </div>
                                </div>
                                <!-- Texto do Depoimento -->
                                <p style="color: #cbd5e1; font-size: 0.88rem; line-height: 1.5; font-style: italic; margin: 0;">
                                    "{{ $item->descricao_depoimento }}"
                                </p>
                            </div>
                            <!-- Rodapé do Card -->
                            <div>
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; padding: 0 1.5rem 1rem 1.5rem; font-size: 0.75rem;">
                                    <span
                                        style="background-color: rgba(148, 163, 184, 0.1); color: #94a3b8; padding: 0.25rem 0.6rem; border-radius: 4px; font-weight: 500;">
                                        @if($item->usuario->perfil_usuario === 'palestrante')
                                            Logado
                                        @else
                                            Via Landing Page
                                        @endif
                                    </span>
                                    <span style="color: #64748b;">{{ $item->criado_em_depoimento }}</span>
                                    <form action="{{ route('admin.depoimentos.recusar', $item->id_depoimentos) }}" method="POST"
                                        enctype="multipart/form-data">

                                        @csrf
                                        @method('PUT')
                                        <button class="btn-action-reject" type="submit"
                                            style="width: 50%; background: transparent; border: none; padding: 0.8rem; color: #ef4444; font-weight: 600; font-size: 0.85rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                            <i class="bi bi-x-lg"></i> Recusar
                                        </button>
                                    </form>
                                </div>
                                <!-- Ações -->

                            </div>
                        </div>

                    @empty
                        <p style="color: #94a3b8; font-size: 0.9rem; margin: 0;">

                            Não há depoimentos aprovados exibidos no
                            momento.</p>

                    @endforelse
                </div>

                <div id="reprovados" class="tab-content-panel" style="display: none;">
                    @forelse ($depoimentosRegei as $item)

                        <!-- Card 1 -->
                        <div class="dep-card"
                            style="background-color: #161a23; border: 1px solid #262d3d; border-radius: 10px; display: flex; flex-direction: column; justify-content: space-between; overflow: hidden; transition: transform 0.2s, border-color 0.2s;">
                            <div style="padding: 1.5rem;">
                                <!-- Perfil do Autor -->
                                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem;">
                                    <img src="{{ asset('dash/assets/img/' . $item->usuario->foto_usuario) }}"
                                        style="width: 48px; height: 48px; object-fit: cover; border-radius: 50%; border: 1px solid #dfcaa0;"
                                        alt="Avatar">
                                    <div>
                                        <h5
                                            style="color: #ffffff; margin: 0 0 0.15rem 0; font-size: 0.95rem; font-weight: 600;">
                                            {{ $item->usuario->nome_usuario }}
                                        </h5>
                                        <small
                                            style="color: #94a3b8; font-size: 0.78rem;">{{ $item->usuario->areat_atuacao_usuario }}
                                            • {{ $item->usuario->estado_usuario }}</small>
                                    </div>
                                </div>
                                <!-- Texto do Depoimento -->
                                <p style="color: #cbd5e1; font-size: 0.88rem; line-height: 1.5; font-style: italic; margin: 0;">
                                    "{{ $item->descricao_depoimento }}"
                                </p>
                            </div>
                            <!-- Rodapé do Card -->
                            <div>
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; padding: 0 1.5rem 1rem 1.5rem; font-size: 0.75rem;">
                                    <span
                                        style="background-color: rgba(148, 163, 184, 0.1); color: #94a3b8; padding: 0.25rem 0.6rem; border-radius: 4px; font-weight: 500;">
                                        @if($item->usuario->perfil_usuario === 'palestrante')
                                            Logado
                                        @else
                                            Via Landing Page
                                        @endif
                                    </span>
                                    <span style="color: #64748b;">{{ $item->criado_em_depoimento }}</span>
                                    <form action="{{ route('admin.depoimentos.aceitar', $item->id_depoimentos) }}" method="POST"
                                        enctype="multipart/form-data">

                                        @csrf
                                        @method('PUT')
                                        <button class="btn-action-approve" type="submit"
                                            style="width: 50%; background: transparent; border: none; border-left: 1px solid #262d3d; padding: 0.8rem; color: #22c55e; font-weight: 600; font-size: 0.85rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                            <i class="bi bi-check-lg"></i> Aprovar
                                        </button>
                                    </form>
                                </div>
                                <!-- Ações -->
                            </div>


                        </div>

                    @empty
                        <p style="color: #94a3b8; font-size: 0.9rem; margin: 0;">

                            Não há depoimentos reprovados exibidos no
                            momento.</p>

                    @endforelse
                </div>


            </div>
        </div>
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