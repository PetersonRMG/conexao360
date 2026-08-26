<aside class="app-sidebar admin-sidebar" data-bs-theme="dark">

  <div class="sidebar-brand admin-sidebar-brand">

    <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="brand-link admin-sidebar-brand-link">
      <img src="{{ asset('conexao360/img/pint.svg') }}" alt="Logo" class="brand-image admin-sidebar-logo">

      <div class="admin-sidebar-brand-copy">
        <span>Advocacia</span>
        <strong>E<span>X</span>ponencial</strong>
        <small>Painel Administrativo</small>
      </div>
    </a>

  </div>


  <div class="sidebar-wrapper admin-sidebar-wrapper">

    <nav class="mt-2">

      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation"
        data-accordion="false" id="navigation">

        <li class="nav-header admin-sidebar-section">
          Gerenciar Site
        </li>


        <li class="nav-item">

          <a href="{{ route('admin.modificar.site') }}"
            class="nav-link admin-sidebar-link {{ Request::routeIs('admin.modificar.site') ? 'active' : '' }}">
            <i class="nav-icon bi bi-pencil-square"></i>

            <p>Modificações do Site</p>
          </a>

        </li>


        <li class="nav-item">

          <a href="{{ route('admin.depoimentos.index') }}"
            class="nav-link admin-sidebar-link {{ Request::routeIs('admin.depoimentos.*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-chat-left-quote-fill"></i>

            <p>Depoimentos</p>
          </a>

        </li>


        <li class="nav-header admin-sidebar-section admin-sidebar-section--divided">
          Rede Privada
        </li>


        <li class="nav-item">

          <a href="#" class="nav-link admin-sidebar-link">
            <i class="nav-icon bi bi-people-fill"></i>

            <p>Gerenciar Membros</p>
          </a>

        </li>


        <li class="nav-item {{ Request::is('admin/cadastro*') ? 'menu-open' : '' }}">

          <a href="#" class="nav-link admin-sidebar-link admin-sidebar-tree-link">

            <div class="admin-sidebar-tree-label">
              <i class="nav-icon bi bi-plus-circle-fill"></i>

              <p>Cadastros</p>
            </div>

            <i class="nav-arrow bi bi-chevron-right"></i>

          </a>


          <ul class="nav nav-treeview flex-column admin-sidebar-submenu">

            {{-- Opção de Usuários preservada como placeholder do projeto. --}}
            <li class="nav-item">
              <a href="#" class="nav-link sidebar-subitem-custom admin-sidebar-subitem"></a>
            </li>


            <li class="nav-item">

              <a href="{{ route('admin.cadastro.palestrante') }}"
                class="nav-link sidebar-subitem-custom admin-sidebar-subitem {{ Request::routeIs('admin.cadastro.palestrante') ? 'active' : '' }}">
                <i class="bi bi-mic"></i>

                <p>Palestrantes</p>
              </a>

            </li>

          </ul>

        </li>


        <li class="nav-item">

          <a href="#" class="nav-link admin-sidebar-link">
            <i class="nav-icon bi bi-shield-exclamation"></i>

            <p>Moderar Publicações</p>
          </a>

        </li>


        <li class="nav-item">

          <a href="#" class="nav-link admin-sidebar-link">
            <i class="nav-icon bi bi-gear-fill"></i>

            <p>Configurações da Rede</p>
          </a>

        </li>

      </ul>

    </nav>

  </div>

</aside>