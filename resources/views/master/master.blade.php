<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Green KPO Admin Panel ">
    <meta name="author" content="Green KPO">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Admin - Green KPO</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->

    @include('layouts.backend.style')
</head>

<body>
    <div class="main-wrapper">
        @include('sweetalert::alert')

        @include('layouts.backend.sidebar')

        <!-- partial -->

        <div class="page-wrapper">

            <!-- partial:partials/_navbar.html -->
            @include('layouts.backend.nav')

            <!-- partial -->

            @yield('content')

            <!-- partial:partials/_footer.html -->
            @include('layouts.backend.footer')
            <!-- partial -->

        </div>
    </div>

    @include('layouts.backend.js')
    <!-- End custom js for this page -->
    @yield('js')

</body>

</html>
