<section class="header-advocacia">
    <div class="container">
        <div class="logo-container"></div>

        <div class="tds-header">
            <p class="tit-header"> — INSCRIÇÕES ABERTAS • VAGAS LIMITADAS — </p>

            <h1 class="sub-tit">
                a virada de chave <br> da advocacia <br> exponencial
            </h1>

            <p class="descricao-header">
                Participe da 3ª Edição do Conexão 360º e dê a <br> Virada de Chave na Sua Carreira na Advocacia.
            </p>
            <a href="https://sun.eduzz.com/Q9N56RAK01" class="cta-header" target="_blank">
                Garantir minha vaga no Conexão 360º
            </a>
        </div>
    </div>
</section>

<section class="conexao-container">
    <div class="conexao-carousel" id="conexaoCarousel">
        
        <div class="conexao-slide active-slide" style="background-image: url('{{ asset('conexao360/img/Mídia (1).jpg') }}');">
            <div class="conexao-content">
                <img src="{{ asset('conexao360/img/pint.svg') }}" alt="Logo" width="200px">
                <h2>Conexão 360º</h2>
                <h3>ADVOCACIA <br> E<span>X</span>PONENCIAL</h3>
                <h4>3ª EDIÇÃO</h4>
            </div>
        </div>

        <div class="conexao-slide" style="background-image: url('{{ asset('conexao360/img/captura.png')}}');">
            <div class="conexao-content">
                <img src="{{ asset('conexao360/img/pint.svg') }}" alt="Logo" width="200px">
                <h2>Networking de Elite</h2>
                <h3>CONEXÕES <br> E<span>X</span>CLUSIVAS</h3>
                <h4>VAGAS LIMITADAS</h4>
            </div>
        </div>

        <div class="conexao-slide" style="background-image: url('{{ asset('conexao360/img/Mídia (1).jpg') }}');">
            <div class="conexao-content">
                <img src="{{ asset('conexao360/img/pint.svg') }}" alt="Logo" width="200px">
                <h2>Imersão Prática</h2>
                <h3>MENTORIA <br> E<span>X</span>STRATÉGICA</h3>
                <h4>PRÓXIMO EVENTO</h4>
            </div>
        </div>

    </div>
</section>

<section id="palestra" class="palestra">
    <div class="teste">
        @foreach ($video as $item)
            <div class="conteudo">
                <h2>{{ $item->titulo_video }}</h2>

                <span class="tag">Palestra Exclusiva</span>

                <p>
                    {{ $item->subtitulo_video }}
                </p>

                <ul>
                    <li>Com método, clareza e direção estratégica</li>
                    <li>Sem promessas vazias</li>
                    <li>Sem atalhos irreais</li>
                </ul>
            </div>

            <div class="imagem">
                <a class="data-lity" href="{{ asset('conexao360/img/' . $item->url_video) }}" data-lity>
                    <img src="{{ asset('conexao360/img/' . $item->capa_video) }}" alt="Palestra advocacia">
                    <span class="play-btn">
                        <span class="play-icon"></span>
                    </span>
                </a>
                <div>
                    <p class="tit-video"> — {{ $item->legenda_video }} — </p>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section class="abordagem">
    <div class="tds-abordagem">
        <div class="coluna-esquerda">
            <h2 class="title">O que você vai ativar<br> no conexão 360° </h2>
            <h3 class="sub-title">( Não é conteúdo. É virada de chave )</h3>
            @foreach ($temas as $item)
                <div class="card">
                    <span class="card-text">{{ $item->titulo_tema }}</span>
                    <h3>{{ $item->subtitulo_tema }} <br> <br> - {{ $item->breve_descricao_tema }}.</h3>
                </div>
            @endforeach
        </div>

        <div class="coluna-direita">
            <div class="circulo-tds">
                <div class="center-circle">
                    <div class="inner-text">
                        Conexão<br><span>360º</span>
                    </div>
                </div>

                <a href="#item1">
                    <div class="orbit-item t1"><span>Mentalidade</span></div>
                </a>
                <div class="orbit-item t2"><span>Posicionamento</span></div>
                <div class="orbit-item t3"><span>Ambiência & Performance</span></div>
                <div class="orbit-item t4"><span>Atendimento Consultivo</span></div>
                <div class="orbit-item t5"><span>Postura Profissional</span></div>
                <div class="orbit-item t6"><span>Conversão com Segurança</span></div>
            </div>
        </div>
    </div>
</section>

