<!doctype html>
<html lang="pt-br">
  <head>
     <link rel="stylesheet" href="{{asset('dash/css/dash.css')}}">
    

  </head>
  
  <body class="login-page">

    <div class="login-container-wrapper">
      
      <!-- ================= PAINEL ESQUERDO: LOGIN CENTRALIZADO ================= -->
      <div class="login-form-side">
        
        <!-- Link de Retorno ao Site Principal (Altere o href para a rota home do seu site, ex: "/") -->
        <a href="{{ route('home') }}" class="back-to-site">
          <span class="bi bi-arrow-left"></span> Voltar ao site
        </a>

        <div class="login-box">
          
          <div class="login-logo">
            <a href="#">ADVOCACIA <br> E<span>X</span>PONENCIAL</a>
            <p class="subtitle">Rede Exclusiva</p>
          </div>
          
          <div class="card">
            <div class="login-card-body">
              <p class="login-box-msg">Acesse sua conta para iniciar a sessão</p>

              @if(session('error'))
                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
              @endif
              
              @if($errors->any())
                <div class="alert alert-warning" role="alert">Verifique seus dados de acesso.</div>
              @endif 

              <form action="{{ route('admin.login.autenticar') }}" method="post">
                @csrf
                
                <div class="input-group">
                  <input type="email" name="email_usuario" class="form-control" placeholder="E-mail" required />
                  <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                </div>
                
                <div class="input-group">
                  <input type="password" name="senha_usuario" class="form-control" placeholder="Senha" required />
                  <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                </div>
                
                <div class="row align-items-center mt-4">
                  <div class="col-7">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="remember" />
                      <label class="form-check-label" for="flexCheckDefault"> Lembrar de mim </label>
                    </div>
                  </div>
                  <div class="col-5">
                    <button type="submit" class="btn-primary-custom">Entrar</button>
                  </div>
                </div>
              </form>

              <div class="text-center mt-3">
                <a href="#" class="forgot-link">Esqueceu sua senha?</a>
              </div>
              
            </div>
          </div>

        </div>
      </div>

      <!-- ================= PAINEL DIREITO: BANNER INSTITUCIONAL ================= -->
      <div class="login-banner-side">
        <div class="slide-bg active" style="background-image: url('https://images.unsplash.com/photo-1589829545856-d10d557cf95f?q=80&w=1200');"></div>
        <div class="slide-bg" style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1200');"></div>
        <div class="slide-bg" style="background-image: url('https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=1200');"></div>

        <div class="banner-content-wrapper">
          <span class="banner-tag">Network de Alto Valor</span>
          
          <div class="banner-text-slide active">
            <h2>Conecte-se à Elite da Advocacia</h2>
            <p>Um ecossistema exclusivo projetado para grandes tomadores de decisão e juristas de alta performance compartilharem inteligência de negócios.</p>
          </div>

          <div class="banner-text-slide">
            <h2>Conhecimento Exponencial</h2>
            <p>Tenha acesso direto a insights das palestras, conteúdos restritos e conexões estratégicas que aceleram o crescimento do seu escritório.</p>
          </div>

          <div class="banner-text-slide">
            <h2>Parcerias Estratégicas</h2>
            <p>O ambiente ideal para fechar alianças, debater teses complexas e expandir sua atuação no mercado jurídico nacional.</p>
          </div>

          <div class="carousel-indicators-custom">
            <div class="indicator-bar active"></div>
            <div class="indicator-bar"></div>
            <div class="indicator-bar"></div>
          </div>
        </div>
      </div>

    </div>

    @include('admin.partialsAdmin.scripts')
    
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const backgrounds = document.querySelectorAll('.slide-bg');
        const textSlides = document.querySelectorAll('.banner-text-slide');
        const indicators = document.querySelectorAll('.indicator-bar');
        let currentSlide = 0;
        const slideInterval = 5000;

        function nextSlide() {
          backgrounds[currentSlide].classList.remove('active');
          textSlides[currentSlide].classList.remove('active');
          indicators[currentSlide].classList.remove('active');

          currentSlide = (currentSlide + 1) % backgrounds.length;

          backgrounds[currentSlide].classList.add('active');
          textSlides[currentSlide].classList.add('active');
          indicators[currentSlide].classList.add('active');
        }

        setInterval(nextSlide, slideInterval);
      });
    </script>
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
  </body>
</html>
