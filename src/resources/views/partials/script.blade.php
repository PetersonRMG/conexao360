    <script>
        function startCountdown() {
            // 14 de março de 2026 às 00:00 (Brasil)
            const eventDate = new Date(2026, 2, 14, 0, 0, 0).getTime();

            const timer = setInterval(() => {
                const now = new Date().getTime();
                const distance = eventDate - now;

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("days").textContent = String(days).padStart(2, "0");
                document.getElementById("hours").textContent = String(hours).padStart(2, "0");
                document.getElementById("minutes").textContent = String(minutes).padStart(2, "0");
                document.getElementById("seconds").textContent = String(seconds).padStart(2, "0");

                if (distance < 0) {
                    clearInterval(timer);
                    document.querySelector(".countdown-container").innerHTML =
                        "<p style='color:white; font-size:1.5rem;'>O evento começou!</p>";
                }
            }, 1000);
        }



        // Inicia a função
        startCountdown();
    </script>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="{{asset('conexao360/js/lity.min.js')}}"></script>
    <script>
        window.addEventListener("scroll", function() {
            const header = document.querySelector("header");

            if (window.scrollY > 10) {
                header.classList.add("scrolled");
            } else {
                header.classList.remove("scrolled");
            }
        });
    </script>
    <script type="text/javascript" src="{{asset('conexao360/js/slick.js')}}"></script>
    <script type="text/javascript" src="{{asset('conexao360/js/depoimentos.js')}}"></script>
    <script type="text/javascript" src="{{asset('conexao360/js/script.js')}}"></script>