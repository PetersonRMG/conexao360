@extends('layout.network')

@section('content')

@include('site.network.navbar')

@if(session('success'))

    <div class="success-message">

        {{ session('success') }}

    </div>

@endif

@if($errors->any())

    <div class="error-message">

        <ul>

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<div class="profile-page">

    <div class="profile-cover"></div>

    <div class="profile-card-large">

        <div class="profile-card-top">

            <img
                src="{{ !empty($usuario->foto_usuario)
                    ? asset($usuario->foto_usuario)
                    : asset('images/avatar-default.png') }}"
                alt="{{ $usuario->nome_usuario }}"
                class="profile-page-avatar"
            >

            <div class="profile-info">

                <h1>

                    {{ $usuario->nome_usuario }}

                </h1>

                <p>

                    {{ $usuario->area_atuacao_usuario }}

                </p>

                <span>

                    📍 {{ $usuario->estado_usuario }}

                </span>

                @if($usuario->id_usuario == 1)

                    <a
                        href="{{ route('network.profile.edit') }}"
                        class="btn-edit-profile"
                    >
                        Editar Perfil
                    </a>

                @endif

            </div>

        </div>

        @if(!empty($usuario->sobre_usuario))

            <div class="profile-about">

                <h3 class="profile-about-title">

                    Sobre Mim

                </h3>

                <p>

                    {{ $usuario->sobre_usuario }}

                </p>

            </div>

        @endif

        <div class="profile-stats-row">

            <div class="profile-stat">

                <strong>

                    {{ $feeds->count() }}

                </strong>

                <span>

                    Publicações

                </span>

            </div>

            <div class="profile-stat">

                <strong>

                    {{ $usuario->conexoes_usuario ?? 0 }}

                </strong>

                <span>

                    Conexões

                </span>

            </div>

            <div class="profile-stat">

                <strong>

                    {{ $feeds->sum('total_comentarios_feed') }}

                </strong>

                <span>

                    Comentários

                </span>

            </div>

            <div class="profile-stat">

                <strong>

                    {{ $usuario->curtidas()->count() }}

                </strong>

                <span>

                    Curtidas

                </span>

            </div>

        </div>

    </div>

    <div class="profile-posts">

        <h2 class="profile-section-title">

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

</div>

@endsection