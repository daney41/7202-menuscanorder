$(document).ready(function() {
    // order list to record the information about order in ordering page
    var order = {
        dishes: [],
        totalPrice: 0,
        lastOrderId: 0,
        user_id: user.user_id,
        table_id: table.table_id
    };

    // display order in order list at sidebar
    function updateOrderDisplay() {
        var $orderTableBody = $('#orderTableBody');
        $orderTableBody.empty(); 
        //show the dishes
        order.dishes.forEach(function(dish, index) {
            var $row = $('<tr>').html(`
                <td>${dish.dishName}</td>
                <td>${dish.quantity}</td>
                <td>A$${dish.dishPrice.toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm edit-order" data-bs-toggle="modal" 
                    data-bs-target="#addDishModal" 
                    data-dish-id="${dish.dishId}" 
                    data-dish-name="${dish.dishName}" 
                    data-category="${dish.dishCategory}" 
                    data-index="${dish.orderIndex}" 
                    data-customization="${dish.customization || ''}" 
                    data-milk="${dish.milk || ''}" 
                    data-quantity="${dish.quantity}" 
                    data-dish-price="${dish.dishPrice}">
                    <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm delete-order" data-index="${index}"><i class="bi bi-trash"></i></button>
                </td>
            `);
            $orderTableBody.append($row);

            // show the customization and milk
            var $customizationRow = $('<tr>').html(`
                <td colspan="4">Customization: ${dish.customization || 'None'}${dish.milk ? ', Milk: ' + dish.type : ''}</td>
            `);
            $orderTableBody.append($customizationRow);
        });
    }

    // Update the order summary (total items and total price)
    function updateOrderSummary() {
        var totalItems = 0;
        var priceSum = 0;
        order.dishes.forEach(function(dish) {
            totalItems += dish.quantity;
            priceSum += dish.totalDishPrice;
        });
        $('#totalItems').text(totalItems);
        $('#totalPrice').text(`$${priceSum.toFixed(2)}`);
    }

    // Add dish to order
    function addDishToOrder() {
        var dishId = $('#currentDishId').val();
        var dishName = $('#addDishModalLabel').text().replace(/^(Add|Edit) Dish - /, '');
        var dishIndex = parseInt($('#currentDishIndex').val(),10);
        var quantity = parseInt($('#dishQuantity').val(), 10);
        var customize = $('#customText').val();
        var milkSelect = $('#milkSelect');
        var milkchoose = milkSelect.val();
        var milktype = milkSelect.find('option:selected').text();
        var category = $('#dishCategory').val();

        var priceWithCurrency = $('#currentDishPrice').text();
        var priceOnly = priceWithCurrency.replace(/[^\d\.]/g, '');
        var dishPrice = parseFloat(priceOnly);

        if (isNaN(quantity) || quantity <= 0) {
            alert('Please enter a valid quantity');
            return;
        }

        var foundIndex = order.dishes.findIndex(function(dish) {
            return dish.orderIndex === dishIndex;
        });

        if (foundIndex !== -1) {
            // Dish already exists, update the existing dish
            var dish = order.dishes[foundIndex];
            dish.quantity = quantity;
            dish.customization = customize;
            dish.milk = milkchoose;
            dish.type = milktype;
            dish.totalDishPrice = quantity * dishPrice;
        } else {
            // New dish, add to the order
            var totalDishPrice = quantity * dishPrice;
            var newIndex = dishIndex || order.lastOrderId + 1;
            order.dishes.push({
                orderIndex: newIndex,
                dishId: dishId,
                dishName: dishName,
                dishCategory: category,
                dishPrice: dishPrice,
                quantity: quantity,
                customization: customize,
                milk: milkchoose,
                type: milktype,
                totalDishPrice: totalDishPrice
            });
            order.lastOrderId = Math.max(order.lastOrderId, newIndex);
        }

        order.totalPrice = order.dishes.reduce(function(sum, dish) { return sum + dish.totalDishPrice; }, 0);
        updateOrderDisplay();
        updateOrderSummary();

        // hide the modal after adding dish
        bootstrap.Modal.getInstance($('#addDishModal')[0]).hide();
    }

    // Delete dish from the order
    function deleteDishFromOrder(dishId) {
        var dishIndex = order.dishes.findIndex(function(dish) { return dish.dishId === dishId; });
        if (dishIndex !== -1) {
            order.dishes.splice(dishIndex, 1);
            order.totalPrice = order.dishes.reduce(function(sum, dish) { return sum + dish.totalDishPrice; }, 0);
            updateOrderDisplay();
            updateOrderSummary();
            alert("Dish removed successfully!");
        } else {
            alert("Dish not found in the order!");
        }
    }

    // Toggle the sidebar visibility
    $('.toggle-sidebar').click(function() {
        $('#orderSidebar').toggleClass('active');
        $('.container').toggleClass('active');
    });

    // Close the sidebar when clicking outside
    $(document).click(function(event) {
        if (!$(event.target).closest('#orderSidebar, .toggle-sidebar').length && $('#orderSidebar').hasClass('active')) {
            $('#orderSidebar').removeClass('active');
            $('.container').removeClass('active');
        }
    });

    // add button was clicked
    $(document).on('click', '.add-dish', function() {
        var button = $(this);
        var dishId = button.data('dish-id');
        var dishName = button.data('dish-name');
        var dishPrice = button.data('dish-price');
        var category = button.data('category');

        $('#addDishModalLabel').text('Add Dish - ' + dishName);
        $('#currentDishId').val(dishId);
        $('#currentDishPrice').text(`A$${parseFloat(dishPrice).toFixed(2)}`);

        var milkContainer = $('#milkOptionsContainer');
        var customizationContainer = $('#customizationContainer');
        if (category === 'Coffee') {
            milkContainer.show();
            customizationContainer.hide();
        } else {
            milkContainer.hide();
            customizationContainer.show();
        }

        $('#dishQuantity').val(1);
        $('#customText').val('');
        $('#milkSelect').val('');
        $('#dishCategory').val(category);
        $('#modalActionButton').text('Add to Order');
    });

    // Edit button was clicked
    $(document).on('click', '.edit-order', function() {
        var button = $(this);
        var dishId = button.data('dish-id');
        var dishName = button.data('dish-name');
        var dishPrice = button.data('dish-price');
        var customization = button.data('customization');
        var milk = button.data('milk');
        var quantity = button.data('quantity');
        var dishIndex = button.data('index');
        var category = button.data('category');

        $('#customText').val(customization);
        $('#milkSelect').val(milk);
        $('#dishQuantity').val(quantity);
        $('#currentDishIndex').val(dishIndex);

        $('#addDishModalLabel').text('Edit Dish - ' + dishName);
        $('#currentDishId').val(dishId);
        $('#currentDishPrice').text(`A$${parseFloat(dishPrice).toFixed(2)}`);

        var milkContainer = $('#milkOptionsContainer');
        var customizationContainer = $('#customizationContainer');
        if (category === 'Coffee') {
            milkContainer.show();
            customizationContainer.hide();
        } else {
            milkContainer.hide();
            customizationContainer.show();
        }

        $('#modalActionButton').text('Save');

        bootstrap.Modal.getInstance($('#addDishModal')[0]).show();
    });

    //Delete dish from order list
    $(document).on('click', '.delete-order', function() {
        var dishId = $(this).data('index'); 
        deleteDishFromOrder(dishId);
    });

    // Add dish to order list when Save button was clicked
    $(document).ready(function() {
        $('#modalActionButton').on('click', function() {
            addDishToOrder();
        });
    });

    // Place order button clicked and send the information to server
    $('#placeOrderBtn').click(function() {
        if (order.dishes.length === 0) {
            alert('Please add some dishes to your order before placing it.');
            return;
        }

        var placeOrderURL = baseURL + 'place_order';
        console.log('Place Order URL:', placeOrderURL);

        $.ajax({
            url: placeOrderURL,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(order),
            success: function(data) {
                if (data.success) {
                    var orderId = data.order_id;
                    var customizationIds = data.customization_ids;

                    // Prepare order details data
                    var orderDetails = order.dishes.map(function(dish, index) {
                        return {
                            order_id: orderId,
                            dish_id: dish.dishId,
                            milk_id: dish.milk,
                            customization_id: customizationIds[index] || null,
                            quantity: dish.quantity
                        };
                    });

                    var placeOrderDetailsURL = baseURL + 'place_order_details';
                    console.log('Place Order Details URL:', placeOrderDetailsURL);

                    // Send order details to the server
                    $.ajax({
                        url: placeOrderDetailsURL,
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(orderDetails),
                        success: function(detailsData) {
                            if (detailsData.success) {
                                alert('Order placed successfully!');
                                order = { dishes: [], totalPrice: 0 };
                                updateOrderDisplay();
                                updateOrderSummary();
                            } else {
                                alert('Failed to place order details.');
                            }
                        }
                    });
                } else {
                    alert('Failed to place order.');
                }
            }
        });
    });

});
