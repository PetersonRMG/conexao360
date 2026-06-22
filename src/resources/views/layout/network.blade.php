<!DOCTYPE html>
<html lang="pt-br">

<head>

    @include('partials.head')

    <link
        rel="stylesheet"
        href="{{ asset('conexao360/css/network.css') }}"
    >

    @yield('styles')

</head>

<body class="network-body">

    @yield('content')

    @include('partials.script')

    <script
        src="{{ asset('js/network-comments.js') }}"
    ></script>

    @yield('scripts')

</body>

</html>