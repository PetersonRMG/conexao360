<aside class="app-sidebar admin-sidebar speaker-sidebar" data-bs-theme="dark">

  <div class="sidebar-brand admin-sidebar-brand">

    <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="brand-link admin-sidebar-brand-link">
      <img src="{{ asset('conexao360/img/pint.svg') }}" alt="Advocacia Exponencial"
        class="brand-image admin-sidebar-logo">

      <div class="admin-sidebar-brand-copy">
        <span>Advocacia</span>

        <strong>
          E<span>X</span>ponencial
        </strong>

        <small>
          Área do Palestrante
        </small>
      </div>

    </a>

  </div>


  <div class="sidebar-wrapper admin-sidebar-wrapper">

    <nav class="mt-2">

      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
        aria-label="Navegação do palestrante" data-accordion="false" id="navigation">

        <li class="nav-header admin-sidebar-section">
          Área do Palestrante
        </li>


        <li class="nav-item">

          <a href="{{ route('admin.palestrante.dash') }}"
            class="nav-link admin-sidebar-link {{ Request::routeIs('admin.palestrante.dash') ? 'active' : '' }}">
            <i class="nav-icon bi bi-grid-1x2-fill"></i>

            <p>
              Visão Geral
            </p>
          </a>

        </li>


        <li class="nav-item">

          <a href="{{ route('admin.palestrante.depoimento.index') }}"
            class="nav-link admin-sidebar-link {{ Request::routeIs('admin.palestrante.depoimento.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-chat-left-quote-fill"></i>

            <p>
              Depoimentos
            </p>
          </a>

        </li>


        <li class="nav-header admin-sidebar-section admin-sidebar-section--divided">
          Acesso
        </li>


        <li class="nav-item">

          <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer"
            class="nav-link admin-sidebar-link admin-sidebar-link--external">
            <i class="nav-icon bi bi-globe2"></i>

            <p>
              Site Oficial
            </p>
          </a>

        </li>

      </ul>

    </nav>

  </div>

</aside>