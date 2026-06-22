<!-- <!DOCTYPE html>
<html lang="pt-br">

<head>
    @include('partials.head')

    <link rel="stylesheet" href="{{ asset('hardsettings/estilo.css') }}">
</head>

<body>


@if(!isset($semHeader))
    @include('partials.header')

    @endif

    <main>
        @yield('content')
    </main>

    @include('partials.footer')




    @include('partials.script')



</body>

</html> -->


<!DOCTYPE html>
<html lang="pt-br">
<head>
    @include('partials.head')
    <link rel="stylesheet" href="{{ asset('hardsettings/estilo.css') }}">
    
    {{-- Adicionamos este yield para estilos específicos de componentes --}}
    @yield('styles') 
</head>

<body>

@if(!isset($semHeader))
    @include('partials.header')
@endif

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.script')
    
    {{-- Adicionamos este yield para scripts específicos de componentes --}}
    @yield('scripts')
</body>
</html>