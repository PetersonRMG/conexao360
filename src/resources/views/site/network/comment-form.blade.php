<form
    action="{{ route('network.comment.store') }}"
    method="POST"
    class="comment-form"
>

    @csrf

    <input
        type="hidden"
        name="id_feeds"
        value="{{ $feed->id_feeds }}"
    >

    <textarea
        name="comentario"
        placeholder="Escreva um comentário..."
        class="comment-textarea"
    ></textarea>

    <button
        type="submit"
        class="btn-comment"
    >
        Comentar
    </button>

</form>