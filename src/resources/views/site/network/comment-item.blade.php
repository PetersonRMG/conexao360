<div class="comment-item">

    <img
        src="{{ asset($comentario->usuario->foto_usuario) }}"
        alt=""
        class="comment-avatar"
    >

    <div class="comment-content">

        <strong>

            {{ $comentario->usuario->nome_usuario }}

        </strong>

        <p>

            {{ $comentario->comentario }}

        </p>

    </div>

</div>