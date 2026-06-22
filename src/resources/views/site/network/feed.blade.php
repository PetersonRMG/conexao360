@if(session('success'))

    <div class="success-message">

        {{ session('success') }}

    </div>

@endif

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