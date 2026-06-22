<div class="post-card">

    <div class="post-header">

        <div class="post-user">

            <div class="post-avatar">

    <a
        href="{{ route('network.profile', $feed->usuario->id_usuario) }}"
    >

        <img
            src="{{ !empty($feed->usuario?->foto_usuario)
                ? asset($feed->usuario->foto_usuario)
                : asset('images/avatar-default.png') }}"
            alt="{{ $feed->usuario?->nome_usuario }}"
        >

    </a>

</div>

            <div>

                <h4>

    <a
        href="{{ route('network.profile', $feed->usuario->id_usuario) }}"
        class="post-user-link"
    >

        {{ $feed->usuario->nome_usuario }}

    </a>

</h4>

                <span>

    {{ \Carbon\Carbon::parse($feed->criado_em_feed)->diffForHumans() }}

</span>

            </div>

        </div>

    </div>

    <div class="post-body">

        {{ $feed->conteudo_feed }}

    </div>

    @if(!empty($feed->foto_feed))

    <div class="post-image-wrapper">

        <img
            src="{{ asset($feed->foto_feed) }}"
            alt="Imagem da publicação"
            class="post-image"
        >

    </div>

@endif

    <div class="post-actions">

    <form
        action="{{ route('network.feed.like', $feed->id_feeds) }}"
        method="POST"
        class="like-form"
    >

        @csrf

        <button
            type="submit"
            class="post-action-btn"
        >
            👍 {{ $feed->curtidas_feed ?? 0 }}
        </button>

    </form>

    <button class="post-action-btn">

        💬 {{ $feed->comentarios->count() }}

    </button>

    <button class="post-action-btn">

        ↗ {{ $feed->compartilhamentos_feed ?? 0 }}

    </button>

    @if($feed->id_usuario == 1)

        <a
            href="{{ route('network.feed.edit', $feed->id_feeds) }}"
            class="post-edit-btn"
        >

            ✏ Editar

        </a>

        <form
            action="{{ route('network.feed.destroy', $feed->id_feeds) }}"
            method="POST"
            onsubmit="return confirm('Deseja realmente excluir esta publicação?')"
        >

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="post-delete-btn"
            >

                🗑 Excluir

            </button>

        </form>

    @endif

</div>

@include(
    'site.network.comments',
    [
        'feed' => $feed
    ]
)

</div>