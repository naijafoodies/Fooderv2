/**
* Food Controls the logic behind sides and meat calculation
*
*/
var Description = (function(cost) {
  "use strict";

  var vendorId = parseInt($('#vendor_id').val());

  var sidePanel = $('#sidePanel');
  var freeSidePanel = $('#freeSidePanel');
  var meatPanel = $('#meatPanel');
  var selectedMeat = [];
  var selectedFreeSides = [];
  var selectedSides = [];


  var components = {

    /**
    * Function creates DOM elements for a piece of meat
    *
    * @param meat -object
    * @return string
    */
    getMeatComponents : function(meat) {

      var components = '<div class="description-item" id="meat_'+meat.id+'">';
      components += meat.name+' - $'+parseFloat(meat.cost).toFixed(2);
      components += '</div>';

      return components
    },

    /**
    * Function creates DOM elemtns for paidsides
    *
    * @param paidSides
    * @return string
    */
    getPaidSideComponents : function(side) {

      var components = '<div class="description-item" id="pSide_'+side.id+'">';
      components += side.name+' - $'+parseFloat(side.cost).toFixed(2);
      components += '</div>';

      return components
    },
    /**
    * Function creates DOM elemtns for paidsides
    *
    * @param paidSides
    * @return string
    */
    getFreeSideComponents : function(side) {

      var components = '<div class="description-item" id="fSide_'+side.id+'">';
      components += side.name+' - $'+parseFloat(side.cost).toFixed(2);
      components += '</div>';

      return components
    }


  };

  var arrayManip = {

    addMeat : function(meatId) {
      if(!selectedMeat.includes(meatId)) {
        selectedMeat.push(meatId);
        return true;
      }
      return false;
    },

    removeMeat : function(meatId) {
      if(selectedMeat.includes(meatId)) {
        var indexOfMeat = selectedMeat.indexOf(meatId);
        if(indexOfMeat != -1) {
          selectedMeat.splice(indexOfMeat,1);
        }
      }
    },

    addPaidSide : function(sideId) {
      if(!selectedSides.includes(sideId)) {
        selectedSides.push(sideId);
        return true;
      }
      return false;
    },

    removePaidSide : function(sideId) {
      if(selectedSides.includes(sideId)) {
        var indexOfSide = selectedSides.indexOf(sideId);
        if(indexOfSide != -1) {
          selectedSides.splice(indexOfSide,1);
        }
      }
    },

    addFreeSide : function(sideId) {

      if(selectedFreeSides.length < 2) {
        selectedFreeSides.push(sideId);
        return true;
      }
      return false;
    },

    removeFreeSide : function(sideId) {
      if(selectedFreeSides.includes(sideId)) {
        var indexOfSide = selectedFreeSides.indexOf(sideId);
        if(indexOfSide != -1) {
          selectedFreeSides.splice(indexOfSide,1);
        }
      }
    }

  }
  var util = {

    /**
    * Using several components, method shows all vendor meats and attaches event handlers to it
    *
    */
    showMeats : function(meats) {

      if(Object.keys(meats).length) {
        // I will be creating a title and instruct
        $.each(meats,function(key,value) {

          meatPanel.append(components.getMeatComponents(value));

          var meatEvent = $('#meat_'+value.id).click(function() {
            if(!util.isSelected($(this))) {
              $(this).addClass('selected');
              arrayManip.addMeat(value.id);
              cost.addToMeat(value);
            }
            else {
              $(this).removeClass('selected');
              arrayManip.removeMeat(value.id);
              cost.removeFromMeat(value);
            }
          });

        });
      }
      else {
        meatPanel.html('<span class="description-error text-center">There are no meats attached to this item</span>');
      }

    },

    isSelected : function(element) {
      if(element.hasClass('selected')) {
        return true;
      }
      return false;
    },

    /**
    * Function displays the processes the logic behind sides selection/. Sides falls into two categories,
    * FREE AND PAID. Fnction will process the logic for both
    *
    * @param sides
    */
    showSides : function(sides) {

      /**
      * I will start by checking if sides exist for both free and paid and display status accordingly
      */
      if(Object.keys(sides.freeSides).length) {
        // will displayt the free sides here and the process the selection logic

        $.each(sides.freeSides,function(key,value) {
          freeSidePanel.append(components.getFreeSideComponents(value));

          var freeSideEvent = $('#fSide_'+value.id).click(function() {
            if(!util.isSelected($(this))) {

              // Add free sides here and also check if the limit has been reached.
              if(!arrayManip.addFreeSide(value.id)) {

                // notify users that they can only select up to two sides
                $.alert({
                    title: 'Max reached',
                    content: 'You can only select up to two free sides.',
                    type: 'red',
                    typeAnimated: true,
                    theme: 'supervan'
                  });
              }
              else {
                $(this).addClass('selected');
              }


            }
            else {
              $(this).removeClass('selected');
              arrayManip.removeFreeSide(value.id);
            }
          });

        });

      }
      else {
        freeSidePanel.html('<span class="description-error text-center">There are no free sides attached to this meal</span>');
      }

      // Will be processing paid sides here
      if(Object.keys(sides.paidSides).length) {
        $.each(sides.paidSides,function(key,value) {
          sidePanel.append(components.getPaidSideComponents(value));

          var paidSideEvent = $('#pSide_'+value.id).click(function() {
            if(!util.isSelected($(this))) {
              $(this).addClass('selected');
              arrayManip.addPaidSide(value.id);
              cost.addToSide(value);
            }
            else {
              $(this).removeClass('selected');
              arrayManip.removePaidSide(value.id);
              cost.removeFromSide(value);
            }
          });

        });
      }
      else {
        sidePanel.html('<span class="description-error text-center">There are no paid sides attached to this meal</span>');
      }

    }

  }

  /**
  * Object controls all the server transactions to be made
  */
  var transactions = {

    getVendorSides : function() {

      $.ajax({
        url : '/api/vendor/'+vendorId+'/sides/get',
        type : 'get',
        dataType : 'json',
      }).done(function(response) {

        util.showSides(response);

      }).fail(function(status) {

        console.info("issues loading meat");

      });

    },

    getVendorMeats : function() {

      $.ajax({
        url : '/api/vendor/'+vendorId+'/meat/get',
        type : 'get',
        dataType : 'json',
      }).done(function(response) {
        util.showMeats(response);
      }).fail(function(status) {
        console.info("issues loading meat");
      });

    }


  }

  return {
    init : function() {
      transactions.getVendorSides();
      transactions.getVendorMeats();
    }
  }

})(DescriptionCost);

Description.init();