<section class="abordagem-mobile">
    <div class="tds-abordagem">
        <div class="coluna-esquerda">
            <h2 class="title">O que você vai ativar<br> no conexão 360° </h2>
            <h3 class="sub-title">( Não é conteúdo. É virada de chave )</h3>
            @foreach ($temas as $item)
                <a href="#{{ $item->id_tema }}" data-lity style="text-decoration: none; color: inherit; display: block;">
                    <div class="card">
                        <span class="card-text">{{ $item->titulo_tema }}</span>
                        
                        <h3 class="card-text-lity" id="{{ $item->id_tema }}"> 
                            <img src="{{ asset('conexao360/img/' . $item->foto_tema) }}" alt="{{ $item->titulo_tema }}">
                            <br> <br>{{ $item->titulo_tema }} <br> <br> - {{ $item->breve_descricao_tema }}.
                        </h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="sobre">
    <div class="container">
        <h2 class="titulo">Uma Referência na Advocacia</h2>
        <h4>A Mente que Provoca Mudança</h4>

        <div class="sobre-tds">
            @foreach ($dra as $item)
                <div class="ajst-img">
                    <img src="{{ asset('conexao360/img/' . $item->foto_dra) }}" alt="Dra. Simone Baptista">
                </div>

                <div class="sobre-info">
                    <h3>{{ $item->titulo_dra }}</h3>
                    <h4>{{ $item->sub_titulo_dra }}</h4>
                    <p>{{ $item->descricao_dra }}</p>
                </div> 
            @endforeach
        </div> 
    </div>
</section>

<section id="depoimento" class="depoimentos">
    <h2 class="titulo">
        A Voz de Quem Já Esteve Lá 
        <span>O que profissionais da advocacia dizem sobre as palestras anteriores</span>
    </h2>

    <div class="caixa-car">
        <div class="carrosel" id="carousel">
            
            <div class="card-item">
                <div class="texto-depoimentos">
                    <p class="depoimento-texto">
                        O método apresentado transformou radicalmente a visão estratégica do nosso escritório. A clareza e a profundidade dos conteúdos entregues superaram todas as expectativas.
                    </p>
                    
                    <div class="footer-card">
                        <div class="divisao"></div>
                        <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?q=80&w=150" alt="Avatar" class="img-advo">
                        <h3>Dr. Guilherme Ramos</h3>
                        <h4>Advogado Associado</h4>
                    </div>
                </div>
            </div>

            <div class="card-item">
                <div class="texto-depoimentos">
                    <p class="depoimento-texto">
                        Conexões de altíssimo valor. O ambiente exclusivo nos proporcionou parcerias que já estão gerando grandes resultados operacionais neste trimestre.
                    </p>
                    
                    <div class="footer-card">
                        <div class="divisao"></div>
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=150" alt="Avatar" class="img-advo">
                        <h3>Dra. Mariana Souza</h3>
                        <h4>Sócio-Diretora</h4>
                    </div>
                </div>
            </div>

            <div class="card-item">
                <div class="texto-depoimentos">
                    <p class="depoimento-texto">
                        Uma imersão indispensável para quem busca posição premium no mercado jurídico. Recomendo fortemente a todos os líderes de bancas estruturadas.
                    </p>
                    
                    <div class="footer-card">
                        <div class="divisao"></div>
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=150" alt="Avatar" class="img-advo">
                        <h3>Dr. Roberto Kalil</h3>
                        <h4>Consultor Jurídico</h4>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="local_sessao">
    <div class="container">
        <h2 class="tit_local">Sua transformação tem hora e lugar marcados</h2>

        <div class="local-cont">
            <div class="mapa">
                <div class="mapa-container-link" style="position: relative;">
                    <a href="https://maps.google.com" target="_blank" class="mapa-botao">Ver no Google Maps</a>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!4v1770671449477!6m8!1m7!1sfyHhGVpN2cpdkC8-XjOdgA!2m2!1d-23.50074578412579!2d-46.84116819281623!3f190.46136!4f0!5f0.7820865974627469"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <div class="event-info">
                <div class="info-item">
                    <div class="info-icon">
                        <img src="{{ asset('conexao360/img/icones_adv (8).svg') }}" alt="Calendário">
                    </div>
                    <div class="info-text">
                        <strong>Data e Horário:</strong>
                        <p> 14 e 15 de Março de 2026, às 19h.</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <img src="{{ asset('conexao360/img/icones_adv (9).svg') }}" alt="Localização">
                    </div>
                    <div class="info-text">
                        <strong>Localização Evento:</strong>
                        <p> Alameda Araguaia 2104 - Alphaville industrial </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="ingressos" class="cta-sessao">
    <div class="plano"></div>
    <div class="container cta-container">
        <h2>O próximo nível da sua carreira jurídica é uma decisão estratégica.</h2>

        <div class="divisao-short"></div>

        <div class="countdown-container">
            <div class="countdown-item">
                <span id="days">00</span>
                <p>Dias</p>
            </div>

            <div class="countdown-divider">:</div>

            <div class="countdown-item">
                <span id="hours">00</span>
                <p>Horas</p>
            </div>

            <div class="countdown-divider">:</div>

            <div class="countdown-item">
                <span id="minutes">00</span>
                <p>Minutos</p>
            </div>

            <div class="countdown-divider">:</div>

            <div class="countdown-item">
                <span id="seconds">00</span>
                <p>Segundos</p>
            </div>
        </div>

        <p>
            Saia do operacional exaustivo e assuma o controle da sua advocacia com o método de quem vive a prática
            real todos os dias.
        </p>

        <a href="https://sun.eduzz.com/Q9N56RAK01" class="cta-botao">
            Garantir meu ingresso <span>›</span>
        </a>
    </div>
