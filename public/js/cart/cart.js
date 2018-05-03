
var Cart = (function() {

	var self = this;

    /**
     * @type {number}
     */
	var totalMeatCost = 0;

    /**
     * @type {number}
     */
	var totalSideCost = 0;

    /**
     * @type {number}
     */
	var totalFoodCost = 0;

    /**
     * @type {HTMLElement | null}
     */
	var cartPanel = document.getElementById("cartList");

    /**
     * @type {HTMLElement | null}
     */
	var checkoutButton = document.getElementById("checkoutButton");
    /**
	 *
     * @type {number}
     */
	var deliveryCost = 0;

    /**
	 *
     * @type {{viewCart: viewCart, processPaidSidesCost: (function(*=): number), processMeatCost: (function(*=): number)}}
     */
	var Controller = {

		viewCart : function() {
			$.each(self.cartItems.foodItems,function(key,value) {
				totalMeatCost += Controller.processMeatCost(value.attachedMeats) * value.quantity;
				totalSideCost += Controller.processPaidSidesCost(value.attachedPaidSides) * value.quantity;
				totalFoodCost += value.food_cost * value.quantity;
			});
			View.foodSummary({
				foodCost : totalFoodCost,
				meatCost : totalMeatCost,
				sideCost : totalSideCost,
				parentNode : 'cartPanel'
			});

			View.cart();

			if(checkoutButton) {
				checkoutButton.addEventListener("click",function() {
					window.location.assign("/checkout");
				},false);
			}
		},

        /**
         * @param paidSides
         * @returns {number}
         */
		processPaidSidesCost : function(paidSides) {
			var cost = 0;

			$.each(paidSides,function(key,value) {
				cost += value.cost;
			});

			return cost
		},

        /**
         * @param meat
         * @returns {number}
         */
		processMeatCost : function(meat) {

			var cost = 0;
			$.each(meat,function(key,value) {
				cost += value.cost;
			});

			return cost;
		}

	};

    /**
     * @type {{cart: cart, foodSummary: foodSummary}}
     */
	var View = {

		/**
		*	Object displays the cart content
		*/
		cart : function() {
			$.each(self.cartItems.foodItems,function(key,value) {
				Components.makeCartListingTemplate(value);
			});
		},

        /**
		 *
         * @param summaryOptions
         */
		foodSummary : function(summaryOptions) {
			Components.makeCartSectionTemplates(summaryOptions);
			Components.makeSummaryTemplate(summaryOptions);
		}
	};

    /**
     * @type {{makeSummaryTemplate: makeSummaryTemplate, makeCartSectionTemplates: makeCartSectionTemplates, makeCartListingTemplate: makeCartListingTemplate,
     * makeSelectionTemplate: (function(*): HTMLSelectElement), generateSideStrings: (function(*=): string)}}
     */
	var Components = {
        makeSummaryTemplate: function (summaryOptions) {

        	var total = summaryOptions.foodCost + summaryOptions.meatCost + self.deliveryCost + summaryOptions.sideCost;
            var parentNode = document.getElementById(summaryOptions.parentNode);

        	var row = document.createElement("div");
        	row.setAttribute("class","description-footer");
        	var columnDiv = document.createElement("div");
        	columnDiv.setAttribute("class","col-12");
        	columnDiv.style.display = "inline";
        	var title = document.createElement("div");
        	title.setAttribute("class","description-item pull-left");
        	var titleContent = document.createTextNode("Gross Total");
        	title.appendChild(titleContent);
        	var content = document.createElement("div");
        	content.setAttribute("class","description-item pull-right");
        	var contentText = document.createTextNode("$"+total.toFixed(2));
        	content.appendChild(contentText);

        	columnDiv.appendChild(title);
        	columnDiv.appendChild(content);
        	row.appendChild(columnDiv);
        	parentNode.appendChild(row);
        },

        /**
         * @param summaryOptions
         */
        makeCartSectionTemplates: function (summaryOptions) {
            var i;
            var summaryTitles = ["Food Cost", "Side Cost", "Meat Cost", "Delivery"]; // Arrangement of this is important
            var parentNode = document.getElementById(summaryOptions.parentNode);

            for (i = 0; i < summaryTitles.length; i++) {
                var row = document.createElement("div");
                row.setAttribute("class", "row");
                var contentDiv = document.createElement("div");
                contentDiv.setAttribute("class", "col-12");
                contentDiv.style.display = "inline";
                var title = document.createElement("div");
                title.setAttribute("class", "pull-left description-item");
                var titleKey = document.createTextNode(summaryTitles[i]);
                title.appendChild(titleKey);
                var value = document.createElement("div");
                value.setAttribute("class", "pull-right description-item");

                var cost;

                switch (i) {
                    case 0:
                        cost = "$" + summaryOptions.foodCost.toFixed(2);
                        break;
                    case 1:
                        cost = "$" + summaryOptions.sideCost.toFixed(2);
                        break;
                    case 2:
                        cost = "$" + summaryOptions.meatCost.toFixed(2);
                        break;
                    case 3:
                        cost = "$" + self.deliveryCost.toFixed(2);
                        break;
                    default:
                        window.alert("Error, please contact customer support");
                        window.location.assign("/");
                        break;
                }
                var titleValue = document.createTextNode(cost);
                value.appendChild(titleValue);
                contentDiv.appendChild(title);
                contentDiv.appendChild(value);
                row.appendChild(contentDiv);
                parentNode.appendChild(row);
            }
        },

        /**
		 * Function constructs temnplate for cart Listing
         */
		makeCartListingTemplate : function(cartItem) {

			var domItem = document.createElement("div");
			domItem.setAttribute("class","list-item");
			domItem.appendChild(Components.makeSelectionTemplate(cartItem.quantity));

			var foodDesciption = document.createTextNode(" "+ cartItem.food_name+""+Components.generateSideStrings(cartItem.attachedPaidSides)
				+Components.generateSideStrings(cartItem.attachedFreeSides)+ " "+Components.generateSideStrings(cartItem.attachedMeats));
			domItem.appendChild(foodDesciption);

			cartPanel.appendChild(domItem);

		},

        /**
		 *	Function makes select tags. The default quantity of a particular cart item is 10. Function will generate that count
         */
        makeSelectionTemplate : function(selectIndex) {
            var selectTag = document.createElement("select");
            selectTag.setAttribute("class","custom-select short-select");

        	for(var i = 1; i <= 10; i++) {
        		var selected = (i === selectIndex);

        		var optionsTag = document.createElement("option");
        		if(selected) {
                    optionsTag.setAttribute("selected",selected);
				}
        		optionsTag.appendChild(document.createTextNode(i));
        		selectTag.append(optionsTag);
			}
			selectTag.addEventListener("change",function() {
				console.log(this);
			});

			return selectTag;
		},

        /**
         * @param object
         * @returns {string}
         */

		generateSideStrings : function(object) {

        	var sides = '';

        	if(Object.keys(object).length > 0) {
        		sides =  " with ";
			}

        	for(var value in object) {
        		sides += object[value].name+", ";
			}

			return sides;
		}
    };

    /**
	 *
     * @type {{getCartItems: getCartItems, getDeliveryCost: getDeliveryCost}}
     */
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
		getDeliveryCost : function(callback) {
			
			$.ajax({
				url : '/api/delivery/cost',
				type : 'get',
				dataType : 'json',

				success : function(response) {
					self.deliveryCost = response;
					callback(response)
				},

				error : function () {
					console.info("Error fetching delivery cost");
				}

			});
		}
	};


	return { 

		ignite : function() {

			Transactions.getCartItems(function() {
				Transactions.getDeliveryCost(function() {
					Controller.viewCart();
				});
			});

		}

	}
})();

Cart.ignite();