@extends('layout.admin')

@section('pg-titulo', 'Enquetes')
@section('link-topo', 'Enquetes')

@section('content')

<div class="site-editor-main content-manager-page">
    <div class="site-editor-page">
        <div class="site-editor">

            <div class="site-editor-tabs-header mb-4">
                <div class="site-editor-tabs-title">
                    <i class="bi bi-bar-chart-fill"></i>

                    <div>
                        <strong>Enquetes</strong>
                        <span>
                            Crie perguntas objetivas para os membros e acompanhe a participação da rede.
                        </span>
                    </div>
                </div>

                <a href="{{ route('admin.conteudos.index') }}" class="content-manager-back-link">
                    <i class="bi bi-arrow-left"></i>
                    Conteúdos
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success mb-4">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <strong>
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Verifique os campos:
                    </strong>

                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="mb-4">
                <div class="site-editor-section-header">
                    <div>
                        <div class="site-editor-section-icon">
                            <i class="bi bi-plus-lg"></i>
                        </div>

                        <div>
                            <h4>Nova enquete</h4>
                            <p>
                                Nesta primeira versão, as respostas são fixas: Sim, Não e Outro.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="site-editor-card">
                    <form action="{{ route('admin.enquetes.store') }}" method="POST">
                        @csrf

                        <div class="row g-4 align-items-end">
                            <div class="col-lg-8">
                                <label for="pergunta_enquete" class="form-label">
                                    Pergunta da enquete
                                </label>

                                <input
                                    type="text"
                                    name="pergunta_enquete"
                                    id="pergunta_enquete"
                                    class="form-control"
                                    maxlength="80"
                                    value="{{ old('pergunta_enquete') }}"
                                    placeholder="Ex.: Você participaria de uma próxima edição deste evento?"
                                    required>

                                <div class="form-text">
                                    O banco atual permite perguntas de até 80 caracteres.
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <button type="submit" class="btn-site-editor-save content-poll-submit">
                                    <i class="bi bi-plus-circle-fill"></i>
                                    Criar enquete
                                </button>
                            </div>
                        </div>

                        <div class="content-poll-options-preview">
                            <span>
                                <i class="bi bi-check-circle"></i>
                                Sim
                            </span>

                            <span>
                                <i class="bi bi-x-circle"></i>
                                Não
                            </span>

                            <span>
                                <i class="bi bi-three-dots"></i>
                                Outro
                            </span>
                        </div>
                    </form>
                </div>
            </section>

            <section>
                <div class="site-editor-section-header">
                    <div>
                        <div class="site-editor-section-icon">
                            <i class="bi bi-clipboard-data"></i>
                        </div>

                        <div>
                            <h4>Enquetes cadastradas</h4>
                            <p>
                                Os resultados são calculados pelas respostas registradas em <strong>tbl_respostas</strong>.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="content-poll-grid">
                    @forelse ($enquetes as $enquete)
                        @php
                            $total = (int) $enquete->total_votos;
                            $sim = (int) $enquete->votos_sim;
                            $nao = (int) $enquete->votos_nao;
                            $outro = (int) $enquete->votos_outro;

                            $pctSim = $total > 0 ? round(($sim / $total) * 100) : 0;
                            $pctNao = $total > 0 ? round(($nao / $total) * 100) : 0;
                            $pctOutro = $total > 0 ? round(($outro / $total) * 100) : 0;
                        @endphp

                        <article class="content-poll-card">
                            <div class="content-poll-card-head">
                                <span class="content-poll-number">
                                    Enquete #{{ $enquete->id_enquete }}
                                </span>

                                <span class="content-poll-total">
                                    <i class="bi bi-people"></i>
                                    {{ $total }} {{ $total === 1 ? 'voto' : 'votos' }}
                                </span>
                            </div>

                            <div class="content-poll-card-body">
                                <h3>{{ $enquete->pergunta_enquete }}</h3>

                                <div class="content-poll-result-list">
                                    <div class="content-poll-result">
                                        <div class="content-poll-result-label">
                                            <span>Sim</span>
                                            <strong>{{ $sim }} · {{ $pctSim }}%</strong>
                                        </div>
                                        <div class="content-poll-progress">
                                            <span style="width: {{ $pctSim }}%"></span>
                                        </div>
                                    </div>

                                    <div class="content-poll-result">
                                        <div class="content-poll-result-label">
                                            <span>Não</span>
                                            <strong>{{ $nao }} · {{ $pctNao }}%</strong>
                                        </div>
                                        <div class="content-poll-progress">
                                            <span style="width: {{ $pctNao }}%"></span>
                                        </div>
                                    </div>

                                    <div class="content-poll-result">
                                        <div class="content-poll-result-label">
                                            <span>Outro</span>
                                            <strong>{{ $outro }} · {{ $pctOutro }}%</strong>
                                        </div>
                                        <div class="content-poll-progress">
                                            <span style="width: {{ $pctOutro }}%"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="content-manager-empty">
                            <span class="content-manager-empty-icon">
                                <i class="bi bi-bar-chart"></i>
                            </span>

                            <h5>Nenhuma enquete cadastrada</h5>
                            <p>Crie a primeira pergunta para começar a medir a participação dos membros.</p>
                        </div>
                    @endforelse
                </div>
            </section>

        </div>
    </div>
</div>

@endsection
