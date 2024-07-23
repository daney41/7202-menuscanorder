<?= $this->extend('template') ?>
<?= $this->section('content') ?>

    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Order for <?= esc($table['table_name']) ?></h1>
            </div>

            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h3>Status</h3>
                                    <p> Total Price: A$ <?= esc($table['total_price']) ?></p>
                                    <p>Status: 
                                        <span id="orderStatus"><?= esc($table['order_status']) ?></span>
                                        <button class="btn btn-primary btn-sm" id="toggleStatusBtn" data-id="<?= esc($table['order_id']) ?>" style="margin-left: 10px;">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="row">
                            <div class="row mb-2">
                                <div class="col-md-6 mb-lg-0">
                                    <h2>Order Details</h2>
                                </div>
                            </div>
                            <div>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th style="width: 25%;">Dish Name</th>
                                            <th style="width: 60%;">Customization</th>
                                            <th style="width: 15%;">Quantity</th>
                                        </tr>
                                        </thead>
                                        <tbody id="dishTableBody">
                                        <?php foreach ($fullOrders as $order): ?>
                                            <tr>
                                                <td><?= esc($order['dish_name']) ?></td>
                                                <td>
                                                    <?= esc($order['customization']) ?>
                                                    <?php if (!empty($order['milk_type'])): ?>
                                                        <br><strong>Milk:</strong> <?= esc($order['milk_type']) ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= esc($order['quantity']) ?></td>
                                                <td>
                                                    <input type="hidden" class="user-id" value="<?= esc($order['user_id']) ?>">
                                                    <input type="hidden" class="order-id" value="<?= esc($order['order_id']) ?>">
                                                    <input type="hidden" class="dish-id" value="<?= esc($order['dish_id']) ?>">
                                                    <input type="hidden" class="user-id" value="<?= esc($order['user_id']) ?>">
                                                    <input type="hidden" class="customization-id" value="<?= esc($order['customization_id']) ?>">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                            </div>
                            <div id="dishAlert" class="alert alert-dismissible fade show mt-3" role="alert" style="display: none;">
                                <span id="dishAlertMessage"></span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
            </section>
        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var baseURL = '<?= base_url(); ?>';
    </script>
    <script>
        
        $(document).ready(function() {
            // check order status is complete or not and hide the button
            var initialStatus = $('#orderStatus').text().trim();
            if (initialStatus === 'Completed') {
                $('#toggleStatusBtn').hide();
            }

            // status changing button clicked
            $('#toggleStatusBtn').on('click', function() {
                var orderId = $(this).data('id');
                var currentStatus = $('#orderStatus').text().trim();
                var newStatus = '';

                // Check the status
                if (currentStatus === 'Preparing') {
                    newStatus = 'Completed';
                } else if (currentStatus === 'Received') {
                    newStatus = 'Preparing';
                }
                
                // chage order status with new status
                if (newStatus) {
                    $.ajax({
                        url: '<?= base_url("updateOrderStatus"); ?>',
                        method: 'PUT',
                        contentType: 'application/json',
                        data: JSON.stringify({ order_id: orderId, status: newStatus }),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '<?= csrf_hash() ?>' 
                        },
                        success: function(response) {
                            if (response.success) {
                                // status changing success
                                $('#orderStatus').text(newStatus);
                                showAlert('Order status updated successfully.', 'success');

                                if (newStatus === 'Completed') {
                                    $('#toggleStatusBtn').hide();
                                }
                            } else {
                                // ERROR handle
                                showAlert(response.message || 'Error updating order status. Please try again.', 'danger');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                            showAlert('Error updating order status. Please try again.', 'danger');
                        }
                    });
                }
            });

            function showAlert(message, type) {
                var alertBox = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                    message +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                $('#alert-container').append(alertBox);
                setTimeout(function() {
                    alertBox.alert('close');
                }, 3000);
            }
        });

    </script>
<?= $this->endSection() ?>