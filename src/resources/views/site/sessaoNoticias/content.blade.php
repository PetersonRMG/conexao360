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
                        <a href="{{ route('page-noticias.show', ['id' => $item['id']]) }}"
                           class="news-card-image"
>
                            @php
                                $imagemNoticia = \Illuminate\Support\Str::startsWith($item['imagem'], ['http://', 'https://'])
                                    ? $item['imagem']
                                    : asset($item['imagem']);
                            @endphp
                            <img
                                src="{{ $imagemNoticia }}"
                                alt="Imagem ilustrativa da notícia: {{ $item['titulo'] }}"
                                loading="lazy"
                                referrerpolicy="no-referrer"
                                onerror="this.onerror=null;this.src='{{ asset('conexao360/img/vista.png') }}';"
                            >

                            <span class="news-card-category">
                                {{ $item['categoria'] }}
                            </span>
                        </a>

                        <div class="news-card-content">
                            <span class="news-card-date">
                                {{ $item['data'] }} · Fonte: STJ
                            </span>

                            <h3>
                                <a href="{{ route('page-noticias.show', ['id' => $item['id']]) }}">
                                    {{ $item['titulo'] }}
                                </a>
                            </h3>

                            <p>{{ $item['resumo'] }}</p>

                            <a href="{{ route('page-noticias.show', ['id' => $item['id']]) }}"
                               class="news-card-link"
>
                                Ler mais <span>→</span>
                            </a>
                        </div>
                    </article>
                @endforeach

                @if ($noticias->isEmpty())
                    <p role="status" class="news-empty">
                        Não foi possível carregar as notícias no momento.
                        Tente novamente mais tarde.
                    </p>
                @endif

            </div>

            <p id="newsNoResults" role="status" hidden>
                Nenhuma notícia encontrada para sua busca.
            </p>

            <div class="news-pagination"
                 id="newsPagination"
                 role="navigation"
                 aria-label="Paginação das notícias"
                 hidden></div>

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
        const grid = document.getElementById('newsGrid');
        const cards = Array.from(document.querySelectorAll('.news-card'));
        const busca = document.getElementById('newsSearch');
        const paginacao = document.getElementById('newsPagination');
        const mensagemSemResultados = document.getElementById('newsNoResults');

        const porPagina = 6;
        let filtroAtual = 'todas';
        let paginaAtual = 1;

        function normalizarTexto(valor) {
            return String(valor || '')
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .toLocaleLowerCase('pt-BR');
        }

        function criarBotaoPagina(rotulo, pagina, ativo, desativado, icone) {
            const botao = document.createElement('button');
            botao.type = 'button';
            botao.disabled = desativado;

            if (ativo) {
                botao.classList.add('is-active');
                botao.setAttribute('aria-current', 'page');
            }

            if (icone) {
                const elementoIcone = document.createElement('i');
                elementoIcone.className = `bi bi-arrow-${icone}`;
                botao.appendChild(elementoIcone);
                botao.setAttribute(
                    'aria-label',
                    icone === 'left' ? 'Página anterior' : 'Próxima página'
                );
            } else {
                botao.textContent = String(rotulo);
                botao.setAttribute('aria-label', `Ir para página ${pagina}`);
            }

            botao.addEventListener('click', function () {
                if (desativado || pagina === paginaAtual) return;

                paginaAtual = pagina;
                renderizarNoticias();

                if (grid) {
                    grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });

            return botao;
        }

        function renderizarNoticias() {
            const termo = normalizarTexto(busca?.value.trim());

            const filtradas = cards.filter(function (card) {
                const categoria = card.dataset.category || '';
                const titulo = normalizarTexto(card.dataset.title);
                const resumo = normalizarTexto(card.dataset.summary);

                const passaCategoria =
                    filtroAtual === 'todas' || categoria === filtroAtual;

                const passaBusca =
                    termo === '' || titulo.includes(termo) || resumo.includes(termo);

                return passaCategoria && passaBusca;
            });

            const totalPaginas = Math.ceil(filtradas.length / porPagina);
            paginaAtual = Math.min(paginaAtual, Math.max(totalPaginas, 1));

            cards.forEach(function (card) {
                card.hidden = true;
            });

            const inicio = (paginaAtual - 1) * porPagina;
            filtradas.slice(inicio, inicio + porPagina).forEach(function (card) {
                card.hidden = false;
            });

            if (mensagemSemResultados) {
                // Se o feed falhar, a mensagem do Blade já informa a indisponibilidade.
                mensagemSemResultados.hidden =
                    cards.length === 0 || filtradas.length > 0;
            }

            if (!paginacao) return;

            paginacao.replaceChildren();
            // noticias.css usa display:flex; o inline garante esconder quando há apenas uma página.
            paginacao.style.display = totalPaginas <= 1 ? 'none' : 'flex';

            if (totalPaginas <= 1) return;

            paginacao.appendChild(
                criarBotaoPagina('Anterior', paginaAtual - 1, false, paginaAtual === 1, 'left')
            );

            for (let pagina = 1; pagina <= totalPaginas; pagina++) {
                paginacao.appendChild(
                    criarBotaoPagina(pagina, pagina, pagina === paginaAtual, false, null)
                );
            }

            paginacao.appendChild(
                criarBotaoPagina('Próxima', paginaAtual + 1, false, paginaAtual === totalPaginas, 'right')
            );
        }

        filtros.forEach(function (botao) {
            botao.addEventListener('click', function () {
                filtros.forEach(function (item) {
                    item.classList.remove('is-active');
                });

                botao.classList.add('is-active');
                filtroAtual = botao.dataset.filter || 'todas';
                paginaAtual = 1;
                renderizarNoticias();
            });
        });

        if (busca) {
            busca.addEventListener('input', function () {
                paginaAtual = 1;
                renderizarNoticias();
            });
        }

        renderizarNoticias();
    });
</script>
