var DescriptionCost = (function() {

  "use strict";

  var sideCostPlaceholder = $('#totalSideCost');
  var meatCostPlaceholder = $('#totalMeatCost');
  var totalPlaceholder = $('#grossTotal');
  var foodCost = $('#foodCost').text();

  var quantityPanel =  $('#quantity');

  var totalSideCost = 0.00;
  var totalMeatCost = 0.00;
  var quantity = 1;

  /**
  * I will be setting an event listener for the quantity input. Will update on change
  */
  quantityPanel.change(function() {
    if($(this).val()) {
      if(Number($(this).val()) < 0) {
        quantity = 1;
        $(this).val(1);
        total.update();
      }
      if(isNaN($(this).val())) {
        quantity = 1;
        $(this).val(1);
        total.update();
      }
    }
    quantity = Number($(this).val());
    total.update();
  });

  quantityPanel.blur(function() {
    if(!$(this).val()) {
      quantity = 1;
      $(this).val(1);

      total.update();
    }
  });

  // Function updates the total cost
  var total = {
    update : function() {
      foodCost = Number(foodCost);
      var newCost = foodCost + totalSideCost + totalMeatCost;
      totalPlaceholder.html(parseFloat(newCost * quantity).toFixed(2));
    }
  }

  return {

    addToSide : function(side) {
      totalSideCost += side.cost;
      sideCostPlaceholder.html(parseFloat(totalSideCost).toFixed(2));
      total.update();
    },

    removeFromSide : function(side) {
      if(totalSideCost >= 0) {
        totalSideCost -= side.cost;
        sideCostPlaceholder.html(parseFloat(Math.abs(totalSideCost)).toFixed(2));
        total.update();
      }
    },

    addToMeat : function(meat) {
      totalMeatCost += meat.cost;
      meatCostPlaceholder.html(parseFloat(totalMeatCost).toFixed(2));
      total.update();
    },

    removeFromMeat : function(meat) {
      if(totalMeatCost >= 0) {
        totalMeatCost -= meat.cost;
        meatCostPlaceholder.html(parseFloat(Math.abs(totalMeatCost)).toFixed(2));
        total.update();
      }
    },

    getQuantity : function() {

      return (quantity || 1);
    }

  }


})();
