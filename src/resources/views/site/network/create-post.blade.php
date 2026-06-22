<div class="create-post-card">

    <h3 class="section-title">
        Criar Post
    </h3>

    @if($errors->any())

        <div class="error-message">

            <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form
        action="{{ route('network.feed.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        <textarea
            name="conteudo_feed"
            class="create-post-textarea"
            placeholder="O que você deseja compartilhar?"
        ></textarea>

        <div class="post-upload">

            <input
                type="file"
                name="foto_feed"
                accept="image/*"
            >

        </div>

        <div class="create-post-footer">

            <button
                type="submit"
                class="btn-publish"
            >
                Publicar
            </button>

        </div>

    </form>

</div>