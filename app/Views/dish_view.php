<?= $this->extend('template') ?>
<?= $this->section('content') ?>

    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><?= esc($menu['menu_name']) ?></h1>
            </div>

            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="ml-3">Description</h3>
                            <div class="card">
                                <div class="card-body">
                                    <p> <?= esc($menu['description']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="row">
                            <div class="row mb-2">
                                <div class="col-md-6 mb-lg-0">
                                    <h2>Dishes</h2>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dishModal" id="addDishBtn">Add Dishes</button>
                                </div>
                            </div>
                            <div>
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
                                    <tbody id="dishTableBody">
                                    
                                    <!-- This block will retrieve all the dishes store inside category_data
                                    in order by cateogry. if one category don't have any dishes inside, 
                                    "No dishes available for this category." will be shown. -->
                                    <?php foreach ($category_data['dishes'] as $dish): ?>
                                        <tr>
                                            <td><?= esc($dish['dish_name']) ?></td>
                                            <td><?= esc($dish['description']) ?></td>
                                            <td>A$<?= esc($dish['price']) ?></td>
                                            <td>
                                                <input type="hidden" class="dish-id" value="<?= esc($dish['dish_id']) ?>">
                                                <input type="hidden" class="menu-id" value="<?= esc($dish['menu_id']) ?>">
                                                <input type="hidden" class="category-id" value="<?= esc($dish['category_id']) ?>">
                                                <button type="button" class="btn btn-primary btn-sm edit-dishes" data-bs-toggle="modal" data-bs-target="#dishModal"><i class="bi bi-pencil-square"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm delete-dishes"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($category_data['dishes'])): ?>
                                        <tr><td colspan="4">No dishes available for this category.</td></tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            <?php endforeach; ?>
                            </div>
                            <div id="dishAlert" class="alert alert-dismissible fade show mt-3" role="alert" style="display: none;">
                                <span id="dishAlertMessage"></span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
            </section>
        </div>
    </section>

    <!-- dish Modal -->
    <div class="modal fade" id="dishModal" tabindex="-1" aria-labelledby="dishModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dishModalLabel">Add Dish</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="dishForm">
                        <div class="mb-3">
                            <label for="dish_name" class="form-label">Dish Name</label>
                            <input type="text" class="form-control" id="dish_name" name="dish_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Price</label>
                            <input type="text" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Category</label>
                                <select class="form-control" id="category" name="category_id" required>
                                    <?php foreach ($categoriesDishes as $category): ?>
                                        <option value="<?= esc($category['category_info']['category_id']); ?>"
                                            <?= isset($dishes) && $dishes['category_id'] == $category['category_info']['category_id'] ? 'selected' : ''; ?>>
                                            <?= esc($category['category_info']['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                        </div>
                        <input type="hidden" id="dishId" name="dish_id">
                        <input type="hidden" id="menuId" name="menu_id" value="<?= esc($menu['menu_id']) ?>">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="savedish">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Template for new dish row -->
    <template id="dishRowTemplate">
        <tr>
            <td class="dish_name"></td>
            <td class="description"></td>
            <td class="price"></td>
            <td>
                <input type="hidden" class="dish-id" value="">
                <input type="hidden" class="menu-id" value="">
                <button type="button" class="btn btn-primary btn-sm edit-dishes" data-bs-toggle="modal" data-bs-target="#dishModal">Edit</button>
                <button type="button" class="btn btn-danger btn-sm delete-dishes">Delete</button>
            </td>
        </tr>
    </template>

    <script>

        // Function to show the alert message
        function showAlert(message, type) {
            const alertBox = document.getElementById('dishAlert');
            const alertMessage = document.getElementById('dishAlertMessage');
            alertMessage.textContent = message;
            alertBox.classList.remove('alert-success', 'alert-danger');
            alertBox.classList.add(`alert-${type}`);
            alertBox.style.display = 'block';

            // Hide the alert after 10 seconds
            setTimeout(function() {
                alertBox.style.display = 'none';
            }, 5000);
        }


        // Add dish Button Click
        document.getElementById('addDishBtn').addEventListener('click', function() {
            document.getElementById('dishModalLabel').textContent = 'Add dish';
            document.getElementById('dishForm').reset();
            document.getElementById('dishId').value = '';
        });

        // Edit dish Button Click
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('edit-dishes')) {
                const row = event.target.closest('tr');
                const dishId = row.querySelector('.dish-id').value;
                const menuId = row.querySelector('.menu-id').value;
                const categoryId = row.querySelector('.category-id').value;
                const description = row.cells[1].textContent;
                const price = row.cells[2].textContent;
                const dish_name = row.cells[0].textContent;

                document.getElementById('dishModalLabel').textContent = 'Edit Dish';
                document.getElementById('dish_name').value = dish_name;
                document.getElementById('description').value = description;
                document.getElementById('price').value = price;
                document.getElementById('dishId').value = dishId;
                document.getElementById('menuId').value = menuId;

                const categorySelect = document.getElementById('category');
                categorySelect.value = categoryId;
            }
        });

        // Save button in add dish modal clicked
        document.getElementById('savedish').addEventListener('click', function() {
            const form = document.getElementById('dishForm');
            const formData = new FormData(form);
            const dishId = formData.get('dish_id');
            const data = Object.fromEntries(formData.entries());

            // If dishid exist
            if (dishId) {
                // Update existing dish
                fetch(`<?= base_url("dishes"); ?>/${dishId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data) {
                            // dish updated successfully
                            const row = document.querySelector(`.dish-id[value="${dishId}"]`).closest('tr');
                            row.cells[0].textContent = formData.get('dish_name');
                            row.cells[1].textContent = formData.get('description');
                            row.cells[2].textContent = formData.get('price');
                            bootstrap.Modal.getInstance(document.getElementById('dishModal')).hide();
                            showAlert('dish updated successfully.', 'success');
                            location.reload();
                        } else {
                            // Error occurred
                            showAlert('Error updating dish. Please try again.', 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('Error updating dish. Please try again.', 'danger');
                    });
            // If dishId not exist
            } else { 
                // Add new dish
                console.log("fetching data");
                fetch('<?= base_url("dishes"); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log("end fetching");
                        if (data) {
                            console.log(data);
                            // dish added successfully
                            const template = document.getElementById('dishRowTemplate');
                            const newRow = template.content.cloneNode(true);
                            newRow.querySelector('.dish-id').value = data.dish_id;
                            newRow.querySelector('.menu-id').value = formData.get('menu_id');
                            newRow.querySelector('.description').textContent = formData.get('description');
                            newRow.querySelector('.price').value = formData.get('price');
                            newRow.querySelector('.dish_name').textContent = formData.get('dish_name');
                            document.getElementById('dishTableBody').appendChild(newRow);
                            form.reset();
                            bootstrap.Modal.getInstance(document.getElementById('dishModal')).hide();
                            showAlert('dish added successfully.', 'success');
                            location.reload();
                        } else {
                            // Error occurred
                            showAlert('Error adding dish. Please try again.', 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('Error adding dish. Please try again.', 'danger');
                    });
            }
        });

        // Delete dish Button Click
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('delete-dishes')) {
                const dishId = event.target.closest('tr').querySelector('.dish-id').value;
                const confirmation = confirm('Are you sure you want to delete this dish?');

                if (confirmation) {
                    fetch(`<?= base_url("dishes"); ?>/${dishId}`, {
                        method: 'DELETE'
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data) {
                                // dish deleted successfully
                                event.target.closest('tr').remove();
                                showAlert('dish deleted successfully.', 'success');
                            } else {
                                // Error occurred
                                console.error('Error deleting dish:', data.error);
                                showAlert('Error deleting dish. Please try again.', 'danger');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showAlert('Error deleting dish. Please try again.', 'danger');
                        });
                }
            }
        });
    </script>
<?= $this->endSection() ?>