@extends('layout.admin')

@section('title', 'Moderação | ')
@section('pg-titulo', 'Moderação')
@section('link-topo', 'Moderação')

@section('content')

<main class="app-main dash-moderacao-main">
    <div class="app-content container-fluid">
        <div class="dash-page dash-page--moderacao">

            @if (session('success'))
                <div class="alert alert-success mb-4">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger mb-4">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <strong>
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Não foi possível concluir a análise:
                    </strong>

                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="moderation-panel">

                <div class="moderation-tabs-wrapper">
                    <div class="moderation-tabs" id="moderationTabs">

                        <button type="button" class="moderation-tab active" data-target="#moderacao-pendentes">
                            <span class="moderation-tab-icon moderation-tab-icon--pending">
                                <i class="bi bi-shield-exclamation"></i>
                            </span>

                            <span class="moderation-tab-info">
                                <span class="moderation-tab-title">Pendentes</span>
                                <span class="moderation-tab-description">Denúncias aguardando análise</span>
                            </span>

                            <span class="moderation-tab-count moderation-tab-count--pending">
                                {{ $denunciasPendentes->count() }}
                            </span>
                        </button>

                        <button type="button" class="moderation-tab" data-target="#moderacao-analisadas">
                            <span class="moderation-tab-icon moderation-tab-icon--resolved">
                                <i class="bi bi-shield-check"></i>
                            </span>

                            <span class="moderation-tab-info">
                                <span class="moderation-tab-title">Analisadas</span>
                                <span class="moderation-tab-description">Histórico das decisões realizadas</span>
                            </span>

                            <span class="moderation-tab-count moderation-tab-count--resolved">
                                {{ $denunciasAnalisadas->count() }}
                            </span>
                        </button>

                    </div>
                </div>

                <div class="moderation-tabs-content">

                    {{-- PENDENTES --}}
                    <section id="moderacao-pendentes" class="moderation-tab-panel active">

                        @forelse ($denunciasPendentes as $denuncia)

                            @php
                                $publicacao = $denuncia->publicacao;
                                $autor = $publicacao?->usuario;
                                $denunciante = $denuncia->denunciante;
                            @endphp

                            <article class="moderation-card">

                                <div class="moderation-card-header">
                                    <div class="moderation-card-heading">
                                        <span class="moderation-card-icon">
                                            <i class="bi bi-flag-fill"></i>
                                        </span>

                                        <div>
                                            <span class="moderation-card-eyebrow">
                                                Denúncia #{{ $denuncia->id_denuncia }}
                                            </span>

                                            <h5>
                                                {{ $denuncia->motivo_denuncia }}
                                            </h5>
                                        </div>
                                    </div>

                                    <span class="moderation-status moderation-status--pending">
                                        <i class="bi bi-clock"></i>
                                        Pendente
                                    </span>
                                </div>

                                <div class="moderation-card-body">

                                    <div class="moderation-people-grid">
                                        <div class="moderation-person">
                                            <span class="moderation-person-label">Autor da publicação</span>
                                            <strong>{{ $autor?->nome_usuario ?? 'Usuário não encontrado' }}</strong>
                                            <small>{{ $autor?->email_usuario ?? 'Sem e-mail disponível' }}</small>
                                        </div>

                                        <div class="moderation-person">
                                            <span class="moderation-person-label">Denunciado por</span>
                                            <strong>{{ $denunciante?->nome_usuario ?? 'Usuário não encontrado' }}</strong>
                                            <small>{{ $denunciante?->email_usuario ?? 'Sem e-mail disponível' }}</small>
                                        </div>
                                    </div>

                                    <div class="moderation-report-box">
                                        <span class="moderation-section-label">Descrição da denúncia</span>
                                        <p>
                                            {{ $denuncia->descricao_denuncia ?: 'O usuário não adicionou uma descrição.' }}
                                        </p>
                                    </div>

                                    <div class="moderation-publication-preview">
                                        <div class="moderation-publication-topline">
                                            <span class="moderation-section-label">
                                                Publicação #{{ $publicacao?->id_publicacao ?? '-' }}
                                            </span>

                                            @if ($publicacao)
                                                <span class="moderation-publication-status {{ $publicacao->status_publicacao === 'ATIVO' ? 'is-active' : 'is-hidden' }}">
                                                    <i class="bi bi-circle-fill"></i>
                                                    {{ $publicacao->status_publicacao === 'ATIVO' ? 'Ativa' : 'Oculta' }}
                                                </span>
                                            @endif
                                        </div>

                                        <p class="moderation-publication-text">
                                            @if ($publicacao?->texto_publicacao)
                                                {{ \Illuminate\Support\Str::limit($publicacao->texto_publicacao, 240) }}
                                            @else
                                                <span class="moderation-muted">Publicação somente com mídia.</span>
                                            @endif
                                        </p>

                                        <div class="moderation-publication-meta">
                                            @if ($publicacao?->evento)
                                                <span>
                                                    <i class="bi bi-calendar-event"></i>
                                                    {{ $publicacao->evento->titulo_evento }}
                                                </span>
                                            @else
                                                <span>
                                                    <i class="bi bi-globe2"></i>
                                                    Publicação geral
                                                </span>
                                            @endif

                                            @if ($publicacao?->tipo_midia_publicacao)
                                                <span>
                                                    <i class="bi {{ $publicacao->tipo_midia_publicacao === 'IMAGEM' ? 'bi-image' : 'bi-play-circle' }}"></i>
                                                    {{ ucfirst(strtolower($publicacao->tipo_midia_publicacao)) }}
                                                </span>
                                            @endif

                                            <span>
                                                <i class="bi bi-calendar3"></i>
                                                {{ optional($denuncia->criado_em_denuncia)->format('d/m/Y H:i') }}
                                            </span>
                                        </div>
                                    </div>

                                </div>

                                <div class="moderation-card-footer">
                                    <span class="moderation-card-help">
                                        <i class="bi bi-info-circle"></i>
                                        Analise a denúncia antes de tomar uma decisão.
                                    </span>

                                    <button
                                        type="button"
                                        class="moderation-action moderation-action--review"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalModeracao{{ $denuncia->id_denuncia }}">
                                        <i class="bi bi-search"></i>
                                        Analisar
                                    </button>
                                </div>

                            </article>

                            {{-- MODAL DE ANÁLISE --}}
                            <div
                                class="modal fade moderation-modal"
                                id="modalModeracao{{ $denuncia->id_denuncia }}"
                                tabindex="-1"
                                aria-hidden="true">

                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <div>
                                                <span class="moderation-modal-eyebrow">
                                                    Denúncia #{{ $denuncia->id_denuncia }}
                                                </span>
                                                <h5 class="modal-title">Analisar publicação denunciada</h5>
                                            </div>

                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Fechar">
                                            </button>
                                        </div>

                                        <form
                                            action="{{ route('admin.moderacao.analisar', $denuncia->id_denuncia) }}"
                                            method="POST">

                                            @csrf
                                            @method('PATCH')

                                            <div class="modal-body">

                                                <div class="moderation-modal-section">
                                                    <span class="moderation-section-label">Motivo informado</span>
                                                    <strong class="moderation-modal-reason">
                                                        {{ $denuncia->motivo_denuncia }}
                                                    </strong>

                                                    <p class="moderation-modal-description">
                                                        {{ $denuncia->descricao_denuncia ?: 'Nenhuma descrição adicional foi informada.' }}
                                                    </p>
                                                </div>

                                                <div class="moderation-modal-section">
                                                    <span class="moderation-section-label">Publicação</span>

                                                    <div class="moderation-modal-author">
                                                        <strong>{{ $autor?->nome_usuario ?? 'Usuário não encontrado' }}</strong>
                                                        <span>{{ $autor?->email_usuario ?? 'Sem e-mail disponível' }}</span>
                                                    </div>

                                                    @if ($publicacao?->texto_publicacao)
                                                        <div class="moderation-modal-publication-text">
                                                            {{ $publicacao->texto_publicacao }}
                                                        </div>
                                                    @endif

                                                    @if ($publicacao?->midia_publicacao)
                                                        <div class="moderation-media-preview">
                                                            @if ($publicacao->tipo_midia_publicacao === 'IMAGEM')
                                                                <img
                                                                    src="{{ asset('conexao360/' . $publicacao->midia_publicacao) }}"
                                                                    alt="Mídia da publicação denunciada">
                                                            @elseif ($publicacao->tipo_midia_publicacao === 'VIDEO')
                                                                <video controls preload="metadata">
                                                                    <source src="{{ asset('conexao360/' . $publicacao->midia_publicacao) }}">
                                                                    Seu navegador não suporta a reprodução deste vídeo.
                                                                </video>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="moderation-modal-section">
                                                    <label
                                                        for="observacao_moderador_{{ $denuncia->id_denuncia }}"
                                                        class="form-label moderation-section-label">
                                                        Observação da moderação
                                                    </label>

                                                    <textarea
                                                        name="observacao_moderador"
                                                        id="observacao_moderador_{{ $denuncia->id_denuncia }}"
                                                        class="form-control"
                                                        rows="4"
                                                        maxlength="2000"
                                                        placeholder="Opcional. Registre o motivo da decisão para manter o histórico da análise."></textarea>
                                                </div>

                                                <div class="moderation-decision-note">
                                                    <i class="bi bi-shield-check"></i>
                                                    <span>
                                                        Manter apenas encerra a denúncia. Ocultar altera a publicação de <strong>ATIVO</strong> para <strong>OCULTO</strong>, sem apagar o registro do banco.
                                                    </span>
                                                </div>

                                            </div>

                                            <div class="modal-footer moderation-modal-footer">
                                                <button
                                                    type="button"
                                                    class="moderation-action moderation-action--cancel"
                                                    data-bs-dismiss="modal">
                                                    Cancelar
                                                </button>

                                                <button
                                                    type="submit"
                                                    name="decisao_denuncia"
                                                    value="MANTER"
                                                    class="moderation-action moderation-action--keep">
                                                    <i class="bi bi-check-circle"></i>
                                                    Manter publicação
                                                </button>

                                                <button
                                                    type="submit"
                                                    name="decisao_denuncia"
                                                    value="OCULTAR"
                                                    class="moderation-action moderation-action--hide">
                                                    <i class="bi bi-eye-slash"></i>
                                                    Ocultar publicação
                                                </button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>

                        @empty

                            <div class="moderation-empty">
                                <div class="moderation-empty-icon">
                                    <i class="bi bi-shield-check"></i>
                                </div>

                                <h5>Nenhuma denúncia pendente</h5>
                                <p>Não existem publicações aguardando análise da moderação no momento.</p>
                            </div>

                        @endforelse

                    </section>

                    {{-- ANALISADAS --}}
                    <section id="moderacao-analisadas" class="moderation-tab-panel">

                        @forelse ($denunciasAnalisadas as $denuncia)

                            @php
                                $publicacao = $denuncia->publicacao;
                                $autor = $publicacao?->usuario;
                                $denunciante = $denuncia->denunciante;
                                $foiOcultada = $denuncia->decisao_denuncia === 'OCULTAR';
                            @endphp

                            <article class="moderation-card">

                                <div class="moderation-card-header">
                                    <div class="moderation-card-heading">
                                        <span class="moderation-card-icon {{ $foiOcultada ? 'is-hidden' : 'is-kept' }}">
                                            <i class="bi {{ $foiOcultada ? 'bi-eye-slash-fill' : 'bi-check-circle-fill' }}"></i>
                                        </span>

                                        <div>
                                            <span class="moderation-card-eyebrow">
                                                Denúncia #{{ $denuncia->id_denuncia }}
                                            </span>

                                            <h5>{{ $denuncia->motivo_denuncia }}</h5>
                                        </div>
                                    </div>

                                    <span class="moderation-status {{ $foiOcultada ? 'moderation-status--hidden' : 'moderation-status--kept' }}">
                                        <i class="bi {{ $foiOcultada ? 'bi-eye-slash' : 'bi-check-circle' }}"></i>
                                        {{ $foiOcultada ? 'Publicação ocultada' : 'Publicação mantida' }}
                                    </span>
                                </div>

                                <div class="moderation-card-body">

                                    <div class="moderation-people-grid">
                                        <div class="moderation-person">
                                            <span class="moderation-person-label">Autor da publicação</span>
                                            <strong>{{ $autor?->nome_usuario ?? 'Usuário não encontrado' }}</strong>
                                            <small>{{ $autor?->email_usuario ?? 'Sem e-mail disponível' }}</small>
                                        </div>

                                        <div class="moderation-person">
                                            <span class="moderation-person-label">Denunciado por</span>
                                            <strong>{{ $denunciante?->nome_usuario ?? 'Usuário não encontrado' }}</strong>
                                            <small>{{ $denunciante?->email_usuario ?? 'Sem e-mail disponível' }}</small>
                                        </div>
                                    </div>

                                    <div class="moderation-publication-preview">
                                        <span class="moderation-section-label">
                                            Publicação #{{ $publicacao?->id_publicacao ?? '-' }}
                                        </span>

                                        <p class="moderation-publication-text">
                                            @if ($publicacao?->texto_publicacao)
                                                {{ \Illuminate\Support\Str::limit($publicacao->texto_publicacao, 240) }}
                                            @else
                                                <span class="moderation-muted">Publicação somente com mídia.</span>
                                            @endif
                                        </p>
                                    </div>

                                    @if ($denuncia->observacao_moderador)
                                        <div class="moderation-report-box">
                                            <span class="moderation-section-label">Observação da moderação</span>
                                            <p>{{ $denuncia->observacao_moderador }}</p>
                                        </div>
                                    @endif

                                </div>

                                <div class="moderation-card-footer">
                                    <div class="moderation-history-meta">
                                        <span>
                                            <i class="bi bi-person-check"></i>
                                            {{ $denuncia->moderador?->nome_usuario ?? 'Moderador' }}
                                        </span>

                                        <span>
                                            <i class="bi bi-calendar-check"></i>
                                            {{ optional($denuncia->analisado_em_denuncia)->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                </div>

                            </article>

                        @empty

                            <div class="moderation-empty">
                                <div class="moderation-empty-icon">
                                    <i class="bi bi-archive"></i>
                                </div>

                                <h5>Nenhuma denúncia analisada</h5>
                                <p>O histórico das decisões de moderação aparecerá aqui.</p>
                            </div>

                        @endforelse

                    </section>

                </div>
            </div>

        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.moderation-tab');
        const panels = document.querySelectorAll('.moderation-tab-panel');

        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                const target = this.dataset.target;

                tabs.forEach(item => item.classList.remove('active'));
                panels.forEach(panel => panel.classList.remove('active'));

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
