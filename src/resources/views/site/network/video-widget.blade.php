<div class="widget-card">

    <h3 class="widget-title">
        Vídeos
    </h3>

    @forelse($videos as $video)

        <div class="widget-video">

            <img
                src="{{ asset($video->capa_video) }}"
                alt="{{ $video->titulo_video }}"
                class="widget-video-cover"
            >

            <div class="widget-video-content">

                <h4>
                    {{ $video->titulo_video }}
                </h4>

                <p>
                    {{ $video->subtitulo_video }}
                </p>

            </div>

        </div>

    @empty

        <p>Nenhum vídeo disponível.</p>

    @endforelse

</div>