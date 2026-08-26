(() => {
    "use strict";

    if (window.__conexao360SiteInicializado) {
        return;
    }

    window.__conexao360SiteInicializado = true;

    document.addEventListener("DOMContentLoaded", () => {
        const html = document.documentElement;

        /* ==========================================================
           MENU MOBILE
        ========================================================== */

        const abrirMenu = document.querySelector(".abrir-menu");
        const fecharMenu = document.querySelector(".fechar-menu");
        const menuLista = document.querySelector(".menu-lista");

        const fecharMenuMobile = () => {
            html.classList.remove("menu-ativo");

            if (abrirMenu) {
                abrirMenu.setAttribute("aria-expanded", "false");
            }
        };

        if (abrirMenu) {
            abrirMenu.addEventListener("click", () => {
                html.classList.add("menu-ativo");
                abrirMenu.setAttribute("aria-expanded", "true");
            });
        }

        if (fecharMenu) {
            fecharMenu.addEventListener("click", fecharMenuMobile);
        }

        if (menuLista) {
            menuLista.addEventListener("click", (event) => {
                if (event.target.closest("a")) {
                    fecharMenuMobile();
                }
            });
        }

        /* ==========================================================
           HEADER
        ========================================================== */

        const header = document.querySelector(".site-header");

        if (header) {
            let estadoAnterior = null;

            const atualizarHeader = () => {
                const rolouPagina = window.scrollY > 35;

                if (rolouPagina === estadoAnterior) {
                    return;
                }

                estadoAnterior = rolouPagina;

                header.classList.toggle("site-header--scrolled", rolouPagina);
            };

            atualizarHeader();

            window.addEventListener("scroll", atualizarHeader, {
                passive: true,
            });
        }

        /* ==========================================================
           GOOGLE MAPS — CARREGAMENTO SOB DEMANDA
        ========================================================== */

        const mapaIframe = document.getElementById("mapaEventoIframe");

        if (mapaIframe) {
            const carregarMapa = () => {
                if (!mapaIframe.getAttribute("src")) {
                    mapaIframe.setAttribute("src", mapaIframe.dataset.src);
                }
            };

            if ("IntersectionObserver" in window) {
                const mapaObserver = new IntersectionObserver(
                    (entries, observer) => {
                        entries.forEach((entry) => {
                            if (entry.isIntersecting) {
                                carregarMapa();

                                observer.unobserve(entry.target);
                            }
                        });
                    },
                    {
                        rootMargin: "500px 0px",
                    },
                );

                mapaObserver.observe(mapaIframe);
            } else {
                carregarMapa();
            }
        }

        /* ==========================================================
           CARROSSÉIS
        ========================================================== */

        const $ = window.jQuery;

        if (!$ || !$.fn || typeof $.fn.slick !== "function") {
            return;
        }

        /* HERO */

        const $heroCarousel = $("#conexaoCarousel");

        if (
            $heroCarousel.length &&
            !$heroCarousel.hasClass("slick-initialized")
        ) {
            $heroCarousel.slick({
                dots: true,
                infinite: true,
                speed: 700,
                fade: true,
                cssEase: "linear",
                autoplay: true,
                autoplaySpeed: 5000,
                arrows: false,
                pauseOnHover: false,
                pauseOnFocus: false,
            });
        }

        /* DEPOIMENTOS */

        const $depoimentosCarousel = $("#carousel");

        if (
            $depoimentosCarousel.length &&
            !$depoimentosCarousel.hasClass("slick-initialized")
        ) {
            $depoimentosCarousel.slick({
                dots: true,
                infinite: true,
                speed: 500,
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 5000,
                arrows: false,
                pauseOnHover: true,

                responsive: [
                    {
                        breakpoint: 1100,

                        settings: {
                            slidesToShow: 2,
                        },
                    },

                    {
                        breakpoint: 820,

                        settings: {
                            slidesToShow: 1,
                        },
                    },
                ],
            });
        }
    });
})();
