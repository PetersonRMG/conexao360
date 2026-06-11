
document.querySelector('.abrir-menu').onclick = function () {
    document.documentElement.classList.add('menu-ativo');
    console.log('deu certo')
}

document.querySelector('.fechar-menu').onclick = function () {
    document.documentElement.classList.remove('menu-ativo');
}
document.querySelector('.fechar').onclick = function () {
    document.documentElement.classList.remove('menu-ativo');
}

/*map dos depoimentos*/
const container = document.getElementById("carousel");

let html = "";

depoimentos.forEach((item) => {


    html += `

        <div class="cards  " >
        <div class="texto-depoimentos ">
            <img class="img-advo" src=${item.imagem || "img/draGabriela.png"} alt=${item.nome} width="120px">
                <div class="divisao"></div>
                <h3> ${item.nome} <br> </h3>
                <h4> <br> ${item.cargo}</h4>
                <div class="divisao"></div>
                <p class="textetexto">
                    <img src="img/aspas (1).svg" alt="" width="30   ">
                        ${item.texto}
                
                    <img class="ajst" src="img/aspas (3).svg" alt="" width="30px">
                </p>

        </div>
        </div>
`

});

container.innerHTML = html;


$("#carousel").slick({
    slidesToShow: 5,
    autoplay: true,
    infinity: true,
    responsive: [
        {
            breakpoint: 1500,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 2,
                infinite: true,
                dots: true
            }
        },
        {
            breakpoint: 1090,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                infinite: true,
                dots: true
            }
        },
        ,
        {
            breakpoint: 740,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]

});
z