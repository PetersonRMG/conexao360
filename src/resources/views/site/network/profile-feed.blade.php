<div
    style="
        margin-top:30px;
    "
>

    <h2
        style="
            margin-bottom:20px;
        "
    >
        Publicações
    </h2>

    @forelse($feeds as $feed)

        @include(
            'site.network.post-card',
            [
                'feed' => $feed
            ]
        )

    @empty

        <div class="post-card">

            Nenhuma publicação encontrada.

        </div>

    @endforelse

</div>