<header class="site-header">
    <div class="topo">

        <div class="brand">
            <a href="{{ route('admin.dash') }}" class="brand-link">
                <img src="{{ asset('conexao360/img/pint.svg') }}" alt="Logo" class="brand-logo" width="46" height="46"
                    decoding="async">

                <h5 class="brand-name">
                    ADVOCACIA <br>
                    E<span>X</span>PONENCIAL
                </h5>
            </a>
        </div>

        <button class="abrir-menu" type="button" aria-label="Abrir menu" aria-controls="menu-principal"
            aria-expanded="false">
            <span></span>
        </button>

        <nav id="menu-principal" class="menu-principal" aria-label="Navegação principal">

            <button class="fechar-menu" type="button" aria-label="Fechar menu"></button>

            <ul class="fechar menu-lista">

                <li class="menu-item">
                    <a href="#palestra" class="menu-link">
                        Palestra
                    </a>
                </li>

                <li class="menu-item">
                    <a href="#depoimento" class="menu-link">
                        Depoimentos
                    </a>
                </li>

                <li class="menu-item">
                    <a href="#ingressos" class="menu-link">
                        Ingressos
                    </a>
                </li>

                <li class="menu-item menu-item-cta">
                    <a href="{{ route('admin.dash') }}" target="_blank" rel="noopener noreferrer"
                        class="btn-rede-exclusiva">
                        Rede Exclusiva
                    </a>
                </li>

            </ul>
        </nav>

    </div>
</header>