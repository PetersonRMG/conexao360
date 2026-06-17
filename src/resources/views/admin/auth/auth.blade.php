<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    @include('admin.partialsAdmin.head')

  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="login-page bg-body-secondary">

    <div class="login-box">
      <div class="login-logo">
        <a href="">DaVilla</a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in to start your session</p>

          @if(session('error'))
            <div class="alert alert-danger" role="alert">
            {{ session('error') }} 
            
            </div>
          @endif
          @if($errors->any())
            <div class="alert alert-warning" role="alert">
                Verifique os dados (Email / Senha)
            
            </div>
          @endif 
        
        
        

          <form action="{{ route('admin.login.autenticar') }}" method="post">
            
          @csrf
            <div class="input-group mb-3">
              <input type="email" name="email_usuario" class="form-control" placeholder="Email" />
              <div class="input-group-text">
                <span class="bi bi-envelope"></span>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="senha_usuario" class="form-control" placeholder="Senha" />
              <div class="input-group-text">
                <span class="bi bi-lock-fill"></span>
              </div>
            </div>
            <!--begin::Row-->
            <div class="row">
              <div class="col-8">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                  <label class="form-check-label" for="flexCheckDefault"> Remember Me </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary">Login</button>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->
          </form>

          <div class="social-auth-links text-center mb-3 d-grid gap-2">
                <p>- OR -</p>
                {{-- <a href="#" class="btn btn-primary">
                <i class="bi bi-facebook me-2"></i> Sign in using Facebook
                </a> 
                <a href="#" class="btn btn-danger">
                <i class="bi bi-google me-2"></i> Sign in using Google+
                </a>
                --}}
          </div>
          <!-- /.social-auth-links -->

          <p class="mb-1">
            <a href="forgot-password.html">I forgot my password</a>
          </p>
          <p class="mb-0">
            <a href="register.html" class="text-center"> Register a new membership </a>
          </p>
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->

    @include('admin.partialsAdmin.scripts')
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);

        // Disable OverlayScrollbars on mobile devices to prevent touch interference
        const isMobile = window.innerWidth <= 992;

        if (
          sidebarWrapper &&
          OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
          !isMobile
        ) {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
