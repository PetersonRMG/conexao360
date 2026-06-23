<style>

    /* --------------------------------------------------------------------------

       1. ESTILOS GERAIS DO HEADER (Para telas grandes / Desktop)

       -------------------------------------------------------------------------- */

    header {

        width: 100%;

        position: fixed;

        top: 0;

        left: 0;

        z-index: 99999;

        backdrop-filter: blur(12px) !important;

        -webkit-backdrop-filter: blur(12px);

       

        transition: all 0.3s ease;



    }



    header .topo {

        display: flex;

        justify-content: space-between;

        align-items: center;

        max-width: 1200px;

        margin: 0 auto;

        padding: 15px 20px;

        width: 100%;

        box-sizing: border-box;

    }



    header .topo div a {

        display: flex;

        align-items: center;

        text-decoration: none;

    }



    header .topo div a img {

        height: 45px;

        margin-right: 12px;

    }



    header .topo div a h5 {

        color: #ffffff;

        font-size: 14px;

        text-transform: uppercase;

        font-weight: 600;

        line-height: 1.2;

        margin: 0;

        letter-spacing: 0.5px;

    }



    header .topo div a h5 span {

        color: #d4af37;

    }



    /* Menu padrão Desktop */

    header .topo nav {

        display: block;

    }



    header .topo nav ul.fechar {

        display: flex;

        align-items: center;

        list-style: none;

        margin: 0;

        padding: 0;

        gap: 30px;

    }



    header .topo nav ul.fechar li a {

        color: #ffffff;

        text-decoration: none;

        font-size: 15px;

        font-weight: 500;

        transition: color 0.3s ease;

    }



    header .topo nav ul.fechar li a:hover {

        color: #d4af37;

    }



    /* Botão Customizado da Rede Exclusiva (Desktop) */

    header .topo nav ul.fechar li a.btn-rede-exclusiva {

        display: inline-block;

        border: 1.5px solid #d4af37;

        background: rgba(212, 175, 55, 0.03);

        padding: 8px 18px;

        border-radius: 6px;

        text-align: center;

        font-size: 13px;

        line-height: 1.3 !important;

        letter-spacing: 0.5px;

        transition: all 0.3s ease-in-out;

    }



    header .topo nav ul.fechar li a.btn-rede-exclusiva span {

        font-weight: 700;

        color: #e5c060;

        text-transform: uppercase;

        font-size: 11px;

        display: block;

        margin-top: 2px;

    }



    header .topo nav ul.fechar li a.btn-rede-exclusiva:hover {

        background-color: #d4af37;

        color: #121212 !important;

        box-shadow: 0 4px 20px rgba(212, 175, 55, 0.35);

        transform: translateY(-1px);

    }



    header .topo nav ul.fechar li a.btn-rede-exclusiva:hover span {

        color: #121212 !important;

    }



    /* Esconde os botões mobile por padrão no Desktop */

    .abrir-menu, .fechar-menu {

        display: none;

    }



    /* --------------------------------------------------------------------------

       2. REGRAS DO RESPONSIVO (Media Query para Celulares e Tablets)

       -------------------------------------------------------------------------- */

    @media (max-width: 991px) {

        header {

            height: 70px;

            display: flex;

            align-items: center;

        }



        header .topo {

            padding: 0 20px;

        }



        /* BOTÃO HAMBÚRGUER (Abrir Menu) - Feito em CSS Puro */

        .abrir-menu {

            display: block;

            border: 0;

            width: 32px;

            height: 24px;

            cursor: pointer;

            position: relative;

        }



     

       

        .abrir-menu::before,

        .abrir-menu::after {

            content: '';

            position: absolute;

            width: 100%;

            left: 0;

        }

       

        .abrir-menu::before { top: 6px; }

        .abrir-menu::after { bottom: 0; }



        /* BOTÃO FECHAR (X) - Feito em CSS Puro */

        .fechar-menu {

            display: block;

            background: transparent;

            border: 0;

            width: 32px;

            height: 32px;

            position: absolute;

            top: 20px;

            right: 20px;

            cursor: pointer;

        }



        /* Cria as duas linhas cruzadas formando o X em dourado */

        .fechar-menu::before,

        .fechar-menu::after {

            content: '';

            position: absolute;

            top: 14px;

            left: 0;

            width: 100%;

            height: 3px;

            background-color: #d4af37;

        }



        .fechar-menu::before { transform: rotate(45deg); }

        .fechar-menu::after { transform: rotate(-45deg); }



        /* Menu vira uma gaveta lateral fluida e profissional */

        header nav {

            background-color: rgba(10, 10, 10, 0.98);

            position: fixed;

            top: 0;

            right: -100%;

            width: 100%;

            max-width: 320px;

            height: 100vh;

            transition: right 0.4s cubic-bezier(0.25, 1, 0.5, 1);

            display: flex;

            flex-direction: column;

            align-items: center;

            padding: 80px 20px 40px 20px;

            box-shadow: -5px 0 25px rgba(0, 0, 0, 0.8);

            opacity: 0;

            visibility: hidden;

            box-sizing: border-box;

        }



        /* Classe que ativa o menu mobile */

        .menu-ativo nav {

            right: 0;

            opacity: 1;

            visibility: visible;

        }



        header nav ul.fechar {

            flex-direction: column;

            width: 100%;

            gap: 15px;

        }



        header nav ul.fechar li {

            width: 100%;

            text-align: center;

        }



        header nav ul.fechar li a {

            font-size: 18px;

            display: block;

            padding: 12px;

            width: 100%;

            box-sizing: border-box;

        }



        /* Ajuste do botão exclusivo para o comportamento mobile */

        header nav ul.fechar li a.btn-rede-exclusiva {

            margin-top: 15px;

            width: 100%;

            background: rgba(212, 175, 55, 0.08);

        }

    }

</style>



<header class="">

    <div class="topo">

        <div>

            <a href="{{route('admin.dash')}}">

                <img src="{{asset('conexao360/img/pint.svg')}}" alt="Logo">

                <h5> ADVOCACIA <br> E<span>X</span>PONENCIAL</h5>

            </a>

        </div>



        <button class="abrir-menu"></button>

       

        <nav>

            <button class="fechar-menu"></button>

            <ul class="fechar">

                <li><a href="#palestra">Palestra</a></li>

                <li><a href="#depoimento">Depoimentos</a></li>

                <li><a href="#ingressos">Ingressos</a></li>

                <li>

                    <a href="{{route('admin.dash')}}" target="_blank" class="btn-rede-exclusiva">

                        Conexão360 <span>Rede Exclusiva</span>

                    </a>

                </li>

            </ul>

        </nav>

    </div>

</header>