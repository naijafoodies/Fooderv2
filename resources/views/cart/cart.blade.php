
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cart</title>

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('js/general/semantic/dist/semantic.min.css') }}" >

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{ asset('css/general/pace/themes/red/pace-theme-loading-bar.css')}}">

    <link rel="stylesheet" href="{{ asset('css/general/common.css') }}" >

    <link rel="stylesheet" href="{{ asset('css/vendordisplay/vendordisplay.css') }}" >
    <link rel="stylesheet" href="{{ asset('css/general/nflister.css') }}" >
    <link rel="stylesheet" href="{{ asset('css/description/description.css') }}" >

  </head>
  <body>

    <!-- Start of top navigation bar -->
    @include('topnav')
    <!-- End of top navigation bar -->

    <!-- Start of content -->

    <div class="nf-page-content">
      <div class="container">
        <div class="row">


      </div>
      </div>
      <!-- End of Food display -->
    </div>

    <!-- End of content -->


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('js/general/jquery-3.3.1.min.js')}}"></script>
    <script src="{{ asset('js/general/pace/pace.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

    <!-- Swmactic ui -->
    <script src="{{ asset('js/general/semantic/dist/semantic.min.js') }}"></script>
    <script src="{{ asset('js/foodlisting/descriptioncost.js') }}"></script>
    <script src="{{ asset('js/foodlisting/description.js') }}"></script>

  </body>
</html>
