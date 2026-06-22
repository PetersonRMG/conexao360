<div class="profile-card">

    <img
        src="{{ asset($usuario->foto_usuario) }}"
        alt="{{ $usuario->nome_usuario }}"
        class="profile-avatar"
    >

    <h3>

        {{ $usuario->nome_usuario }}

    </h3>

    <p>

        {{ $usuario->area_atuacao_usuario }}

    </p>

    <span>

        {{ $usuario->estado_usuario }}

    </span>

</div>