<div class="profile-card">

    <div class="profile-avatar-wrapper">

        <img
            src="{{ !empty($usuario->foto_usuario)
                ? asset($usuario->foto_usuario)
                : asset('images/avatar-default.png') }}"
            alt="{{ $usuario->nome_usuario }}"
            class="profile-avatar"
        >

    </div>

    <h1 class="profile-name">

        {{ $usuario->nome_usuario }}

    </h1>

    <p class="profile-profession">

        {{ $usuario->area_atuacao_usuario }}

    </p>

    <p class="profile-location">

        {{ $usuario->estado_usuario }}

    </p>

    <div class="profile-divider"></div>

    <div class="profile-stats">

        <div>

            <strong>

                {{ $totalPosts }}

            </strong>

            <span>

                Publicações

            </span>

        </div>

        <div>

            <strong>

                {{ $totalCurtidas }}

            </strong>

            <span>

                Curtidas

            </span>

        </div>

    </div>

</div>