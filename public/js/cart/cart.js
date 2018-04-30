
var Cart = (function() {

	var self = this;

	var totalMeatCost = 0;
	var totalSideCost = 0;

	var Controller = {

		viewCart : function() {
			$.each(self.cartItems.foodItems,function(key,value) {
				totalMeatCost += Controller.processMeatCost(value.attachedMeats);
				totalSideCost += Controller.processPaidSidesCost(value.attachedPaidSides);
			});
			
		},

        /**
		 *
         * @param paidSides
         * @returns {number}
         */
		processPaidSidesCost : function(paidSides) {
			var cost = 0;

			$.each(paidSides,function(key,value) {
				cost += value.cost;
				console.log(value.cost)
			});

			return cost
		},

        /**
		 *
         * @param meat
         * @returns {number}
         */
		processMeatCost : function(meat) {

			var cost = 0;
			$.each(meat,function(key,value) {
				cost += value.cost;
				console.log(value.cost);
			});

			return cost;
		}

	};


	var View = {

		/**
		*	Object displays the cart content
		*/
		cart : function(cartItems) {

		}	
	};

	var Components = {
		getCartComponent : function(foodItem) {

		},

		makeSummaryTemplates : function() {

		}
	};

	var Transactions = {

		/**
		*	Function fetches cart items.
		*/
		getCartItems : function(callBack) {
			$.ajax({
				url : '/api/cart/get',
				type : 'get',
				dataType : 'json',

				success : function(response) {
					self.cartItems = response;
					callBack();
				},

				error : function() {
					console.info("Error Fetching Cart");
				}
			});
		},

		/**
		*	Function fetches delivery cost for all transactions
		*/
		getDeliveryCost : function() {
			
			$.ajax({
				url : '/api/delivery/cost',
				type : 'get',
				dataType : 'json',

				success : function(response) {
					self.deliveryCost = Number(response);
				},

				error : function () {
					console.info("Error fetching delivery cost");
				}

			});
		}
	};


	return { 

		ignite : function() {

            $.when(Transactions.getDeliveryCost()).then(function() {
                Transactions.getCartItems(function() {
                    Controller.viewCart();
                });
			});
		}

	}
})();

Cart.ignite();