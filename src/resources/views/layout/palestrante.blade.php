<!DOCTYPE html>
<html lang="pt-br">

<head>
    @include('palestrante.partialPalestrantes.head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        @include('palestrante.partialPalestrantes.nav')
        @include('palestrante.partialPalestrantes.aside')

        <main>
            @include('palestrante.partialPalestrantes.content-header')
            @yield('content')
        </main>

        @include('palestrante.partialPalestrantes.footer')




    </div>

    @include('palestrante.partialPalestrantes.scripts')

</body>

</html>