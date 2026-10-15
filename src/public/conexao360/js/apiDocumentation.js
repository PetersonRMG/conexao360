document.addEventListener("DOMContentLoaded", function () {
    var inputBusca = document.getElementById("api-doc-search");

    var botoesFiltro = Array.prototype.slice.call(
        document.querySelectorAll("[data-method-filter]")
    );

    var itensFiltraveis = Array.prototype.slice.call(
        document.querySelectorAll(".api-doc-filterable")
    );

    var linhasTabela = Array.prototype.slice.call(
        document.querySelectorAll(
            ".api-doc-table tbody tr.api-doc-filterable"
        )
    );

    var vazio = document.getElementById("api-doc-empty");

    var metodoAtivo = "TODOS";


    function normalizar(valor) {
        return String(valor || "")
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .toLowerCase();
    }


    function aplicarFiltros() {
        var termo = normalizar(
            inputBusca ? inputBusca.value : ""
        );

        itensFiltraveis.forEach(function (item) {
            var metodo =
                item.getAttribute("data-method") || "";

            var texto = normalizar(
                item.getAttribute("data-search") || ""
            );

            var metodoCombina =
                metodoAtivo === "TODOS"
                || metodo === metodoAtivo;

            var buscaCombina =
                termo === ""
                || texto.indexOf(termo) !== -1;

            if (metodoCombina && buscaCombina) {
                item.classList.remove(
                    "api-doc-filter-hidden"
                );
            } else {
                item.classList.add(
                    "api-doc-filter-hidden"
                );
            }
        });


        if (vazio) {
            var quantidadeVisivel =
                linhasTabela.filter(function (linha) {
                    return !linha.classList.contains(
                        "api-doc-filter-hidden"
                    );
                }).length;

            vazio.hidden =
                quantidadeVisivel > 0;
        }
    }


    if (inputBusca) {
        inputBusca.addEventListener(
            "input",
            aplicarFiltros
        );
    }


    botoesFiltro.forEach(function (botao) {
        botao.addEventListener(
            "click",
            function () {
                metodoAtivo =
                    botao.getAttribute(
                        "data-method-filter"
                    ) || "TODOS";

                botoesFiltro.forEach(
                    function (item) {
                        item.classList.remove(
                            "active"
                        );
                    }
                );

                botao.classList.add(
                    "active"
                );

                aplicarFiltros();
            }
        );
    });


    var botoesCopiar =
        document.querySelectorAll(
            "[data-copy-target]"
        );


    Array.prototype.forEach.call(
        botoesCopiar,
        function (botao) {
            botao.addEventListener(
                "click",
                function () {
                    var alvoId =
                        botao.getAttribute(
                            "data-copy-target"
                        );

                    var alvo =
                        document.getElementById(
                            alvoId
                        );

                    if (!alvo) {
                        return;
                    }

                    var texto =
                        (alvo.innerText || "")
                            .trim();

                    if (
                        navigator.clipboard
                        && navigator.clipboard.writeText
                    ) {
                        navigator.clipboard
                            .writeText(texto)
                            .then(function () {
                                mostrarCopiado(
                                    botao
                                );
                            })
                            .catch(function () {
                                copiarFallback(
                                    texto,
                                    botao
                                );
                            });
                    } else {
                        copiarFallback(
                            texto,
                            botao
                        );
                    }
                }
            );
        }
    );


    function copiarFallback(texto, botao) {
        var textarea =
            document.createElement("textarea");

        textarea.value = texto;

        textarea.setAttribute(
            "readonly",
            ""
        );

        textarea.style.position = "fixed";
        textarea.style.opacity = "0";

        document.body.appendChild(
            textarea
        );

        textarea.select();

        try {
            document.execCommand("copy");

            mostrarCopiado(
                botao
            );
        } catch (error) {
            console.error(
                "Não foi possível copiar:",
                error
            );
        }

        document.body.removeChild(
            textarea
        );
    }


    function mostrarCopiado(botao) {
        var htmlOriginal =
            botao.innerHTML;

        botao.innerHTML =
            '<i class="bi bi-check2"></i> Copiado';

        setTimeout(
            function () {
                botao.innerHTML =
                    htmlOriginal;
            },
            1400
        );
    }


    var linksInternos =
        document.querySelectorAll(
            '.api-doc-nav a[href^="#"]'
        );


    Array.prototype.forEach.call(
        linksInternos,
        function (link) {
            link.addEventListener(
                "click",
                function (event) {
                    var href =
                        link.getAttribute(
                            "href"
                        );

                    if (!href) {
                        return;
                    }

                    var destino =
                        document.querySelector(
                            href
                        );

                    if (!destino) {
                        return;
                    }

                    event.preventDefault();

                    destino.scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });
                }
            );
        }
    );


    aplicarFiltros();
});