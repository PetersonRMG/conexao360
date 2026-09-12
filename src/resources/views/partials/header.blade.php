<header class="site-header">
    <div class="topo">

        {{-- MARCA --}}
        <div class="brand">
            <a href="{{ route('home') }}" class="brand-link" aria-label="Advocacia Exponencial - Início">
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

                {{-- INÍCIO --}}
                <li class="menu-item">

                    <a href="{{ route('home') }}"
                        class="menu-link {{ request()->routeIs('home') ? 'menu-link--active' : '' }}">
                        Início
                    </a>

                </li>


                {{-- O EVENTO --}}
                <li class="menu-item">

                    <a href="{{ route('page-evento') }}"
                        class="menu-link {{ request()->routeIs('page-evento') ? 'menu-link--active' : '' }}">
                        O Evento
                    </a>

                </li>


                {{-- PALESTRANTES --}}
                <li class="menu-item">

                    <a href="{{ route('page-palestrantes') }}" class="menu-link {{
    request()->routeIs('page-palestrantes')
    || request()->routeIs('page-palestrante')
    ? 'menu-link--active'
    : ''
                        }}">
                        Palestrantes
                    </a>

                </li>


                {{-- PROGRAMAÇÃO FUTURA --}}
                {{--

                <li class="menu-item">

                    <a href="{{ route('page-programacao') }}" class="menu-link {{
                            request()->routeIs('page-programacao')
                                ? 'menu-link--active'
                                : ''
                        }}">
                        Programação
                    </a>

                </li>

                --}}


                {{-- COMUNIDADE --}}
                <li class="menu-item">

                    <a href="{{ route('page-app') }}" class="menu-link {{
    request()->routeIs('page-app')
    ? 'menu-link--active'
    : ''
                        }}">
                        Comunidade
                    </a>

                </li>


                {{-- NOTÍCIAS --}}
                <li class="menu-item">

                    <a href="{{ route('page-noticias') }}" class="menu-link {{
    request()->routeIs('page-noticias')
    ? 'menu-link--active'
    : ''
                        }}">
                        Notícias
                    </a>

                </li>


                {{-- LINKS SECUNDÁRIOS --}}
                @php
                    $maisAtivo =
                        request()->is('experiencia')
                        || request()->is('depoimentos')
                        || request()->is('local')
                        || request()->is('faq')
                        || request()->is('contato');
                @endphp


                <li class="menu-item menu-item-more">

                    <details class="menu-more" {{ $maisAtivo ? 'open' : '' }}>

                        <summary class="menu-link menu-more-trigger {{
    $maisAtivo
    ? 'menu-link--active'
    : ''
                            }}">
                            Mais

                            <i class="bi bi-chevron-down"></i>
                        </summary>


                        <div class="menu-more-dropdown">

                            <a href="{{ url('/experiencia') }}" class="{{
    request()->is('experiencia')
    ? 'active'
    : ''
                                }}">
                                Experiência
                            </a>


                            <a href="{{ url('/depoimentos') }}" class="{{
    request()->is('depoimentos')
    ? 'active'
    : ''
                                }}">
                                Depoimentos
                            </a>


                            <a href="{{ url('/local') }}" class="{{
    request()->is('local')
    ? 'active'
    : ''
                                }}">
                                Local
                            </a>


                            <a href="{{ url('/faq') }}" class="{{
    request()->is('faq')
    ? 'active'
    : ''
                                }}">
                                FAQ
                            </a>


                            <a href="{{ url('/contato') }}" class="{{
    request()->is('contato')
    ? 'active'
    : ''
                                }}">
                                Contato
                            </a>

                        </div>

                    </details>

                </li>


                {{-- CTA PRINCIPAL --}}
                <li class="menu-item menu-item-cta">

                    <a href="{{ route('home') }}#ingressos" class="btn-rede-exclusiva">
                        Garantir ingresso
                    </a>

                </li>

            </ul>

        </nav>

    </div>
</header>