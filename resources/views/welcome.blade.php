<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jqc-1.12.3/dt-1.10.16/b-1.4.2/b-html5-1.4.2/datatables.min.js"></script>
        <title>EPCST Data Sharing</title>
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        {{-- Fonts awesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        {{-- Scripts --}}
        <!-- jQuery library -->
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

        <!-- Popper.js library -->
        {{-- <script src="https://unpkg.com/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script> --}}
        @vite(['resources/sass/app.scss','resources/js/app.js'])

    </head>
    <body class="antialiased">
        <div id="app">
              {{-- <login-component></login-component> --}}
            <header-component></header-component>
            <navigation-component></navigation-component>
        </div>
    </body>
</html>
