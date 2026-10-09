@extends('layout.palestrante')

@section('title', 'Publicações')
@section('pg-titulo', 'Publicações')
@section('link-topo', 'Conteúdo')

@section('content')

<div class="site-editor-main">

    <div class="site-editor-page">

        <div class="site-editor">

            {{-- CABEÇALHO DA PÁGINA --}}
            <div class="site-editor-tabs-header mb-4">

                <div class="site-editor-tabs-title">

                    <i class="bi bi-file-post"></i>

                    <div>
                        <strong>Publicações</strong>

                        <span>
                            Crie e gerencie as suas publicações na rede Conexão 360.
                        </span>
                    </div>

                </div>

            </div>


            {{-- SUCESSO --}}
            @if (session('success'))

                <div class="alert alert-success mb-4">
                    <i class="bi bi-check-circle me-2"></i>

                    {{ session('success') }}
                </div>

            @endif


            {{-- ERROS --}}
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


            {{-- =========================================================
                 NOVA PUBLICAÇÃO
            ========================================================== --}}
            <section class="mb-4">

                <div class="site-editor-section-header">

                    <div>

                        <div class="site-editor-section-icon">
                            <i class="bi bi-send"></i>
                        </div>

                        <div>
                            <h4>Nova publicação</h4>

                            <p>
                                Compartilhe textos e imagens com os participantes
                                da rede Conexão 360.
                            </p>
                        </div>

                    </div>

                </div>


                <div class="site-editor-card">

                    <form
                        action="{{ route('admin.palestrante.publicacoes.store') }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf


                        <div class="row g-4">

                            {{-- EVENTO --}}
                            <div class="col-lg-6">

                                <label
                                    for="id_evento"
                                    class="form-label">

                                    Evento relacionado

                                </label>

                                <select
                                    name="id_evento"
                                    id="id_evento"
                                    class="form-select">

                                    <option value="">
                                        Publicação geral
                                    </option>

                                    @foreach ($eventos as $evento)

                                        <option
                                            value="{{ $evento->id_evento }}"
                                            @selected(
                                                old('id_evento') == $evento->id_evento
                                            )>

                                            {{ $evento->titulo_evento }}

                                            @if ($evento->edicao_evento)
                                                — {{ $evento->edicao_evento }}
                                            @endif

                                        </option>

                                    @endforeach

                                </select>

                                <div class="form-text">
                                    Caso não pertença a nenhum evento,
                                    mantenha como publicação geral.
                                </div>

                            </div>


                            {{-- MÍDIA --}}
                            <div class="col-lg-6">

                                <label
                                    for="midia_publicacao"
                                    class="form-label">

                                    Imagem

                                </label>

                                <input
                                    type="file"
                                    name="midia_publicacao"
                                    id="midia_publicacao"
                                    class="form-control"
                                    accept=".jpg,.jpeg,.png,.webp">

                                <div class="form-text">
                                    JPG, JPEG, PNG ou WEBP.
                                </div>

                            </div>


                            {{-- TEXTO --}}
                            <div class="col-12">

                                <label
                                    for="texto_publicacao"
                                    class="form-label">

                                    Texto da publicação

                                </label>

                                <textarea
                                    name="texto_publicacao"
                                    id="texto_publicacao"
                                    rows="6"
                                    class="form-control"
                                    placeholder="Escreva o conteúdo da publicação...">{{ old('texto_publicacao') }}</textarea>

                                <div class="form-text">
                                    A publicação pode possuir texto,
                                    imagem ou ambos.
                                </div>

                            </div>

                        </div>


                        <div class="site-editor-card-footer">

                            <button
                                type="submit"
                                class="btn-site-editor-save">

                                <i class="bi bi-send-fill"></i>

                                Publicar

                            </button>

                        </div>

                    </form>

                </div>

            </section>


            {{-- =========================================================
                 PUBLICAÇÕES CADASTRADAS
            ========================================================== --}}
            <section>

                <div class="site-editor-section-header">

                    <div>

                        <div class="site-editor-section-icon">
                            <i class="bi bi-collection"></i>
                        </div>

                        <div>
                            <h4>Minhas publicações</h4>

                            <p>
                                Visualize e controle somente as publicações
                                criadas por você.
                            </p>
                        </div>

                    </div>

                    <span class="publication-total">
                        {{ $publicacoes->count() }}
                        {{ $publicacoes->count() === 1 ? 'publicação' : 'publicações' }}
                    </span>

                </div>

                <div class="publication-manager">

    @forelse ($publicacoes as $publicacao)

        <article class="publication-manager-item">

            {{-- AUTOR / IDENTIFICAÇÃO --}}
            <div class="publication-manager-author">

                <div class="publication-manager-avatar">
                    {{ strtoupper(
                        substr(
                            $publicacao->usuario?->nome_usuario ?? 'U',
                            0,
                            1
                        )
                    ) }}
                </div>

                <div class="publication-manager-author-info">

                    <strong>
                        {{ $publicacao->usuario?->nome_usuario ?? 'Usuário' }}
                    </strong>

                    <span>
                        Publicação #{{ $publicacao->id_publicacao }}
                    </span>

                </div>

            </div>


            {{-- CONTEÚDO --}}
            <div class="publication-manager-content">

                <p>
                    @if ($publicacao->texto_publicacao)

                        {{ \Illuminate\Support\Str::limit(
                            $publicacao->texto_publicacao,
                            140
                        ) }}

                    @else

                        <span class="publication-manager-muted">
                            Publicação somente com mídia.
                        </span>

                    @endif
                </p>


                <div class="publication-manager-meta">

                    {{-- EVENTO --}}
                    @if ($publicacao->evento)

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


                    {{-- MÍDIA --}}
                    @if ($publicacao->tipo_midia_publicacao)

                        <span>

                            @if ($publicacao->tipo_midia_publicacao === 'IMAGEM')
                                <i class="bi bi-image"></i>
                            @else
                                <i class="bi bi-play-circle"></i>
                            @endif

                            {{ ucfirst(strtolower(
                                $publicacao->tipo_midia_publicacao
                            )) }}

                        </span>

                    @endif


                    {{-- DATA --}}
                    <span>
                        <i class="bi bi-clock"></i>

                        {{ optional(
                            $publicacao->criado_em_publicacao
                        )->format('d/m/Y H:i') }}
                    </span>

                </div>

            </div>


            {{-- STATUS --}}
            <div class="publication-manager-status">

                @if ($publicacao->status_publicacao === 'ATIVO')

                    <span class="publication-status-pill publication-status-pill--active">
                        <i class="bi bi-circle-fill"></i>
                        Ativo
                    </span>

                @else

                    <span class="publication-status-pill publication-status-pill--hidden">
                        <i class="bi bi-circle-fill"></i>
                        Oculto
                    </span>

                @endif

            </div>


            {{-- AÇÕES --}}
            <div class="publication-manager-actions">

                <form
                    action="{{ route(
                        'admin.palestrante.publicacoes.status',
                        $publicacao->id_publicacao
                    ) }}"
                    method="POST">

                    @csrf
                    @method('PATCH')


                    @if ($publicacao->status_publicacao === 'ATIVO')

                        <input
                            type="hidden"
                            name="status_publicacao"
                            value="OCULTO">

                        <button
                            type="submit"
                            class="publication-manager-button">

                            <i class="bi bi-eye-slash"></i>

                            Ocultar

                        </button>

                    @else

                        <input
                            type="hidden"
                            name="status_publicacao"
                            value="ATIVO">

                        <button
                            type="submit"
                            class="publication-manager-button publication-manager-button--activate">

                            <i class="bi bi-eye"></i>

                            Ativar

                        </button>

                    @endif

                </form>

            </div>

        </article>

    @empty

        <div class="publication-manager-empty">

            <i class="bi bi-file-earmark-text"></i>

            <strong>
                Nenhuma publicação cadastrada
            </strong>

            <span>
                As publicações criadas aparecerão aqui.
            </span>

        </div>

    @endforelse

</div>


            </section>

        </div>

    </div>

</div>

@endsection