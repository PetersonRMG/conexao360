<main class="experience-main news-page">

    <section class="news-hero">
        <div class="news-hero-overlay"></div>

        <div class="experience-shell news-hero-shell">
            <div class="news-hero-copy">
                <p class="experience-eyebrow">Conexão Jurídica</p>

                <h1>
                    Informação para uma
                    <span>advocacia que evolui.</span>
                </h1>

                <p>
                    Notícias, tendências e movimentos que impactam o mercado jurídico,
                    a carreira e a forma de exercer a advocacia.
                </p>
            </div>
        </div>
    </section>

    <section class="news-directory">
        <div class="experience-shell">

            <div class="news-directory-heading">
                <div>
                    <p class="experience-eyebrow">Conteúdo que movimenta</p>
                    <h2>Conexão Jurídica</h2>
                </div>

                <p>
                    Uma curadoria de assuntos relevantes para profissionais que querem
                    acompanhar o que está mudando no Direito e no mercado.
                </p>
            </div>

            <div class="news-search-wrap">
                <i class="bi bi-search"></i>
                <input type="search" id="newsSearch" placeholder="Buscar notícias..." aria-label="Buscar notícias">
            </div>

            @php
                $categoriasNoticias = $noticias
                    ->pluck('categoria')
                    ->filter()
                    ->unique()
                    ->sort()
                    ->values();
            @endphp

            <div class="news-filters">
                <button class="news-filter is-active" type="button" data-filter="todas">
                    Todas
                </button>

                @foreach ($categoriasNoticias as $categoria)
                    <button class="news-filter" type="button" data-filter="{{ \Illuminate\Support\Str::slug($categoria) }}">
                        {{ $categoria }}
                    </button>
                @endforeach
            </div>

            <div class="news-grid" id="newsGrid">

                @foreach ($noticias as $item)
                    @php
                        $categoriaSlug = \Illuminate\Support\Str::slug($item['categoria']);
                    @endphp

                    <article class="news-card" data-category="{{ $categoriaSlug }}"
                        data-title="{{ \Illuminate\Support\Str::lower($item['titulo']) }}"
                        data-summary="{{ \Illuminate\Support\Str::lower($item['resumo']) }}">
                        <a href="{{ $item['url'] }}" class="news-card-image">
                            <img src="{{ asset($item['imagem']) }}" alt="{{ $item['titulo'] }}" loading="lazy">

                            <span class="news-card-category">
                                {{ $item['categoria'] }}
                            </span>
                        </a>

                        <div class="news-card-content">
                            <span class="news-card-date">
                                {{ $item['data'] }}
                            </span>

                            <h3>
                                <a href="{{ $item['url'] }}">
                                    {{ $item['titulo'] }}
                                </a>
                            </h3>

                            <p>{{ $item['resumo'] }}</p>

                            <a href="{{ $item['url'] }}" class="news-card-link">
                                Ler mais <span>→</span>
                            </a>
                        </div>
                    </article>
                @endforeach

            </div>

            <div class="news-pagination">
                <button type="button" class="is-active">1</button>
                <button type="button">2</button>
                <button type="button">3</button>
                <span>...</span>
                <button type="button">10</button>
                <button type="button"><i class="bi bi-arrow-right"></i></button>
            </div>

        </div>
    </section>

    <section class="news-editorial">
        <div class="experience-shell news-editorial-grid">

            <div class="news-editorial-copy">
                <p class="experience-eyebrow">Conhecimento em movimento</p>

                <h2>
                    O Direito muda.
                    <span>Quem acompanha, evolui junto.</span>
                </h2>
            </div>

            <div class="news-editorial-text">
                <p>
                    A Conexão Jurídica existe para manter profissionais próximos de ideias,
                    tendências e transformações que impactam a advocacia.
                </p>

                <div class="news-editorial-points">
                    <span><i class="bi bi-check2"></i> Mercado jurídico</span>
                    <span><i class="bi bi-check2"></i> Tecnologia</span>
                    <span><i class="bi bi-check2"></i> Gestão e carreira</span>
                    <span><i class="bi bi-check2"></i> Atualizações relevantes</span>
                </div>
            </div>

        </div>
    </section>

    <section class="news-final-cta">
        <div class="news-final-cta-glow"></div>

        <div class="experience-shell news-final-cta-shell">
            <p class="experience-eyebrow">Conexão 360º</p>

            <h2>
                Informação também
                <span>gera movimento.</span>
            </h2>

            <p>
                Continue acompanhando conteúdos, experiências e pessoas que fazem parte
                do ecossistema Conexão 360.
            </p>

            <a href="{{ route('page-app') }}" class="experience-primary-button">
                Conheça a comunidade
            </a>
        </div>
    </section>

</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filtros = document.querySelectorAll('.news-filter');
        const cards = document.querySelectorAll('.news-card');
        const busca = document.getElementById('newsSearch');

        let filtroAtual = 'todas';

        function filtrarNoticias() {
            const termo = (busca?.value || '').toLowerCase().trim();

            cards.forEach((card) => {
                const categoria = card.dataset.category;
                const titulo = card.dataset.title || '';
                const resumo = card.dataset.summary || '';

                const passaCategoria =
                    filtroAtual === 'todas' || categoria === filtroAtual;

                const passaBusca =
                    termo === '' ||
                    titulo.includes(termo) ||
                    resumo.includes(termo);

                card.hidden = !(passaCategoria && passaBusca);
            });
        }

        filtros.forEach((botao) => {
            botao.addEventListener('click', function () {
                filtros.forEach((item) => item.classList.remove('is-active'));
                this.classList.add('is-active');

                filtroAtual = this.dataset.filter;
                filtrarNoticias();
            });
        });

        if (busca) {
            busca.addEventListener('input', filtrarNoticias);
        }
    });
</script>