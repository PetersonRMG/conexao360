<main class="experience-main speakers-page">

    {{-- ================================================================
    HERO INTERNO — PALESTRANTES
    ================================================================= --}}
    <section class="speakers-hero">
        <div class="speakers-hero-overlay"></div>

        <div class="experience-shell speakers-hero-shell">
            <div class="speakers-hero-copy">
                <p class="experience-eyebrow">Conexão 360º</p>

                <h1>
                    Palestrantes
                    <span>Conhecimento que transforma.</span>
                </h1>

                <p>
                    Profissionais que unem experiência, prática e visão de mercado
                    para provocar novas ideias e ampliar possibilidades dentro da advocacia.
                </p>

                <a href="#todos-palestrantes" class="experience-primary-button">
                    Conheça os palestrantes
                </a>
            </div>
        </div>
    </section>


    {{-- ================================================================
    LISTAGEM DINÂMICA
    Dados: $palestrantes
    ================================================================= --}}
    <section class="speakers-directory" id="todos-palestrantes">
        <div class="experience-shell">

            <div class="speakers-directory-heading">
                <div>
                    <p class="experience-eyebrow">Grandes nomes. Grandes ideias.</p>
                    <h2>Quem sobe ao palco do Conexão 360.</h2>
                </div>

                <p>
                    Conheça profissionais de diferentes áreas e descubra as experiências,
                    especialidades e visões que fazem parte desta edição.
                </p>
            </div>


            {{-- FILTROS DINÂMICOS POR ÁREA DE ATUAÇÃO --}}
            @php
                $areasPalestrantes = $palestrantes
                    ->pluck('area_atuacao_usuario')
                    ->filter()
                    ->unique()
                    ->sort()
                    ->values();
            @endphp

            @if ($areasPalestrantes->isNotEmpty())
                <div class="speakers-filters" aria-label="Filtrar palestrantes por área">
                    <button class="speakers-filter is-active" type="button" data-filter="todos">
                        Todos
                    </button>

                    @foreach ($areasPalestrantes as $area)
                        <button
                            class="speakers-filter"
                            type="button"
                            data-filter="{{ \Illuminate\Support\Str::slug($area) }}"
                        >
                            {{ $area }}
                        </button>
                    @endforeach
                </div>
            @endif


            <div class="speakers-grid">

                @forelse ($palestrantes as $item)
                    @php
                        $fotoPalestrante = !empty($item->foto_usuario)
                            ? 'dash/assets/img/' . $item->foto_usuario
                            : null;

                        $fotoExiste = $fotoPalestrante
                            && file_exists(public_path($fotoPalestrante));

                        $iniciais = collect(explode(' ', trim($item->nome_usuario)))
                            ->filter()
                            ->take(2)
                            ->map(fn ($parte) => mb_strtoupper(mb_substr($parte, 0, 1)))
                            ->implode('');

                        $areaSlug = \Illuminate\Support\Str::slug($item->area_atuacao_usuario ?? 'sem-area');
                    @endphp

                    <article
                        class="speaker-card"
                        id="palestrante-{{ $item->id_usuario }}"
                        data-area="{{ $areaSlug }}"
                    >
                        <div class="speaker-card-media">
                            @if ($fotoExiste)
                                <img
                                    src="{{ asset($fotoPalestrante) }}"
                                    alt="{{ $item->nome_usuario }}"
                                    loading="lazy"
                                    decoding="async"
                                >
                            @else
                                <div class="speaker-card-fallback">
                                    {{ $iniciais ?: 'P' }}
                                </div>
                            @endif

                            <div class="speaker-card-gradient"></div>

                            <div class="speaker-card-main">
                                <p class="speaker-card-area">
                                    {{ $item->area_atuacao_usuario ?: 'Palestrante' }}
                                </p>

                                <h3>{{ $item->nome_usuario }}</h3>
                            </div>
                        </div>

                        <div class="speaker-card-body">
                            <p>
                                {{ $item->sobre_usuario ?: 'Palestrante convidado do Conexão 360.' }}
                            </p>

                            <a href="#palestrante-{{ $item->id_usuario }}" class="speaker-card-link">
                                Conheça
                                <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </article>

                @empty
                    <div class="speakers-empty">
                        <i class="bi bi-people"></i>
                        <h3>Palestrantes em breve</h3>
                        <p>Os nomes desta edição serão divulgados em breve.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </section>


    {{-- ================================================================
    BLOCO EDITORIAL / PROPOSTA
    ================================================================= --}}
    <section class="speakers-editorial">
        <div class="experience-shell speakers-editorial-grid">

            <div class="speakers-editorial-copy">
                <p class="experience-eyebrow">Mais que palestras</p>

                <h2>
                    Experiência prática,
                    visão de mercado e
                    novas perspectivas.
                </h2>
            </div>

            <div class="speakers-editorial-text">
                <p>
                    Cada convidado traz experiências que ajudam a ampliar repertório,
                    provocar reflexões e transformar conhecimento em decisões mais estratégicas.
                </p>

                <div class="speakers-editorial-points">
                    <span><i class="bi bi-check2"></i> Experiência real</span>
                    <span><i class="bi bi-check2"></i> Conteúdo aplicável</span>
                    <span><i class="bi bi-check2"></i> Novas conexões</span>
                </div>
            </div>

        </div>
    </section>


    {{-- ================================================================
    CTA FINAL
    ================================================================= --}}
    <section class="speakers-final-cta">
        <div class="speakers-final-cta-glow"></div>

        <div class="experience-shell speakers-final-cta-shell">
            <p class="experience-eyebrow">Conexão 360º</p>

            <h2>
                Grandes encontros começam
                <span>com grandes ideias.</span>
            </h2>

            <p>
                Faça parte de uma experiência criada para conectar conhecimento,
                pessoas e oportunidades.
            </p>

            <a href="{{ url('/#ingressos') }}" class="experience-primary-button">
                Garantir ingresso
            </a>
        </div>
    </section>

</main>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const filtros = document.querySelectorAll('.speakers-filter');
    const cards = document.querySelectorAll('.speaker-card');

    filtros.forEach((botao) => {
        botao.addEventListener('click', function () {
            const filtro = this.dataset.filter;

            filtros.forEach((item) => item.classList.remove('is-active'));
            this.classList.add('is-active');

            cards.forEach((card) => {
                const mostrar = filtro === 'todos' || card.dataset.area === filtro;
                card.hidden = !mostrar;
            });
        });
    });
});
</script>
