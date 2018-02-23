
var Lander = (function() {

    "use strict"
     // private variables

	 var stoploader;
	 var searchbuttonele = $("#findnowvendor");
	 var searchField = $("#searchfield");
	 var nloader = 'stop';
   var naijaloaderid = 'preloader';
   var locationForm = $('#locationForm');
   var errorField = $("#locationError");

	 //Private Method
	 var defaultnaijaloader = function() {
		if(nloader=='stop') {
			document.getElementById(naijaloaderid).style.display = 'none';
		}
  };

  var util = {

    showError : function(text) {
      errorField.html(text);
    },

    clearError : function() {
      errorField.html('');
    }
  }

	// Private AJAX calls
    var getVendors = function(latitude,longitude) {
      util.clearError();
  		document.getElementById(naijaloaderid).style.display = 'none'; //Stop Naija Loader
      var userAddress = searchField.val();

      /**
      * I will be checking the vendor location API to get feed back of the API submitted
      */

      $.ajax({
        url : '/api/create/location',
        method : "GET",
        contentType: "application/json; charset=utf-8",

        beforeSend: function(xhr) {
          xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'))
        },

        data : {
          latitude : latitude,
          longitude : longitude,
          address : userAddress
        }

      }).done(function(response) {

        if(response.successful) {
          window.location.assign('/mylocalrestaurants');
        }
      }).fail(function(){

      });

  		return false;

    };

	// Private Method
    var inputClick = function(event) {
      event.preventDefault();
		var searchk = searchField.val();

		if(searchk ==''){
			util.showError("!Error. Please enter your address");
			return false;
		} else {

			      //Start Naija Loader
				  document.getElementById(naijaloaderid).style.display = 'block';
				  var geocoder = new google.maps.Geocoder();
				  geocoder.geocode( { 'address': searchk}, function(results, status) {
                  //alert(status);
				  if (status == google.maps.GeocoderStatus.OK) {
					  var latitude = results[0].geometry.location.lat();
					  var longitude = results[0].geometry.location.lng();
					  getVendors(latitude,longitude);
					  }

				  if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
					  util.showError("Server Error. Please try again");
					  document.getElementById(naijaloaderid).style.display = 'none'; //Stop Naija Loader
					  return false;
					  }
				});

		}

		event.preventDefault();
    };

	// Private Method
	var bindFunctions = function() {
      locationForm.on('submit',inputClick);
    };

	// Public Method
	var init = function () {
		stoploader = defaultnaijaloader();
		bindFunctions();

    };
	return {
        init: init,
     };
})();


$("document").ready(function () {
 Lander.init();
});
