<head>
  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">

  <meta name="color-scheme" content="light dark">

  <meta name="theme-color" content="#0b0b0b" media="(prefers-color-scheme: dark)">

  <meta name="theme-color" content="#f4f1eb" media="(prefers-color-scheme: light)">

  <title>
    @yield('title', 'Painel do Palestrante') | Conexão 360º
  </title>


  {{-- FONTES --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link
    href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Playfair+Display:wght@600;700&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
    crossorigin="anonymous">


  {{-- OVERLAY SCROLLBARS --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
    crossorigin="anonymous">


  {{-- BOOTSTRAP ICONS --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    crossorigin="anonymous">


  {{-- ADMINLTE --}}
  <link rel="stylesheet" href="{{ asset('dash/css/adminlte.css') }}">


  {{-- PADRÃO VISUAL COMPARTILHADO COM O ADMIN --}}
  <link rel="stylesheet" href="{{ asset('dash/css/dash.css') }}">


  {{-- AJUSTES EXCLUSIVOS DO PALESTRANTE --}}
  <link rel="stylesheet" href="{{ asset('dash/css/palestrante.css') }}">
</head>