</section>

<style>
/* ==========================================================================
   BANNER HERO - CARROSSEL DINÂMICO (CONEXÃO 360)
   ========================================================================== */
.conexao-container {
    width: 100%;
    position: relative;
    overflow: hidden;
    line-height: 0; /* Remove espaços vazios causados por elementos inline/block inline */
}

/* Força o Slick a ocupar exatamente o tamanho do container sem deixar rebarbas */
.conexao-container .slick-list,
.conexao-container .slick-track {
    height: 100% !important;
}

.conexao-carousel {
    width: 100%;
    display: flex;
    margin-bottom: 0 !important; /* Garante que o carrossel não empurre a próxima seção */
}

.conexao-slide {
    width: 100%;
    height: 800px; 
    background-size: cover; 
    background-position: center;
    background-repeat: no-repeat;
    display: flex !important;
    align-items: center;
    justify-content: center;
    position: relative;
}



.conexao-content {
    position: relative;
    z-index: 2;
    text-align: center;
    padding: 0 20px;
    width: 100%;
    line-height: normal; /* Restaura o espaçamento de texto correto dentro do slide */
}

/* AJUSTE DE CENTRALIZAÇÃO DO LOGO SVG */
.conexao-content img {
    display: block;
    margin: 0 auto 20px auto; 
    max-width: 100%;
    height: auto;
}

.conexao-content h2 {
    font-size: 2.5rem;
    color: #fff;
    margin-top: 20px;
    font-family: 'Playfair Display', serif;
    letter-spacing: 2px;
}

.conexao-content h3 {
    font-size: 4rem;
    color: #d6b26a; 
    font-family: 'Playfair Display', serif;
    line-height: 1.1;
    margin: 15px 0;
    font-weight: 700;
}

.conexao-content h3 span {
    color: #fff;
}

.conexao-content h4 {
    font-size: 1.5rem;
    color: #9d9a9a;
    font-family: 'Montserrat', sans-serif;
    letter-spacing: 4px;
    text-transform: uppercase;
}

/* Customização dos pontos de navegação (Dots) do Carrossel */
.conexao-container .slick-dots {
    bottom: 30px;
    position: absolute;
    width: 100%;
    text-align: center;
    padding: 0;
    margin: 0;
    list-style: none;
    z-index: 5;
}

.conexao-container .slick-dots li {
    display: inline-block;
    margin: 0 6px;
}

.conexao-container .slick-dots li button {
    width: 12px;
    height: 12px;
    padding: 0;
    background: rgba(255, 255, 255, 0.3);
    border: none;
    border-radius: 50%;
    text-indent: -9999px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.conexao-container .slick-dots li.slick-active button {
    background: #d6b26a;
    transform: scale(1.2);
}

/* Remove folgas que possam existir na seção seguinte (#palestra) */
#palestra {
    margin-top: 0 !important;
    padding-top: 60px; /* Ajuste o padding do topo caso queira mais ou menos respiro para o conteúdo da palestra */
}

@media (max-width: 768px) {
    .conexao-content h2 { font-size: 1.8rem; }
    .conexao-content h3 { font-size: 2.5rem; }
    .conexao-content h4 { font-size: 1.1rem; }
    .conexao-slide { height: 550px; } 
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

<script>
    $(document).ready(function(){
        // Carrossel do Banner Principal
        $('#conexaoCarousel').slick({
            dots: true,
            infinite: true,
            speed: 900,
            fade: true,
            cssEase: 'linear',
            autoplay: true,
            autoplaySpeed: 5000,
            arrows: false,
            pauseOnHover: false
        });

        // Seu carrossel de depoimentos existente
        $('#carousel').slick({
            // ... suas configurações antigas do depoimento
        });
    });
</script>