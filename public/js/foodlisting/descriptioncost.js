var DescriptionCost = (function() {

  var sideCostPlaceholder = $('#totalSideCost');
  var meatCostPlaceholder = $('#totalMeatCost');
  var totalPlaceholder = $('#grossTotal');
  var foodCost = $('#foodCost').text();

  var totalSideCost = 0.00;
  var totalMeatCost = 0.00;

  var total = {
    update : function() {

      foodCost = Number(foodCost);
      var newCost = foodCost + totalSideCost + totalMeatCost;
      totalPlaceholder.html(parseFloat(newCost).toFixed(2));
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
    }

  }


})();
