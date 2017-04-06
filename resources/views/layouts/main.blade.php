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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <!-- Additional JavaScript -->
        @yield('js')
    </body>

</html>