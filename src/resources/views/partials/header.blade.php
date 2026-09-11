<header class="site-header">
    <div class="topo">

        {{-- MARCA --}}
        <div class="brand">
            <a href="{{ url('/') }}" class="brand-link" aria-label="Advocacia Exponencial - Início">
                <img src="{{ asset('conexao360/img/pint.svg') }}" alt="" class="brand-logo" width="42" height="42"
                    decoding="async">

                <h5 class="brand-name">
                    ADVOCACIA <br>
                    E<span>X</span>PONENCIAL
                </h5>
            </a>
        </div>

        {{-- MOBILE --}}
        <button class="abrir-menu" type="button" aria-label="Abrir menu" aria-controls="menu-principal"
            aria-expanded="false">
            <span></span>
        </button>

        {{-- NAVEGAÇÃO --}}
        <nav id="menu-principal" class="menu-principal" aria-label="Navegação principal">

            <button class="fechar-menu" type="button" aria-label="Fechar menu"></button>

            <ul class="fechar menu-lista">

                <li class="menu-item">
                    <a href="{{ url('/') }}" class="menu-link menu-link--active">
                        Início
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ url('/evento') }}" class="menu-link">
                        O Evento
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('page-palestrantes') }}" class="menu-link">
                        Palestrantes
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ url('/programacao') }}" class="menu-link">
                        Programação
                    </a>
                </li>

                <li class="menu-item">
                    <a  href="{{ route('page-app') }}"  class="menu-link">
                        Comunidade
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ url('/noticias') }}" class="menu-link">
                        Notícias
                    </a>
                </li>

                {{-- LINKS SECUNDÁRIOS --}}
                <li class="menu-item menu-item-more">
                    <details class="menu-more">
                        <summary class="menu-link menu-more-trigger">
                            Mais
                            <i class="bi bi-chevron-down"></i>
                        </summary>

                        <div class="menu-more-dropdown">
                            <a href="{{ url('/experiencia') }}">Experiência</a>
                            <a href="{{ url('/depoimentos') }}">Depoimentos</a>
                            <a href="{{ url('/local') }}">Local</a>
                            <a href="{{ url('/faq') }}">FAQ</a>
                            <a href="{{ url('/contato') }}">Contato</a>
                        </div>
                    </details>
                </li>

                {{-- CTA PRINCIPAL --}}
                <li class="menu-item menu-item-cta">
                    <a href="#ingressos" class="btn-rede-exclusiva">
                        Garantir ingresso
                    </a>
                </li>

            </ul>
        </nav>

    </div>
</header>