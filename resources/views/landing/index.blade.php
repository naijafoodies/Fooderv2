<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="Naija Foodies" content="">


    <title>NaijaFoodies&trade;	- Welcome</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/landing/landing.css') }}" >

  </head>
  <body>
    <div id="preloader"></div>
   <main>
      <!-- Banner content -->
      <section id="Search_section">
        <div class="container">
          <div class="Serach_title">

            <div class="landing-intro">Find a NaijaFoodies vendor near you</div>
            <p>Search for your closest restaurant and order online.</p>

        </div>
        <div class="Search_form mt-md-5">

          <form class="form-inline" id="locationForm" method="get" action="#">
            <input class="form-control mr-sm-2 keypressenter" type="text" placeholder="Search For City, State, or zipcode" aria-label="Search" name="search" id="searchfield" autocomplete="off" autocorrect="off" autocapitalize="off">
            <input type="submit" name="Find Now" value="Find Now" id ="findnowvendor">
          </form>
          <div class="text-center" id="locationError"></div>

        </div>
      </div>
      </section>


      <!-- FOOTER -->
      <footer>
            <p class="text-center">&copy; 2018 Naija Foodies, Inc. ALL RIGHTS RESERVED &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
      </footer>
    </main>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('js/general/jquery-3.3.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="{{ asset('js/landing/landing.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHYH_rYFXt3r-NE-NU5MmIXEHgDRmUyQM" async defer></script>

  </body>
</html>
