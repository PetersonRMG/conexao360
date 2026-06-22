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

<div class="network-page">

    <div class="network-feed">

        <div class="post-card">

            <h2 class="section-title">

                Editar Perfil

            </h2>

            <form
                action="{{ route('network.profile.update') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf

                <div class="form-group">

                    <label>

                        Nome

                    </label>

                    <input
                        type="text"
                        name="nome_usuario"
                        class="form-input"
                        value="{{ old('nome_usuario', $usuario->nome_usuario) }}"
                    >

                </div>

                <div class="form-group">

                    <label>

                        Área de Atuação

                    </label>

                    <input
                        type="text"
                        name="area_atuacao_usuario"
                        class="form-input"
                        value="{{ old('area_atuacao_usuario', $usuario->area_atuacao_usuario) }}"
                    >

                </div>

                <div class="form-group">

                    <label>

                        Estado

                    </label>

                    <input
                        type="text"
                        name="estado_usuario"
                        class="form-input"
                        value="{{ old('estado_usuario', $usuario->estado_usuario) }}"
                    >

                </div>

                <div class="form-group">

                    <label>

                        Sobre

                    </label>

                    <textarea
                        name="sobre_usuario"
                        class="form-textarea"
                    >{{ old('sobre_usuario', $usuario->sobre_usuario) }}</textarea>

                </div>

                <div class="form-group">

                    <label>

                        Foto de Perfil

                    </label>

                    <input
                        type="file"
                        name="foto_usuario"
                        class="form-input"
                    >

                </div>

                <button
                    type="submit"
                    class="btn-publish"
                >

                    Salvar Alterações

                </button>

            </form>

        </div>

    </div>

</div>

@endsection