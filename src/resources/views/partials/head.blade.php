<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> Evento Conexão 360º 3º edição </title>


<meta name="description"
    content="Advocacia Exponencial,Conexão 360 a palestra da advocacia aonde ocorre a sua virada de chave ">
<meta name="keywords"
    content="Advocacia Exponencial,Conexão 360, palestra advocacia,virada de chave, Simone Baptista, evento advocacia , advogada Sp, palestra Sp">

<!-- Autor do site -->
<meta name="author" content="Equipe HardSettings">

<!-- Open Graph (Quando tiver um compartilhamento com Whats, face, LinkedIn) -->
<meta property="og:title" content="Conexão 360º 3º edição a palestra da advocacia da virada de chave ">
<meta property="og:description"
    content="No Advocacia Exponencial Conexão 360, eu vou te conduzir numa virada de chave completa. Mente, posicionamento, comunicação e decisão. Você não sai igual. Você sai com clareza, com plano e com uma nova postura.">
<meta property="og:image" content="http://">
<meta property="og:type" content="website">


<link rel="apple-touch-icon" sizes="57x57" href="{{asset('conexao360/icon/apple-icon-57x57.png')}}">
{{--
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> --}}
<link rel="apple-touch-icon" sizes="60x60" href="{{asset('conexao360/icon/apple-icon-60x60.png')}}">
<link rel="apple-touch-icon" sizes="72x72" href="{{asset('conexao360/icon/apple-icon-72x72.png')}}">
<link rel="apple-touch-icon" sizes="76x76" href="{{asset('conexao360/icon/apple-icon-76x76.png')}}">
<link rel="apple-touch-icon" sizes="114x114" href="{{asset('conexao360/icon/apple-icon-114x114.png')}}">
<link rel="apple-touch-icon" sizes="120x120" href="{{asset('conexao360/icon/apple-icon-120x120.png')}}">
<link rel="apple-touch-icon" sizes="144x144" href="{{asset('conexao360/icon/apple-icon-144x144.png')}}">
<link rel="apple-touch-icon" sizes="152x152" href="{{asset('conexao360/icon/apple-icon-152x152.png')}}">
<link rel="apple-touch-icon" sizes="180x180" href="{{asset('conexao360/icon/apple-icon-180x180.png')}}">
<link rel="icon" type="image/png" sizes="192x192" href="{{asset('conexao360/icon/android-icon-192x192.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('conexao360/icon/favicon-32x32.png')}}">
<link rel="icon" type="image/png" sizes="96x96" href="{{asset('conexao360/icon/favicon-96x96.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('conexao360/icon/favicon-16x16.png')}}">
{{--
<link rel="manifest" href="{{ ('conexao360/js/manifest.json') }}"> --}}
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{asset('conexao360/icon/ms-icon-144x144.png')}}">
<meta name="theme-color" content="#ffffff">

{{-- Performance: abre as conexões externas antes de elas serem necessárias --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://code.jquery.com" crossorigin>

{{-- Uma única requisição de fontes; evita o @import bloqueante do CSS --}}
<link
    href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Montserrat:wght@300;400;600&family=Playfair+Display:wght@600;700&display=swap"
    rel="stylesheet">

{{-- Preload da imagem principal da hero para melhorar o LCP --}}
@if (isset($hero))
    @php
        $heroPreload = collect($hero)->firstWhere('status_hero', 'ATIVO');
    @endphp

    @if ($heroPreload && !empty($heroPreload->foto_banner))
        <link rel="preload" as="image" href="{{ asset('conexao360/img/' . $heroPreload->foto_banner) }}" fetchpriority="high">
    @endif
@endif

<link rel="stylesheet" href="{{asset('conexao360/css/reset.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('conexao360/css/slick.css')}}" />
<link rel="stylesheet" href="{{asset('conexao360/css/lity.min.css')}}">
<link rel="stylesheet" href="{{asset('conexao360/css/estilo.css')}}">
{{--
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" /> --}}
<!-- <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script> -->