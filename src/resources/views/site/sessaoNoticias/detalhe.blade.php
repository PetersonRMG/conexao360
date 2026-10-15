@extends('layout.site')

@section('content')
    @php
        $imagem = $noticia['imagem'] ?? 'conexao360/img/vista.png';
        $imagemUrl = \Illuminate\Support\Str::startsWith($imagem, ['http://', 'https://'])
            ? $imagem
            : asset($imagem);
    @endphp

    <main class="experience-main news-page news-detail-page">
        <section class="news-detail-hero" aria-labelledby="titulo-noticia">
            <div class="experience-shell">
                <nav class="news-detail-breadcrumb" aria-label="Navegação estrutural">
                    <a href="{{ route('home') }}">Início</a>
                    <span aria-hidden="true">/</span>
                    <a href="{{ route('page-noticias') }}">Conexão Jurídica</a>
                    <span aria-hidden="true">/</span>
                    <span>Notícia</span>
                </nav>

                <p class="experience-eyebrow">{{ $noticia['categoria'] ?? 'Conexão Jurídica' }}</p>
                <h1 id="titulo-noticia">{{ $noticia['titulo'] }}</h1>
                <p class="news-detail-meta">
                    {{ $noticia['data'] ?? 'Data não informada' }}
                    <span aria-hidden="true">•</span>
                    Fonte: Superior Tribunal de Justiça (STJ)
                </p>
            </div>
        </section>

        <section class="news-detail-body">
            <div class="experience-shell news-detail-shell">
                <article class="news-detail-article" aria-labelledby="titulo-noticia">
                    <figure class="news-detail-cover">
                        <img
                            src="{{ $imagemUrl }}"
                            alt="Imagem associada à notícia: {{ $noticia['titulo'] }}"
                            loading="eager"
                            decoding="async"
                            referrerpolicy="no-referrer"
                            onerror="this.onerror=null;this.src='{{ asset('conexao360/img/vista.png') }}';"
                        >
                        <figcaption>Imagem da publicação ou ilustração utilizada na seção Conexão Jurídica.</figcaption>
                    </figure>

                    <div class="news-detail-copy">
                        <p class="news-detail-kicker">Resumo da notícia</p>
                        <p class="news-detail-summary">{{ $noticia['resumo'] ?? 'Resumo indisponível.' }}</p>

                        <div class="news-detail-source">
                            <h2>Continue lendo na fonte oficial</h2>
                            <p>
                                Este é um resumo disponibilizado para consulta no Conexão 360°.
                                A matéria completa permanece no portal do Superior Tribunal de Justiça.
                            </p>
                            <a href="{{ $noticia['url'] }}" target="_blank" rel="noopener noreferrer"
                               class="news-detail-source-link">
                                Ler notícia completa no STJ <span aria-hidden="true">↗</span>
                            </a>
                        </div>

                        <a href="{{ route('page-noticias') }}" class="news-detail-back">
                            <span aria-hidden="true">←</span> Voltar para todas as notícias
                        </a>
                    </div>
                </article>

                @if ($outrasNoticias->isNotEmpty())
                    <aside class="news-detail-related" aria-labelledby="outras-noticias-title">
                        <p class="experience-eyebrow">Continue informado</p>
                        <h2 id="outras-noticias-title">Outras notícias</h2>
                        <div class="news-detail-related-grid">
                            @foreach ($outrasNoticias as $outra)
                                <article class="news-detail-related-card">
                                    <p>{{ $outra['categoria'] ?? 'Notícias STJ' }}</p>
                                    <h3>
                                        <a href="{{ route('page-noticias.show', ['id' => $outra['id']]) }}">
                                            {{ $outra['titulo'] }}
                                        </a>
                                    </h3>
                                    <span>{{ $outra['data'] ?? '' }}</span>
                                </article>
                            @endforeach
                        </div>
                    </aside>
                @endif
            </div>
        </section>
    </main>

    <style>
        .news-detail-page .news-detail-hero {
            padding: 155px 0 75px;
            background: radial-gradient(circle at 80% 20%, rgba(214,178,106,.13), transparent 35%),
                        linear-gradient(120deg,#080808,#15130f);
            border-bottom: 1px solid rgba(214,178,106,.25);
            color: #f7f4ed;
        }
        .news-detail-page .news-detail-breadcrumb {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
            margin-bottom: 38px;
            font: 500 .82rem/1.5 'Montserrat', sans-serif;
            color: #bcb7aa;
        }
        .news-detail-page .news-detail-breadcrumb a { color: #d6b26a; text-decoration: none; }
        .news-detail-page .news-detail-breadcrumb a:hover { text-decoration: underline; }
        .news-detail-page .news-detail-hero h1 {
            max-width: 1050px;
            margin: 14px 0 30px;
            font: 400 clamp(2.4rem,4.1vw,4.7rem)/1.18 'Cinzel', serif;
            letter-spacing: -.035em;
            color: #fff;
            overflow-wrap: anywhere;
        }
        .news-detail-page .news-detail-meta {
            display: flex; flex-wrap: wrap; gap: 11px;
            color: #c6c0b2; font: 500 .9rem/1.8 'Montserrat',sans-serif;
        }
        .news-detail-page .news-detail-body { padding: 66px 0 100px; background: #f2efe8; }
        .news-detail-page .news-detail-article {
            max-width: 1000px;
            margin: 0 auto;
            border: 1px solid rgba(30,24,15,.12);
            background: #faf8f3;
        }
        .news-detail-page .news-detail-cover { margin: 0; }
        .news-detail-page .news-detail-cover img {
            display: block; width: 100%; max-height: 560px;
            object-fit: cover; aspect-ratio: 16/9; background: #dfd9ce;
        }
        .news-detail-page .news-detail-cover figcaption {
            padding: 12px 28px; color: #777066;
            font: 400 .73rem/1.6 'Montserrat',sans-serif;
        }
        .news-detail-page .news-detail-copy { padding: 42px clamp(22px,5vw,76px) 55px; }
        .news-detail-page .news-detail-kicker {
            margin-bottom: 16px; font: 700 .79rem/1.5 'Montserrat',sans-serif;
            text-transform: uppercase; letter-spacing: .11em; color: #8f6a33;
        }
        .news-detail-page .news-detail-summary {
            color: #28241f; font: 400 clamp(1.08rem,1.35vw,1.27rem)/1.95 'Montserrat',sans-serif;
        }
        .news-detail-page .news-detail-source {
            margin: 38px 0 34px; padding: 30px;
            border-left: 3px solid #b58d47; background: #eee8dc;
        }
        .news-detail-page .news-detail-source h2 {
            margin: 0 0 12px; color: #201c16;
            font: 500 clamp(1.25rem,2vw,1.65rem)/1.35 'Cinzel',serif;
        }
        .news-detail-page .news-detail-source p {
            margin: 0 0 22px; color: #625b50;
            font: 400 .91rem/1.75 'Montserrat',sans-serif;
        }
        .news-detail-page .news-detail-source-link {
            display: inline-flex; align-items: center; gap: 15px;
            padding: 15px 22px; color: #0b0b0b; background: #d6b26a;
            text-decoration: none; font: 700 .88rem/1.4 'Montserrat',sans-serif;
            transition: background .2s;
        }
        .news-detail-page .news-detail-source-link:hover { background: #e5c27b; }
        .news-detail-page .news-detail-back {
            color: #72552e; font: 600 .89rem/1.5 'Montserrat',sans-serif;
            text-decoration: none;
        }
        .news-detail-page .news-detail-back:hover { text-decoration: underline; }
        .news-detail-page .news-detail-related { max-width: 1000px; margin: 80px auto 0; }
        .news-detail-page .news-detail-related > h2 {
            margin: 12px 0 25px; color: #201b14;
            font: 400 clamp(2rem,3vw,3rem)/1.2 'Cinzel',serif;
        }
        .news-detail-page .news-detail-related-grid {
            display: grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap: 16px;
        }
        .news-detail-page .news-detail-related-card {
            padding: 25px 22px; background: #faf8f3;
            border: 1px solid rgba(30,24,15,.12);
        }
        .news-detail-page .news-detail-related-card p {
            color: #97733b; margin: 0 0 14px;
            font: 700 .74rem/1.5 'Montserrat',sans-serif;
        }
        .news-detail-page .news-detail-related-card h3 {
            font: 500 1.02rem/1.55 'Montserrat',sans-serif;
            overflow-wrap: anywhere; margin: 0 0 18px;
        }
        .news-detail-page .news-detail-related-card h3 a { color: #242018; text-decoration: none; }
        .news-detail-page .news-detail-related-card h3 a:hover { color: #97733b; }
        .news-detail-page .news-detail-related-card span {
            color: #777066; font: 400 .75rem/1.5 'Montserrat',sans-serif;
        }
        @media(max-width:760px) {
            .news-detail-page .news-detail-hero { padding: 125px 0 52px; }
            .news-detail-page .news-detail-breadcrumb { margin-bottom: 25px; }
            .news-detail-page .news-detail-body { padding: 35px 0 65px; }
            .news-detail-page .news-detail-related-grid { grid-template-columns: 1fr; }
            .news-detail-page .news-detail-cover img { aspect-ratio: 5/4; }
            .news-detail-page .news-detail-source { padding: 22px 18px; }
            .news-detail-page .news-detail-related { margin-top: 55px; }
        }
    </style>
@endsection
