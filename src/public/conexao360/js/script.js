
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