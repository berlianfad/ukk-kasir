<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>

    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/receipt.css') }}">
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full">
        @include('layouts.sidebar')
        @include('layouts.header')
        <div class="body-wrapper">
            @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>

    <script src="{{ asset('assets/js/app.min.js') }}"></script>
</body>

</html>
