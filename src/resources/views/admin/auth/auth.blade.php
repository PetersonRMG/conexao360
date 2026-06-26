<!doctype html>
<html lang="pt-br">
  <head>

    
    <style>
      /* Esconder totalmente links de acessibilidade/skip e o header padrão nesta tela */
      a[href*="skip"], .skip-link, [class*="skip"], header {
          display: none !important;
      }

      /* --------------------------------------------------------------------------
         1. ESTRUTURA SPLIT LAYOUT INVERTIDO (Esquerda / Direita)
         -------------------------------------------------------------------------- */
      body.login-page {
        background: #0d0d0d !important;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: #ffffff;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        display: flex;
        overflow-x: hidden;
      }

      .login-container-wrapper {
        display: flex;
        width: 100vw;
        min-height: 100vh;
        flex-direction: row;
      }

      /* Painel Esquerdo: Formulário de Login */
      .login-form-side {
        width: 480px;
        background: radial-gradient(circle at top, #351d4d, #08050c);
        display: flex;
        flex-direction: column; /* Alterado para empilhar o botão de voltar e o form */
        align-items: center;
        justify-content: center;
        padding: 40px;
        box-shadow: 10px 0 30px rgba(0, 0, 0, 0.5);
        position: relative;
        z-index: 2;
      }

      /* Botão Superior "Voltar ao Site" - Sofisticado e Discreto */
      .back-to-site {
        position: absolute;
        top: 30px;
        left: 40px;
        color: rgba(255, 255, 255, 0.6) !important;
        font-size: 13px;
        text-decoration: none !important;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
      }

      .back-to-site i, .back-to-site span.bi {
        font-size: 14px;
        transition: transform 0.3s ease;
      }

      .back-to-site:hover {
        color: #d4af37 !important; /* Transiciona para o dourado da marca */
      }

      .back-to-site:hover i, .back-to-site:hover span.bi {
        transform: translateX(-4px); /* Sutil movimento de recuo no ícone */
      }

      /* Painel Direito: Banner/Carrossel */
      .login-banner-side {
        flex: 1;
        position: relative;
        background: #121212;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 60px;
        overflow: hidden;
      }

      /* --------------------------------------------------------------------------
         2. APARÊNCIA DO CARROSSEL (Slides de Redes Exclusivas)
         -------------------------------------------------------------------------- */
      .slide-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        opacity: 0;
        transition: opacity 1s ease-in-out;
        z-index: 1;
      }

      .login-banner-side::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 2;
      }

      .slide-bg.active {
        opacity: 0.35;
      }

      .banner-content-wrapper {
        position: relative;
        z-index: 3;
        max-width: 600px;
      }

      .banner-tag {
        color: #d4af37;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 3px;
        font-weight: 700;
        margin-bottom: 15px;
        display: inline-block;
      }

      .banner-text-slide {
        display: none;
      }

      .banner-text-slide.active {
        display: block;
        animation: fadeInUp 0.6s ease forwards;
      }

      .banner-content-wrapper h2 {
        font-size: 32px;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 15px;
        color: #fff;
      }

      .banner-content-wrapper p {
        color: #a3a3a3;
        font-size: 16px;
        line-height: 1.5;
        margin: 0;
      }

      .carousel-indicators-custom {
        display: flex;
        gap: 8px;
        margin-top: 40px;
      }

      .indicator-bar {
        width: 30px;
        height: 3px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 2px;
        transition: all 0.3s ease;
      }

      .indicator-bar.active {
        background: #d4af37;
        width: 50px;
      }

      /* --------------------------------------------------------------------------
         3. IDENTIDADE DO CARD DE LOGIN (Efeito Vidro Refinado)
         -------------------------------------------------------------------------- */
      .login-box {
        width: 100%;
        max-width: 360px;
      }

      .login-logo {
        text-align: center;
        margin-bottom: 30px;
      }

      .login-logo a {
        color: #ffffff !important;
        font-size: 22px;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-decoration: none !important;
        line-height: 1.2;
        display: inline-block;
      }

      .login-logo a span {
        color: #d4af37;
        font-weight: 800;
      }

      .login-logo p.subtitle {
        color: #a3a3a3;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin: 5px 0 0 0;
      }

      .login-box .card {
        background: rgba(255, 255, 255, 0.02) !important;
        border: 1px solid rgba(212, 175, 55, 0.12) !important;
        border-radius: 12px !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4) !important;
      }

      .login-card-body {
        background: transparent !important;
        padding: 35px 25px !important;
      }

      .login-box-msg {
        color: #c5c5c5 !important;
        font-size: 14px;
        text-align: center;
        margin-bottom: 25px;
        padding: 0 !important;
      }

      /* Inputs Customizados */
      .input-group {
        margin-bottom: 20px !important;
        border-radius: 6px;
        overflow: hidden;
      }

      .input-group .form-control {
        background-color: rgb(255 255 255 / 70%) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        color: #ffffff !important;
        padding: 12px 15px;
        font-size: 14px;
      }

      .input-group .input-group-text {
        background-color: rgba(20, 20, 20, 0.9) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-left: none !important;
        color: #d4af37 !important;
        padding-left: 15px;
        padding-right: 15px;
      }

      .input-group .form-control:focus {
        border-color: rgba(212, 175, 55, 0.4) !important;
        box-shadow: none !important;
      }

      /* Botão Metálico Dourado */
      .btn-primary-custom {
        background: linear-gradient(135deg, #d4af37 0%, #b89327 100%) !important;
        border: none !important;
        color: #0d0d0d !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 13px;
        padding: 12px;
        border-radius: 6px;
        transition: all 0.3s ease;
        cursor: pointer;
        width: 100%;
      }

      .btn-primary-custom:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 20px rgba(212, 175, 55, 0.35) !important;
      }

      .form-check-label { color: #a3a3a3; font-size: 13px; }
      .form-check-input { background-color: rgba(20, 20, 20, 0.6) !important; border: 1px solid rgba(255, 255, 255, 0.2) !important; }
      .form-check-input:checked { background-color: #d4af37 !important; border-color: #d4af37 !important; }
      .forgot-link { color: #a3a3a3 !important; font-size: 13px; text-decoration: none; display: inline-block; margin-top: 15px; }
      .forgot-link:hover { color: #d4af37 !important; }

      /* Alertas */
      .alert { border-radius: 6px !important; font-size: 13px !important; padding: 10px 15px !important; background-color: rgba(220, 53, 69, 0.15) !important; border: 1px solid rgba(220, 53, 69, 0.3) !important; color: #ea868f !important; }

      @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
      }

      /* RESPONSIVIDADE */
      @media (max-width: 991.98px) {
        .login-banner-side { display: none; }
        .login-form-side { width: 100%; }
        .back-to-site { left: 20px; top: 20px; }
      }
    </style>
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
