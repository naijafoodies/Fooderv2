
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$food->food_name}} @ Naija Foodies</title>

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

          <!-- Start of restaurants display -->
            <div class="col-sm-8">

              <div class="description-panel">

                <div class="row">

                  <div class="col-sm-12 col-md-12 col-lg-5">
                    <div class="description-image">

                      <img class="rounded" src="{{asset('/storage/'.$foodPicture)}}">

                    </div>
                  </div>

                  <div class="col-sm-12 col-md-12 col-lg-7">

                    <div class="description-item">Name :
                      <span class="item-value">{{$food->food_name}}</span>
                    </div>

                    <div class="description-item">Cost :
                      <span class="item-value">${{number_format($food->food_cost,2)}}</span>
                    </div>

                    <div class="description-item">Vendor :
                      <span class="item-value">{{$vendor->name}}</span>
                    </div>

                    <div class="description-item">Description :
                      <span class="item-value">{{$description}}</span>
                    </div>

                    <div class="description-item">Distance to You :
                      <span class="item-value">{{ceil($distance)}} mile(s)</span>
                    </div>

                    <form>
                      <input type="hidden" value="{{$vendor->id}}" id="vendor_id" />
                      <input type="hidden" value="{{$food->id}}" id="food_id" />
                    </form>

                  </div>

                </div>
              </div>

              <div class="description-panel">
                <div class="description-header"><i class="angle down icon"></i>Please click the items below to add meat to this order</div>

                <div class="description-content-inline" id="meatPanel">
                </div>

              </div>

              <div class="description-panel">
                <div class="description-header"><i class="angle down icon"></i>Please click to select two of the free sides</div>

                <div class="description-content-inline" id="freeSidePanel"></div>

              </div>

              <div class="description-panel">
                <div class="description-header"><i class="angle down icon"></i>Please click to add more sides to this order</div>
                <div class="description-content-inline" id="sidePanel"></div>
              </div>



            </div>

            <div class="col-sm-4">

              <div class="description-panel">
                <div class="description-header">Order Summary</div>

                <div class="description-item">Food Cost : $<span class="item-value" id="foodCost">{{number_format($food->food_cost,2)}}</span></div>
                <div class="description-item">Side Cost : $<span class="item-value" id="totalSideCost">0.00</span></div>
                <div class="description-item">Meat Cost : $<span class="item-value" id="totalMeatCost">0.00</span></div>

                <div class="description-footer">
                  <div class="description-item">Total: $<span class="item-value" id="grossTotal">{{number_format($food->food_cost,2)}}</span></div>
                </div>

                <div class="description-footer">

                  <div class="description-item">
                    <span class="">
                      <label>Quantity : </label>
                      <input class="input-counter" type="number" id="quantity" value="1" />
                    </span>

                    <span class="pull-right">
                      <button type="button" class="btn btn-danger" id="addToCart">Add to cart</button>
                    </span>
                  </div>
                </div>


              </div>

            </div>

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
