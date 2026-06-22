<div
    id="commentsModal{{ $feed->id_feeds }}"
    class="comments-modal"
>

    <div class="comments-modal-content">

        <div class="comments-modal-header">

            <div>

                <h3>

                    Todos os Comentários

                </h3>

                <span class="comments-total">

                    Total:
                    {{ $feed->comentarios->count() }}

                </span>

            </div>

            <button
                type="button"
                class="comments-close"
                data-close-modal="{{ $feed->id_feeds }}"
            >

                ✕

            </button>

        </div>

        <div class="comments-modal-body">

            @forelse(
                $feed->comentarios
                    ->sortByDesc('id_comentario')
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

                    Nenhum comentário encontrado.

                </div>

            @endforelse

        </div>

    </div>

</div>