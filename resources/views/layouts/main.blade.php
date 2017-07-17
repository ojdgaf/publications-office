<!DOCTYPE html>

<html lang="en">

    <head>
        @include('layouts/partials/_head')
    </head>

    <body>
        <!-- Fixed navbar -->
        @include('layouts/partials/_navigation')

        <!-- Page content -->
        <div class="container">
            @include('layouts/partials/_message')
            @yield('content')
        </div>

        <!-- Footer -->
        @include('layouts/partials/_footer')

        <!-- jQuery and Bootstrap -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>

        <!-- Additional JavaScript -->
        @yield('js')
    </body>

</html>
