    <script>

function startCountdown()
{
    const daysElement =
        document.getElementById("days");

    const hoursElement =
        document.getElementById("hours");

    const minutesElement =
        document.getElementById("minutes");

    const secondsElement =
        document.getElementById("seconds");

    if(
        !daysElement ||
        !hoursElement ||
        !minutesElement ||
        !secondsElement
    ){
        return;
    }

    const eventDate =
        new Date(
            2026,
            10,
            14,
            0,
            0,
            0
        ).getTime();

    const timer =
        setInterval(() =>
    {

        const now =
            new Date().getTime();

        const distance =
            eventDate - now;

        const days =
            Math.floor(
                distance /
                (1000 * 60 * 60 * 24)
            );

        const hours =
            Math.floor(
                (
                    distance %
                    (1000 * 60 * 60 * 24)
                ) /
                (1000 * 60 * 60)
            );

        const minutes =
            Math.floor(
                (
                    distance %
                    (1000 * 60 * 60)
                ) /
                (1000 * 60)
            );

        const seconds =
            Math.floor(
                (
                    distance %
                    (1000 * 60)
                ) /
                1000
            );

        daysElement.textContent =
            String(days).padStart(2,'0');

        hoursElement.textContent =
            String(hours).padStart(2,'0');

        minutesElement.textContent =
            String(minutes).padStart(2,'0');

        secondsElement.textContent =
            String(seconds).padStart(2,'0');

        if(distance < 0)
        {
            clearInterval(timer);
        }

    },1000);
}

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
    <script src="app.js"></script>