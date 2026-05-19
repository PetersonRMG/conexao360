





    <section class="header-advocacia">
        <div class="container">
            <div class="logo-container">
            </div>

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

    <section class="conexao">


        <img src="{{asset('conexao360/img/pint.svg')}}" alt="" width="200px">
        <h2> Conexão 360º </h2>


        <h3> ADVOCACIA <br> E<span>X</span>PONENCIAL</h3>
        <h4>3º EDIÇÃO </h4>


    </section>

    <section id="palestra" class="palestra">

        <div class="teste">
            @foreach ($video as $item)
                
            <div class="conteudo">
                <h2>{{$item->titulo_video}}</h2>

                <span class="tag">Palestra Exclusiva</span>

                <p>
                    {{$item->subtitulo_video}}
                </p>

                <ul>
                    <li>Com método, clareza e direção estratégica</li>
                    <li>Sem promessas vazias</li>
                    <li>Sem atalhos irreais</li>
                </ul>
            </div>

            <div class="imagem">
                <a class="data-lity" href="{{asset('conexao360/img/'.$item->url_video)}}" data-lity>
                    <img src="{{asset('conexao360/img/'.$item->capa_video)}}" alt="Palestra advocacia">
                    <span class="play-btn">
                        <span class="play-icon"></span>

                    </span>
                </a>
                <div>
                    <p class="tit-video"> — {{$item->legenda_video}} — </p>
                </div>

            </div>
            @endforeach
        </div>

    </section>

    <!-- telas grande -->
    <section class="abordagem">

        <div class="tds-abordagem">

            <div class="coluna-esquerda">
                
            <h2 class="title">O que você vai ativar<br> no conexão 360° </h2>
            <h3 class="sub-title">( Não é conteúdo. É virada de chave )</h3>
                @foreach ($temas as $item)
                
                <div class="card">
                    
                    <span class="card-text">{{$item->titulo_tema}}</span>
                    <h3>{{$item->subtitulo_tema}} <br> <br> - {{$item->breve_descricao_tema}}.</h3>
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

    <!-- mobile -->
    <section class="abordagem-mobile">

        <div class="tds-abordagem">

            <div class="coluna-esquerda">
                <h2 class="title">O que você vai ativar<br> no conexão 360° </h2>
                <h3 class="sub-title">( Não é conteúdo. É virada de chave )</h3>
                @foreach ($temas as $item)

                <div class="card" href="#{{$item->id_tema}}" data-lity>

                    <span class=" card-text">
                        {{$item->titulo_tema}}</span>
                    <h3 class=" card-text-lity" id="{{$item->id_tema}}"> <img src="{{asset('conexao360/img/'.$item->foto_tema)}}" alt="`{{$item->titulo_tema}}"> <br> <br>{{$item->titulo_tema}} <br> <br> - {{$item->breve_descricao_tema}}.</h3>

                </div>

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
                    <img src="{{asset('conexao360/img/'.$item->foto_dra)}}" alt="Dra. Simone Baptista">
                </div>

                <div class="sobre-info">
                        
                    <h3>{{$item->titulo_dra}}</h3>
                    <h4>{{$item->sub_titulo_dra}}</h4>                    
                    
                    <p>{{$item->descricao_dra}}</p>
                @endforeach

                </div>
            </div>
        </div>
    </section>

    <section id="depoimento" class="depoimentos ">
        <h2 class="titulo">
            A Voz de Quem Já Esteve Lá <span>O que profissionais da advocacia dizem sobre as palestras anteriores</span>
        </h2>

        <div class="caixa-car ">
            <div class="carrosel  " id="carousel">


            </div>
        </div>
    </section>

    <section class="local_sessao">
        <div class="container">
            <h2 class="tit_local">Sua transformação tem hora e lugar marcados</h2>


            <div class="local-cont">
                <div class="mapa">
                    <a href="" target="_blank" rel="">

                        <div class="mapa-botao">Ver no Google Maps</div>
                        <iframe src="https://www.google.com/maps/embed?pb=!4v1770671449477!6m8!1m7!1sfyHhGVpN2cpdkC8-XjOdgA!2m2!1d-23.50074578412579!2d-46.84116819281623!3f190.46136!4f0!5f0.7820865974627469" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </a>
                </div>



                <div class="event-info">
                    <div class="info-item">


                        <div class="info-icon">
                            <img src="{{asset('conexao360/img/icones_adv (8).svg')}}" alt="Calendário">
                        </div>
                        <div class="info-text">
                            <strong>Data e Horário:</strong>
                            <p> 14 e 15 de Março de 2026, às 19h.</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <img src="{{asset('conexao360/img/icones_adv (9).svg')}}" alt="Localização" height="400px">
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










