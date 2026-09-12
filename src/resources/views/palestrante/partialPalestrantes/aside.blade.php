@php
  $rotaVideosExiste =
    \Illuminate\Support\Facades\Route::has(
      'admin.palestrante.video.index'
    );

  $rotaEnquetesExiste =
    \Illuminate\Support\Facades\Route::has(
      'admin.palestrante.enquete.index'
    );
@endphp

<aside class="app-sidebar admin-sidebar speaker-sidebar" data-bs-theme="dark">

  <div class="sidebar-brand admin-sidebar-brand">

    <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="brand-link admin-sidebar-brand-link">

      <img src="{{ asset('conexao360/img/pint.svg') }}" alt="Advocacia Exponencial"
        class="brand-image admin-sidebar-logo">

      <div class="admin-sidebar-brand-copy">

        <span>
          Advocacia
        </span>

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
          Minha Área
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

          <a href="{{ route('admin.palestrante.perfil.index') }}"
            class="nav-link admin-sidebar-link {{ Request::routeIs('admin.palestrante.perfil.*') ? 'active' : '' }}">

            <i class="nav-icon bi bi-person-vcard-fill"></i>

            <p>
              Meu Perfil
            </p>

          </a>

        </li>


        <li class="nav-header admin-sidebar-section admin-sidebar-section--divided">
          Conteúdo
        </li>


        <li class="nav-item">

          @if ($rotaVideosExiste)

            <a href="{{ route('admin.palestrante.video.index') }}"
              class="nav-link admin-sidebar-link {{ Request::routeIs('admin.palestrante.video.*') ? 'active' : '' }}">

              <i class="nav-icon bi bi-play-btn-fill"></i>

              <p>
                Vídeos
              </p>

            </a>

          @else

            <a href="#" onclick="return false;" class="nav-link admin-sidebar-link speaker-sidebar-link--disabled"
              aria-disabled="true">

              <i class="nav-icon bi bi-play-btn-fill"></i>

              <p>
                Vídeos
                <span class="speaker-sidebar-soon">
                  próximo
                </span>
              </p>

            </a>

          @endif

        </li>


        <li class="nav-item">

          @if ($rotaEnquetesExiste)

            <a href="{{ route('admin.palestrante.enquete.index') }}"
              class="nav-link admin-sidebar-link {{ Request::routeIs('admin.palestrante.enquete.*') ? 'active' : '' }}">

              <i class="nav-icon bi bi-bar-chart-steps"></i>

              <p>
                Enquetes
              </p>

            </a>

          @else

            <a href="#" onclick="return false;" class="nav-link admin-sidebar-link speaker-sidebar-link--disabled"
              aria-disabled="true">

              <i class="nav-icon bi bi-bar-chart-steps"></i>

              <p>
                Enquetes
                <span class="speaker-sidebar-soon">
                  próximo
                </span>
              </p>

            </a>

          @endif

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