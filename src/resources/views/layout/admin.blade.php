<!DOCTYPE html>
<html lang="pt-br">

<head>
    @include('admin.partialsAdmin.head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

  <body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        @include('admin.partialsAdmin.nav')
        @include('admin.partialsAdmin.aside')
      
        <main >
            @include('admin.partialsAdmin.content-header')
            @yield('content')
        </main>

        @include('admin.partialsAdmin.footer')

      


    </div>

    @include('admin.partialsAdmin.scripts')

 

</body>

</html>