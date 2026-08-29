@extends('layout.palestrante')

@section('title', 'Depoimentos')
@section('pg-titulo', 'Depoimentos')
@section('link-topo', 'Depoimentos')

@section('content')

    @php
        $gruposDepoimentos = [
            [
                'id' => 'pendentes',
                'titulo' => 'Pendentes',
                'icone' => 'bi-clock-history',
                'itens' => $depoimentosPend,
            ],
            [
                'id' => 'aprovados',
                'titulo' => 'Aprovados',
                'icone' => 'bi-check-circle-fill',
                'itens' => $depoimentosAceitos,
            ],
            [
                'id' => 'reprovados',
                'titulo' => 'Reprovados',
                'icone' => 'bi-x-circle-fill',
                'itens' => $depoimentosRegei,
            ],
        ];
    @endphp


    <main class="app-main admin-standard-main speaker-admin-main">

        <div class="app-content container-fluid admin-standard-content">

            <div class="admin-standard-page speaker-depo-page">

                <section class="admin-standard-panel speaker-depo-panel">

                    {{-- =========================================================
                    CABEÇALHO
                    ========================================================== --}}
                    <div class="speaker-depo-toolbar">

                        <div class="speaker-depo-heading">

                            <h2>
                                Meus Depoimentos
                            </h2>

                            <p>
                                Envie um depoimento e acompanhe o status de cada publicação.
                            </p>

                        </div>


                        <button type="button" class="admin-primary-action" data-bs-toggle="modal"
                            data-bs-target="#criarDepoimento">
                            <i class="bi bi-plus-lg"></i>
                            Novo Depoimento
                        </button>

                    </div>


                    {{-- =========================================================
                    ABAS
                    ========================================================== --}}
                    <div class="speaker-dep-tabs-wrap">

                        <ul class="speaker-dep-tabs" id="speakerDepTabs" role="tablist">

                            @foreach ($gruposDepoimentos as $grupo)

                                <li role="presentation">

                                    <button type="button" class="speaker-dep-tab {{ $loop->first ? 'active' : '' }}"
                                        data-target="#speaker-{{ $grupo['id'] }}" data-status="{{ $grupo['id'] }}" role="tab"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        <i class="bi {{ $grupo['icone'] }}"></i>

                                        <span>
                                            {{ $grupo['titulo'] }}
                                        </span>

                                        <span class="speaker-dep-count">
                                            {{ $grupo['itens']->count() }}
                                        </span>
                                    </button>

                                </li>

                            @endforeach

                        </ul>

                    </div>


                    {{-- =========================================================
                    CONTEÚDO
                    ========================================================== --}}
                    <div class="speaker-dep-content">

                        @foreach ($gruposDepoimentos as $grupo)

                            <div id="speaker-{{ $grupo['id'] }}" class="speaker-dep-panel {{ $loop->first ? 'active' : '' }}"
                                role="tabpanel">

                                @forelse ($grupo['itens'] as $item)

                                    @php
                                        $autor = $item->usuario;

                                        $nomeAutor = trim($autor->nome_usuario ?? 'Usuário');
                                        $partesAutor = preg_split('/\s+/', $nomeAutor);

                                        $autorInicial1 = mb_substr($partesAutor[0] ?? '', 0, 1);
                                        $autorInicial2 = isset($partesAutor[1])
                                            ? mb_substr($partesAutor[1], 0, 1)
                                            : mb_substr($partesAutor[0] ?? '', 1, 1);

                                        $iniciaisAutor = strtoupper($autorInicial1 . $autorInicial2);

                                        $fotoAutorRelativa = !empty($autor->foto_usuario)
                                            ? 'dash/assets/img/' . $autor->foto_usuario
                                            : null;

                                        $fotoAutorExiste = $fotoAutorRelativa
                                            && file_exists(public_path($fotoAutorRelativa));
                                    @endphp


                                    <article class="speaker-dep-card">

                                        <div class="speaker-dep-card-body">

                                            <div class="speaker-dep-author">

                                                @if ($fotoAutorExiste)

                                                    <img src="{{ asset($fotoAutorRelativa) }}" alt="{{ $nomeAutor }}"
                                                        class="speaker-dep-avatar" loading="lazy">

                                                @else

                                                    <div class="speaker-dep-avatar-fallback" aria-label="{{ $nomeAutor }}">
                                                        {{ $iniciaisAutor }}
                                                    </div>

                                                @endif


                                                <div class="speaker-dep-author-copy">

                                                    <strong>
                                                        {{ $nomeAutor }}
                                                    </strong>

                                                    <span>
                                                        {{ $autor->area_atuacao_usuario ?? 'Área não informada' }}
                                                        @if (!empty($autor->estado_usuario))
                                                            • {{ $autor->estado_usuario }}
                                                        @endif
                                                    </span>

                                                </div>

                                            </div>


                                            <p class="speaker-dep-text">
                                                “{{ $item->descricao_depoimento }}”
                                            </p>

                                        </div>


                                        <footer class="speaker-dep-footer">

                                            <span class="speaker-dep-origin">

                                                <i class="bi bi-person-check"></i>

                                                @if (($autor->perfil_usuario ?? null) === 'palestrante')
                                                    Logado
                                                @else
                                                    Via Landing Page
                                                @endif

                                            </span>


                                            <span>
                                                {{ $item->criado_em_depoimento }}
                                            </span>

                                        </footer>

                                    </article>


                                @empty

                                    <div class="speaker-empty">

                                        <span class="speaker-empty-icon">
                                            <i class="bi bi-chat-square-text"></i>
                                        </span>

                                        <strong>
                                            Nenhum depoimento {{ mb_strtolower($grupo['titulo']) }}.
                                        </strong>

                                        <span>
                                            Quando houver registros com este status, eles aparecerão aqui.
                                        </span>

                                    </div>

                                @endforelse

                            </div>

                        @endforeach

                    </div>

                </section>

            </div>

        </div>

    </main>


    @include('palestrante.modal.criar-depoimento')


    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const tabs = document.querySelectorAll('.speaker-dep-tab');
            const panels = document.querySelectorAll('.speaker-dep-panel');

            if (!tabs.length || !panels.length) {
                return;
            }

            tabs.forEach((tab) => {

                tab.addEventListener('click', () => {

                    const target = tab.getAttribute('data-target');
                    const targetPanel = document.querySelector(target);

                    if (!targetPanel) {
                        return;
                    }

                    tabs.forEach((item) => {
                        item.classList.remove('active');
                        item.setAttribute('aria-selected', 'false');
                    });

                    panels.forEach((panel) => {
                        panel.classList.remove('active');
                    });

                    tab.classList.add('active');
                    tab.setAttribute('aria-selected', 'true');

                    targetPanel.classList.add('active');

                });

            });

        });
    </script>

@endsection