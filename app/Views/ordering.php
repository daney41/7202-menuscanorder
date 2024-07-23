<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MenuScanOrder</title>
    <!-- This is the main stylesheet for Bootstrap. It includes all the CSS necessary for Bootstrap's components and utilities to work. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Include Bootstrap Icons -->
    <!-- This link imports the Bootstrap Icons library, which provides a wide range of SVG icons for use in your projects. -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        #orderSidebar {
            display: flex;
            flex-direction: column; 
            height: 100%; 
        }

        .sidebar {
            width: 350px;
            position: fixed;
            right: -400px; 
            top: 0;
            bottom: 0;
            height: 100vh;
            background-color: #f8f9fa;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: right 0.2s ease-out;
        }

        .sidebar.active {
            right: 0; 
        }

        .orderinfo{
            margin-bottom: 0;
            border:1px solid #ffffff;
            padding: 5px;
            border-radius:3px;
        }

        .sidebar-content {
            padding: 10px;
            overflow: hidden; 
        }

        #orderSidebar .table {
            flex-grow: 1; 
            overflow-y: auto; 
            display: block; 
            margin-bottom:0;
        }

        .sidebar-footer {
            padding: 10px;
            background: #ffffff;
            border-top: 1px solid #ccc; 
        }

        #orderSidebar table thead tr th {
            position: sticky;
            top: 0;
            background-color: #fff;
            z-index: 10;
        }
        #orderTableBody tr td {
            width: 10%;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container" style="margin-right: 0">
            <a class="navbar-brand"><?= esc($user['cafe_name']) ?></a>
            <div class="navbar-brand toggle-sidebar">
                <h4 class="orderinfo">Order Information</h4>
            </div>
        </div>

    </nav>
</header>

<div id="orderSidebar" class="sidebar">
    <div class="sidebar-content p-4">
        <div class="mb-3">Table: <strong><span id="tableInfo"><?= esc($table['table_name']) ?></span></strong></div>
        <div class="mb-3">Total Items: <strong><span id="totalItems">0</span></strong></div>
        <div>Total Price: <strong><span id="totalPrice">$0.00</span></strong></div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th style="width: 40%">Name</th>
            <th style="width: 30%">Amount</th>
            <th style="width: 30%">Price</th>
            <th style="width: 10%"></th>
        </tr>
        </thead>
        <tbody id="orderTableBody">
        <!-- Items will be added here by JavaScript -->
        </tbody>
    </table>
    <div class="sidebar-footer p-4">
        <button type="button" class="btn btn-primary" id="placeOrderBtn">Place Order</button>
    </div>
</div>

<main class="flex-grow-1">
<section class="py-4">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <?php foreach ($categoriesDishes as $category_data): ?>
                    <h4><?= esc($category_data['category_info']['name']) ?></h4>
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="width: 25%;">Name</th>
                            <th style="width: 40%;">Description</th>
                            <th style="width: 15%;">Price</th>
                            <th style="width: 20%;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($category_data['dishes'] as $dish): ?>
                            <tr>
                                <td><?= esc($dish['dish_name']) ?></td>
                                <td><?= esc($dish['description']) ?></td>
                                <td>A$<?= esc($dish['price']) ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm add-dish"
                                            data-dish-id="<?= esc($dish['dish_id']) ?>"
                                            data-dish-name="<?= esc($dish['dish_name']) ?>"
                                            data-dish-description="<?= esc($dish['description']) ?>"
                                            data-dish-price="<?= esc($dish['price']) ?>"
                                            data-category="<?= esc($category_data['category_info']['name']) ?>"
                                            data-bs-toggle="modal" data-bs-target="#addDishModal">
                                        Add
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endforeach; ?>
            </div>
        </div>


    </div>

    <!-- Add Dish Modal -->
    <div class="modal fade" id="addDishModal" tabindex="-1" aria-labelledby="addDishModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDishModalLabel">Add Dish</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="addDishForm">
                        <div class="mb-3">
                            <label for="dishQuantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="dishQuantity" name="quantity" value="1" min="1">
                        </div>
                        <div class="mb-3" id="milkOptionsContainer" style="display: none;">
                            <label for="milkSelect" class="form-label">Choose Milk (only for coffee)</label>
                            <select class="form-select" id="milkSelect" name="milkType">
                                <option value="">Select Milk</option>
                                <?php foreach ($milks as $milk): ?>
                                    <?php if ($milk['milk_type'] !== 'not selected'): ?>
                                        <option value="<?= htmlspecialchars($milk['milk_id']) ?>"><?= htmlspecialchars($milk['milk_type']) ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3" id="customizationContainer" style="display: none;">
                            <label for="customText" class="form-label">Customization</label>
                            <input type="text" class="form-control" id="customText" name="customText">
                        </div>
                        <input type="hidden" id="currentDishId" name="dish_id">
                        <input type="hidden" id="currentDishIndex" name="dish_index">
                        <input type="hidden" id="dishCategory" name="dish_category">
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="me-3" type="number" id="currentDishPrice" name="dish_price"></div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modalActionButton">Save</button>

                </div>
            </div>
        </div>
    </div>
</section>
</main>

<footer class="bg-dark text-light py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p>&copy; <?= date('Y') ?> MenuScanOrder. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="text-light me-3">Privacy Policy</a>
                <a href="#" class="text-light">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    var baseURL = '<?= base_url(); ?>';
    var user = <?= json_encode($user); ?>;
    var table = <?= json_encode($table); ?>;
</script>
<script src="<?= base_url(); ?>javascript/script.js"></script>
</body>
</html>
