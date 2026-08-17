<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&display=swap" rel="stylesheet">

<aside class="app-sidebar shadow-lg"
  style="background-color: #11141a; border-right: 1px solid #1e2330; transition: all 0.3s ease;" data-bs-theme="dark">

  <div class="sidebar-brand"
    style="border-bottom: 1px solid #1e2330; background-color: #0d0f14; padding: 1.5rem 1rem; height: auto;">
    <a href="{{ route('home') }}" target="_blank" target="_blank" rel="noopener noreferrer"
      class="brand-link d-flex flex-column align-items-center text-decoration-none gap-3">
{{-- 
      <span class="brand-text text-center"
        style="font-family: 'Cinzel', serif; font-weight: 500; font-size: 1.1rem; letter-spacing: 2px; color: #dfcaa0; text-shadow: 1px 1px 3px rgba(0,0,0,0.6); text-transform: uppercase; white-space: normal; line-height: 1.4;">
        Dashboard<br>Conexão 360
      </span> --}}
      <img src="{{ asset('conexao360/img/pint.svg') }}" alt="Logo" class="brand-image m-0"
        style="max-height: 48px; width: auto; filter: drop-shadow(0px 0px 8px rgba(223, 202, 160, 0.4)) brightness(1.3) contrast(1.1);" />
    </a>
  </div>
  <div class="sidebar-wrapper" style="padding: 0.75rem;">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column gap-1" data-lte-toggle="treeview" role="navigation"
        aria-label="Main navigation" data-accordion="false" id="navigation">

        <li class="nav-header px-3 mt-4 mb-2 text-uppercase fw-bold"
          style="font-size: 0.75rem; letter-spacing: 1.2px; color: #64748b;">
          Gerenciar Site
        </li>



        {{-- SUBMENU: Apontando para os IDs corretos dentro de content.blade.php --}}
        <li class="nav-item">
          <a href="{{ route('admin.modificar.site') }}"
            class="nav-link d-flex align-items-center rounded-3 px-3 py-2 text-white {{ Request::routeIs('admin.content') ? 'active' : '' }} sidebar-custom-hover">
            <i class="nav-icon bi bi-pencil-square me-2" style="font-size: 1.1rem; color: #94a3b8;"></i>
            <p class="mb-0">Modificações do Sites</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.depoimentos.index') }}"
            class="nav-link d-flex align-items-center rounded-3 px-3 py-2 text-white sidebar-custom-hover">
            <i class="nav-icon bi bi-chat-left-quote-fill me-2" style="font-size: 1.1rem; color: #94a3b8;"></i>
            <p class="mb-0">Depoimentos</p>
          </a>
        </li>
        <li class="nav-header px-3 mt-4 mb-2 text-uppercase fw-bold"
          style="font-size: 0.75rem; letter-spacing: 1.2px; color: #64748b; border-top: 1px solid #1e2330; padding-top: 1.25rem;">
          Rede Privada
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link d-flex align-items-center rounded-3 px-3 py-2 text-white sidebar-custom-hover">
            <i class="nav-icon bi bi-people-fill me-2" style="font-size: 1.1rem; color: #94a3b8;"></i>
            <p class="mb-0">Gerenciar Membros</p>
          </a>
        </li>


        {{-- MENU PRINCIPAL: CADASTROS --}}
        <li class="nav-item {{ Request::is('admin/cadastro*') ? 'menu-open' : '' }}">
          <a href="#"
            class="nav-link d-flex align-items-center justify-content-between rounded-3 px-3 py-2 text-white-50 sidebar-custom-hover">
            <div class="d-flex align-items-center">
              <i class="nav-icon bi bi-plus-circle-fill me-2" style="font-size: 1.1rem; color: #94a3b8;"></i>
              <p class="mb-0 text-white">Cadastros</p>
            </div>
            <i class="nav-arrow bi bi-chevron-right" style="font-size: 0.8rem; transition: transform 0.3s;"></i>
          </a>

          {{-- SUBMENU: Opções de Cadastro --}}
           <ul class="nav nav-treeview flex-column gap-1 mt-1 ps-2">
            {{-- Opção: Usuários --}}
            <li class="nav-item">
              <a href="#"
                class="nav-link d-flex align-items-center rounded-3 px-3 py-2 sidebar-subitem-custom ">
                {{-- {{ Request::routeIs('admin.cadastro.usuarios') ? 'active' : '' }}" --}}
                {{-- <i class="bi bi-people me-2" style="font-size: 0.95rem;"></i>
                <p class="mb-0">Usuários</p> --}}
              </a>
            </li> 

            {{-- Opção: Palestrantes --}}
            <li class="nav-item">
              <a 
              href="{{ route('admin.cadastro.palestrante') }}"
                class="nav-link d-flex align-items-center rounded-3 px-3 py-2 sidebar-subitem-custom ">
                <i class="bi bi-mic me-2" style="font-size: 0.95rem;"></i>
                <p class="mb-0">Palestrantes</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link d-flex align-items-center rounded-3 px-3 py-2 text-white sidebar-custom-hover">
            <i class="nav-icon bi bi-shield-exclamation me-2" style="font-size: 1.1rem; color: #94a3b8;"></i>
            <p class="mb-0">Moderar Publicações</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="route{{ '' }}" class="nav-link d-flex align-items-center rounded-3 px-3 py-2 text-white sidebar-custom-hover">
            <i class="nav-icon bi bi-gear-fill me-2" style="font-size: 1.1rem; color: #94a3b8;"></i>
            <p class="mb-0">Configurações da Rede</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>

{{-- ESTILOS EXTRAS PARA COMPLEMENTAR O LOOK PREMIUM --}}
<style>
  .sidebar-custom-hover {
    transition: all 0.2s ease-in-out !important;
  }

  .sidebar-custom-hover:hover {
    background-color: #1e2330 !important;
  }

  .sidebar-subitem-custom {
    color: #94a3b8 !important;
    font-size: 0.88rem;
    font-weight: 400;
    transition: all 0.2s ease-in-out !important;
    text-decoration: none !important;
    display: flex !important;
  }

  .sidebar-subitem-custom:hover {
    background-color: #1a1f2c !important;
    color: #dfcaa0 !important;
  }

  .subitem-active {
    background-color: rgba(223, 202, 160, 0.1) !important;
    color: #dfcaa0 !important;
    font-weight: 500 !important;
  }

  .nav-item>.nav-link {
    display: flex !important;
    align-items: center;
  }
</style>