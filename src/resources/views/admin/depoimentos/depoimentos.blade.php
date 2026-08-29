@extends('layout.admin')

@section('title', 'Depoimentos | ')
@section('pg-titulo', 'Depoimentos')
@section('link-topo', 'Depoimentos')

@section('content')

    <main class="app-main dash-depoimentos-main">
        <div class="app-content container-fluid">
            <div class="dash-page dash-page--depoimentos">

                {{-- =========================================================
                PAINEL PRINCIPAL
                ========================================================== --}}
                <div class="dep-panel">

                    {{-- =====================================================
                    ABAS
                    ====================================================== --}}
                    <div class="dep-tabs-wrapper">

                        <div class="dep-tabs" id="customDepTabs">

                            {{-- PENDENTES --}}
                            <button type="button" class="dep-tab active" data-target="#pendentes">
                                <span class="dep-tab-icon dep-tab-icon--pending">
                                    <i class="bi bi-clock-history"></i>
                                </span>

                                <span class="dep-tab-info">
                                    <span class="dep-tab-title">
                                        Pendentes
                                    </span>

                                    <span class="dep-tab-description">
                                        Aguardando moderação
                                    </span>
                                </span>

                                <span class="dep-tab-count dep-tab-count--pending">
                                    {{ $depoimentosPend->count() }}
                                </span>
                            </button>


                            {{-- APROVADOS --}}
                            <button type="button" class="dep-tab" data-target="#aprovados">
                                <span class="dep-tab-icon dep-tab-icon--approved">
                                    <i class="bi bi-check-circle"></i>
                                </span>

                                <span class="dep-tab-info">
                                    <span class="dep-tab-title">
                                        Aprovados
                                    </span>

                                    <span class="dep-tab-description">
                                        Publicados na Landing Page
                                    </span>
                                </span>

                                <span class="dep-tab-count dep-tab-count--approved">
                                    {{ $depoimentosAceitos->count() }}
                                </span>
                            </button>


                            {{-- REPROVADOS --}}
                            <button type="button" class="dep-tab" data-target="#reprovados">
                                <span class="dep-tab-icon dep-tab-icon--rejected">
                                    <i class="bi bi-x-circle"></i>
                                </span>

                                <span class="dep-tab-info">
                                    <span class="dep-tab-title">
                                        Reprovados
                                    </span>

                                    <span class="dep-tab-description">
                                        Não publicados
                                    </span>
                                </span>

                                <span class="dep-tab-count dep-tab-count--rejected">
                                    {{ $depoimentosRegei->count() }}
                                </span>
                            </button>

                        </div>

                    </div>


                    {{-- =====================================================
                    CONTEÚDO DAS ABAS
                    ====================================================== --}}
                    <div class="dep-tabs-content">


                        {{-- =================================================
                        PENDENTES
                        ================================================== --}}
                        <section id="pendentes" class="dep-tab-panel active">

                            @forelse ($depoimentosPend as $item)

                                <article class="dep-card">

                                    {{-- Cabeçalho --}}
                                    <div class="dep-card-header">

                                        <div class="dep-author">

                                            <img src="{{ asset('dash/assets/img/' . $item->usuario->foto_usuario) }}"
                                                class="dep-avatar" alt="Avatar de {{ $item->usuario->nome_usuario }}">

                                            <div class="dep-author-info">

                                                <h5 class="dep-author-name">
                                                    {{ $item->usuario->nome_usuario }}
                                                </h5>

                                                <span class="dep-author-meta">
                                                    {{ $item->usuario->areat_atuacao_usuario }}
                                                    <span class="dep-meta-separator">•</span>
                                                    {{ $item->usuario->estado_usuario }}
                                                </span>

                                            </div>

                                        </div>


                                        <span class="dep-status-badge dep-status-badge--pending">
                                            <i class="bi bi-clock"></i>
                                            Pendente
                                        </span>

                                    </div>


                                    {{-- Depoimento --}}
                                    <div class="dep-card-content">

                                        <i class="bi bi-quote dep-quote-icon"></i>

                                        <p class="dep-quote">
                                            {{ $item->descricao_depoimento }}
                                        </p>

                                    </div>


                                    {{-- Rodapé --}}
                                    <div class="dep-card-footer">

                                        <div class="dep-card-info">

                                            <span class="dep-source">
                                                <i class="bi bi-globe2"></i>

                                                @if($item->usuario->perfil_usuario === 'palestrante')
                                                    Logado
                                                @else
                                                    Via Landing Page
                                                @endif
                                            </span>

                                            <span class="dep-date">
                                                <i class="bi bi-calendar3"></i>
                                                {{ $item->criado_em_depoimento }}
                                            </span>

                                        </div>


                                        <div class="dep-actions">

                                            <form action="{{ route('admin.depoimentos.recusar', $item->id_depoimentos) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit" class="dep-action dep-action--reject">
                                                    <i class="bi bi-x-lg"></i>
                                                    Recusar
                                                </button>
                                            </form>


                                            <form action="{{ route('admin.depoimentos.aceitar', $item->id_depoimentos) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit" class="dep-action dep-action--approve">
                                                    <i class="bi bi-check-lg"></i>
                                                    Aprovar
                                                </button>
                                            </form>

                                        </div>

                                    </div>

                                </article>

                            @empty

                                <div class="dep-empty">
                                    <div class="dep-empty-icon">
                                        <i class="bi bi-chat-square-text"></i>
                                    </div>

                                    <h5>
                                        Nenhum depoimento pendente
                                    </h5>

                                    <p>
                                        Não existem depoimentos aguardando moderação no momento.
                                    </p>
                                </div>

                            @endforelse

                        </section>



                        {{-- =================================================
                        APROVADOS
                        ================================================== --}}
                        <section id="aprovados" class="dep-tab-panel">

                            @forelse ($depoimentosAceitos as $item)

                                <article class="dep-card">

                                    <div class="dep-card-header">

                                        <div class="dep-author">

                                            <img src="{{ asset('dash/assets/img/' . $item->usuario->foto_usuario) }}"
                                                class="dep-avatar" alt="Avatar de {{ $item->usuario->nome_usuario }}">

                                            <div class="dep-author-info">

                                                <h5 class="dep-author-name">
                                                    {{ $item->usuario->nome_usuario }}
                                                </h5>

                                                <span class="dep-author-meta">
                                                    {{ $item->usuario->areat_atuacao_usuario }}
                                                    <span class="dep-meta-separator">•</span>
                                                    {{ $item->usuario->estado_usuario }}
                                                </span>

                                            </div>

                                        </div>


                                        <span class="dep-status-badge dep-status-badge--approved">
                                            <i class="bi bi-check-circle"></i>
                                            Publicado
                                        </span>

                                    </div>


                                    <div class="dep-card-content">

                                        <i class="bi bi-quote dep-quote-icon"></i>

                                        <p class="dep-quote">
                                            {{ $item->descricao_depoimento }}
                                        </p>

                                    </div>


                                    <div class="dep-card-footer">

                                        <div class="dep-card-info">

                                            <span class="dep-source">
                                                <i class="bi bi-globe2"></i>

                                                @if($item->usuario->perfil_usuario === 'palestrante')
                                                    Logado
                                                @else
                                                    Via Landing Page
                                                @endif
                                            </span>

                                            <span class="dep-date">
                                                <i class="bi bi-calendar3"></i>
                                                {{ $item->criado_em_depoimento }}
                                            </span>

                                        </div>


                                        <form action="{{ route('admin.depoimentos.recusar', $item->id_depoimentos) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')

                                            <button type="submit" class="dep-action dep-action--reject">
                                                <i class="bi bi-x-lg"></i>
                                                Retirar publicação
                                            </button>
                                        </form>

                                    </div>

                                </article>

                            @empty

                                <div class="dep-empty">
                                    <div class="dep-empty-icon">
                                        <i class="bi bi-check2-circle"></i>
                                    </div>

                                    <h5>
                                        Nenhum depoimento aprovado
                                    </h5>

                                    <p>
                                        Ainda não existem depoimentos publicados na Landing Page.
                                    </p>
                                </div>

                            @endforelse

                        </section>



                        {{-- =================================================
                        REPROVADOS
                        ================================================== --}}
                        <section id="reprovados" class="dep-tab-panel">

                            @forelse ($depoimentosRegei as $item)

                                <article class="dep-card">

                                    <div class="dep-card-header">

                                        <div class="dep-author">

                                            <img src="{{ asset('dash/assets/img/' . $item->usuario->foto_usuario) }}"
                                                class="dep-avatar" alt="Avatar de {{ $item->usuario->nome_usuario }}">

                                            <div class="dep-author-info">

                                                <h5 class="dep-author-name">
                                                    {{ $item->usuario->nome_usuario }}
                                                </h5>

                                                <span class="dep-author-meta">
                                                    {{ $item->usuario->areat_atuacao_usuario }}
                                                    <span class="dep-meta-separator">•</span>
                                                    {{ $item->usuario->estado_usuario }}
                                                </span>

                                            </div>

                                        </div>


                                        <span class="dep-status-badge dep-status-badge--rejected">
                                            <i class="bi bi-x-circle"></i>
                                            Reprovado
                                        </span>

                                    </div>


                                    <div class="dep-card-content">

                                        <i class="bi bi-quote dep-quote-icon"></i>

                                        <p class="dep-quote">
                                            {{ $item->descricao_depoimento }}
                                        </p>

                                    </div>


                                    <div class="dep-card-footer">

                                        <div class="dep-card-info">

                                            <span class="dep-source">
                                                <i class="bi bi-globe2"></i>

                                                @if($item->usuario->perfil_usuario === 'palestrante')
                                                    Logado
                                                @else
                                                    Via Landing Page
                                                @endif
                                            </span>

                                            <span class="dep-date">
                                                <i class="bi bi-calendar3"></i>
                                                {{ $item->criado_em_depoimento }}
                                            </span>

                                        </div>


                                        <form action="{{ route('admin.depoimentos.aceitar', $item->id_depoimentos) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')

                                            <button type="submit" class="dep-action dep-action--approve">
                                                <i class="bi bi-check-lg"></i>
                                                Aprovar
                                            </button>
                                        </form>

                                    </div>

                                </article>

                            @empty

                                <div class="dep-empty">
                                    <div class="dep-empty-icon">
                                        <i class="bi bi-x-circle"></i>
                                    </div>

                                    <h5>
                                        Nenhum depoimento reprovado
                                    </h5>

                                    <p>
                                        Não existem depoimentos reprovados no momento.
                                    </p>
                                </div>

                            @endforelse

                        </section>

                    </div>

                </div>

            </div>
        </div>
    </main>


    {{-- =============================================================
    JAVASCRIPT DAS ABAS
    ============================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const tabs = document.querySelectorAll('.dep-tab');
            const panels = document.querySelectorAll('.dep-tab-panel');

            tabs.forEach(tab => {

                tab.addEventListener('click', function () {

                    const target = this.dataset.target;

                    tabs.forEach(item => {
                        item.classList.remove('active');
                    });

                    panels.forEach(panel => {
                        panel.classList.remove('active');
                    });

                    this.classList.add('active');

                    const targetPanel = document.querySelector(target);

                    if (targetPanel) {
                        targetPanel.classList.add('active');
                    }

                });

            });

        });
    </script>

@endsection