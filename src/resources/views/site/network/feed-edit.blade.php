@extends('layout.network')

@section('content')

@include('site.network.navbar')

<div class="network-page">

    <div class="network-feed">

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

        <div class="create-post-card">

            <h2 class="section-title">

                Editar Publicação

            </h2>

            <form
                action="{{ route('network.feed.update', $feed->id_feeds) }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf
                @method('PUT')

                <textarea
                    name="conteudo_feed"
                    class="create-post-textarea"
                    required
                >{{ old('conteudo_feed', $feed->conteudo_feed) }}</textarea>

                @if(!empty($feed->foto_feed))

                    <div class="edit-post-preview">

                        <h4>

                            Imagem Atual

                        </h4>

                        <img
                            src="{{ asset($feed->foto_feed) }}"
                            alt="Imagem da publicação"
                            class="post-image"
                        >

                    </div>

                @endif

                <div class="post-upload">

                    <label class="upload-label">

                        Trocar imagem

                    </label>

                    <input
                        type="file"
                        name="foto_feed"
                    >

                </div>

                <div class="edit-post-actions">

                    <a
                        href="{{ route('network') }}"
                        class="btn-cancel-post"
                    >

                        Cancelar

                    </a>

                    <button
                        type="submit"
                        class="btn-publish"
                    >

                        Salvar Alterações

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection