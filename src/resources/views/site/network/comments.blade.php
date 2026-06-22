<div class="comments-section">

    @if($feed->comentarios->count() > 3)

        <div
            class="comments-counter"
            data-feed-id="{{ $feed->id_feeds }}"
        >

            Ver todos os comentários
            ({{ $feed->comentarios->count() }})

        </div>

    @endif

    @forelse(
        $feed->comentarios
            ->sortByDesc('id_comentario')
            ->take(3)
        as $comentario
    )

        <div class="comment-item">

            <div class="comment-header">

                <div class="comment-user">

                    <img
                        src="{{ !empty($comentario->usuario?->foto_usuario)
                            ? asset($comentario->usuario->foto_usuario)
                            : asset('images/avatar-default.png') }}"
                        alt="Avatar"
                        class="comment-avatar"
                    >

                    <div>

                        <strong>

                            {{ $comentario->usuario->nome_usuario ?? 'Usuário' }}

                        </strong>

                        <span class="comment-date">

                            {{ \Carbon\Carbon::parse($comentario->criado_em_comentario)->diffForHumans() }}

                        </span>

                    </div>

                </div>

                @if($comentario->id_usuario == 1)

                    <form
                        action="{{ route('network.comment.destroy', $comentario->id_comentario) }}"
                        method="POST"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="comment-delete-btn"
                        >

                            🗑

                        </button>

                    </form>

                @endif

            </div>

            <div class="comment-content">

                {{ $comentario->comentario }}

            </div>

        </div>

    @empty

        <div class="comment-empty">

            Nenhum comentário ainda.

        </div>

    @endforelse

    @include(
        'site.network.comment-form',
        [
            'feed' => $feed
        ]
    )

    @include(
        'site.network.comments-modal',
        [
            'feed' => $feed
        ]
    )

</div>