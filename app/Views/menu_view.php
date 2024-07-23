<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">    
        <div class="d-flex justify-content-between align-items-center mb-4">    
            <h1>Menus & Tables of <?= esc($user['cafe_name']) ?></h1>
        </div>

        <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h2>Information</h2>
                            <div class="card">
                                <div class="card-body">
                                    <p>Email: <?= esc($user['email']) ?></p>
                                    <p>Address: <?= esc($user['address']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="row mb-2 mt-2">
                            <div class="col-md-6 mb-lg-0">
                                <h2>Menus</h2>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <a class="btn btn-primary" href="<?= base_url('menu/addedit?user_id=' . $user['user_id']);?>">Add Menu</a>
                            </div>
                        </divclass>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Menu Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody id="menuTableBody">
                            <?php foreach ($menus as $menu): ?>
                                <tr>
                                <td><?= esc($menu['menu_name']) ?></td>
                                <td><?= esc($menu['description']) ?></td>
                                <td>
                                    <a class="btn btn-sm btn-info me-2" href="<?= base_url('menu/dishes/'.$menu['menu_id']);?>"><i class="bi bi-eye-fill"></i></a>
                                    <a class="btn btn-sm btn-primary me-2" href="<?= base_url('menu/addedit/'.$menu['menu_id']);?>"><i class="bi bi-pencil-square"></i></a>
                                    <a class="btn btn-sm btn-danger me-2" href="<?= base_url('menu/delete/' . $menu['menu_id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')"><i class="bi bi-trash"></i></i></a>
                                </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>

                    <div class="row mb-3">
                        <div class="select-menu">
                            <h3>Menu shown in QR code</h3>
                            <select id="menuSelect" class="form-control">
                                <?php foreach ($menus as $menu): ?>
                                    <option value="<?= esc($menu['menu_id']) ?>"><?= esc($menu['menu_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="row mb-2">
                            <div class="col-md-6 mb-lg-0">
                                <h2>Tables</h2>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tableModal" id="addTableBtn">Add Table</button>
                            </div>
                        </div>
                            <table class="table">
                            <thead>
                            <tr>
                                <th>Table</th>
                                <th>Status</th>
                                <th>Order Status</th>
                                <th>Actions</th>
                                <th>QR Code</th>

                            </tr>
                            </thead>
                            <tbody id="tableTableBody">
                            <?php foreach ($tables as $table): ?>
                                <tr>
                                    <td><?= esc($table['table_name']) ?></td>
                                    <td><?= esc($table['status']) ?></td>
                                    <td>
                                        <?php if ($table['order_id']): ?>
                                            <a class="btn btn-sm btn-info me-2" href="<?= base_url('menu/orders/'.$table['table_id']);?>">
                                                <?= esc($table['order_status']) ?></a>
                                        <?php else: ?>
                                            <span>No Order</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <input type="hidden" class="table-id" value="<?= esc($table['table_id']) ?>">
                                        <input type="hidden" class="user-id" value="<?= esc($table['user_id']) ?>">
                                        <button type="button" class="btn btn-primary btn-sm edit-tables" data-bs-toggle="modal" data-bs-target="#tableModal"><i class="bi bi-pencil-square"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm delete-tables"><i class="bi bi-trash"></i></button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary generate-qr" data-bs-toggle="modal" data-bs-target="#QrCode" data-table-id="<?= esc($table['table_id']) ?>" data-table-name="<?= esc($menu['menu_id']) ?>">Generate</button>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            </table>
                        <div id="tableAlert" class="alert alert-dismissible fade show mt-3" role="alert" style="display: none;">
                            <span id="tableAlertMessage"></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
        </section>
    </div>    
</section>

<!-- table Modal -->
<div class="modal fade" id="tableModal" tabindex="-1" aria-labelledby="tableModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tableModalLabel">Add table</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="tableForm">
          <div class="mb-3">
            <label for="table_name" class="form-label">Table Name</label>
            <input type="text" class="form-control" id="table_name" name="table_name" required>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
              <select id="status" name="status" required>
                  <option value="Available" <?= isset($table) && $table['status'] === 'Available' ? 'selected' : '' ?>>Available</option>
                  <option value="Occupied" <?= isset($table) && $table['status'] === 'Occupied' ? 'selected' : '' ?>>Occupied</option>
              </select>
          </div>
          <input type="hidden" id="tableId" name="table_id">
          <input type="hidden" id="userId" name="user_id" value="<?= esc($user['user_id']) ?>">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="savetable">Save</button>
      </div>
    </div>
  </div>
</div>

 <!-- Template for QR Code -->
    <div class="modal fade" id="QrCode" tabindex="-1" aria-labelledby="qrcodeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrcodeLabel">QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Placeholder for QR Code -->
                    <div class="col d-flex justify-content-center" id="qrCodeDisplay"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


<!-- Template for new table row -->
<template id="tableRowTemplate">
  <tr>
    <td class="table_name"></td>
    <td class="qrcode"></td>
    <td class="status"></td>
    <td>
      <input type="hidden" class="table-id" value="">
      <input type="hidden" class="user-id" value="">
      <button type="button" class="btn btn-primary btn-sm edit-tables" data-bs-toggle="modal" data-bs-target="#tableModal"><i class="bi bi-pencil-square"></i></button>
      <button type="button" class="btn btn-danger btn-sm delete-tables"><i class="bi bi-trash"></i></button>
    </td>
  </tr>
</template>

<script>

  // Function to show the alert message
  function showAlert(message, type) {
    const alertBox = document.getElementById('tableAlert');
    const alertMessage = document.getElementById('tableAlertMessage');
    alertMessage.textContent = message;
    alertBox.classList.remove('alert-success', 'alert-danger');
    alertBox.classList.add(`alert-${type}`);
    alertBox.style.display = 'block';

    // Hide the alert after 10 seconds
    setTimeout(function() {
      alertBox.style.display = 'none';
    }, 5000);
  }


  // Add table Button Click
  document.getElementById('addTableBtn').addEventListener('click', function() {
    document.getElementById('tableModalLabel').textContent = 'Add Table';
    document.getElementById('tableForm').reset();
    document.getElementById('tableId').value = '';
  });

  // Edit table Button Click
  document.addEventListener('click', function(event) {
    if (event.target.classList.contains('edit-tables')) {
        const tableId = event.target.closest('tr').querySelector('.table-id').value;
        const userId = event.target.closest('tr').querySelector('.user-id').value;
        const status = event.target.closest('tr').cells[1].textContent;
        const table_name = event.target.closest('tr').cells[0].textContent;

        document.getElementById('tableModalLabel').textContent = 'Edit Table';
        document.getElementById('table_name').value = table_name;
        document.getElementById('status').value = status;
        document.getElementById('tableId').value = tableId;
        document.getElementById('userId').value = userId;
    }
  });

  // Save button in table modal clicked
  document.getElementById('savetable').addEventListener('click', function() {
    const form = document.getElementById('tableForm');
    const formData = new FormData(form);
    const tableId = formData.get('table_id');
    const data = Object.fromEntries(formData.entries());

    // If tableid exist
    if (tableId) {
      // Update existing table
      fetch(`<?= base_url("table"); ?>/${tableId}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(data => {
        if (data) {
          // table updated successfully
          const row = document.querySelector(`.table-id[value="${tableId}"]`).closest('tr');
          row.cells[0].textContent = formData.get('table_name');
          row.cells[1].textContent = formData.get('qrcode');
          row.cells[2].textContent = formData.get('status');
          bootstrap.Modal.getInstance(document.getElementById('tableModal')).hide();
          showAlert('table updated successfully.', 'success');
        } else {
          // Error occurred
          showAlert('Error updating table. Please try again.', 'danger');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showAlert('Error updating table. Please try again.', 'danger');
      });
    // If tableid not exist
    } else {
      // Add new table
      fetch('<?= base_url("table"); ?>', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(data => {
        if (data) {
          // table added successfully
          const template = document.getElementById('tableRowTemplate');
          const newRow = template.content.cloneNode(true);
          newRow.querySelector('.table-id').value = data.table_id;
          newRow.querySelector('.user-id').value = formData.get('user_id');
          newRow.querySelector('.qrcode').textContent = formData.get('qrcode');
          newRow.querySelector('.status').value = formData.get('status');
          newRow.querySelector('.table_name').textContent = formData.get('table_name');
          document.getElementById('tableTableBody').appendChild(newRow);
          form.reset();
          bootstrap.Modal.getInstance(document.getElementById('tableModal')).hide();
          showAlert('table added successfully.', 'success');
        } else {
          // Error occurred
          showAlert('Error adding table. Please try again.', 'danger');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showAlert('Error adding table. Please try again.', 'danger');
      });
    }
  });

  // Delete table Button Click
  document.addEventListener('click', function(event) {
    if (event.target.classList.contains('delete-tables')) {
      const tableId = event.target.closest('tr').querySelector('.table-id').value;
      const confirmation = confirm('Are you sure you want to delete this table?');

      if (confirmation) {
        fetch(`<?= base_url("table"); ?>/${tableId}`, {
          method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
          if (data) {
            // table deleted successfully
            event.target.closest('tr').remove();
            showAlert('table deleted successfully.', 'success');
          } else {
            // Error occurred
            console.error('Error deleting table:', data.error);
            showAlert('Error deleting table. Please try again.', 'danger');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showAlert('Error deleting table. Please try again.', 'danger');
        });
      }
    }
  });

  document.addEventListener("DOMContentLoaded", function() {
      // Generate button clicked
      document.querySelectorAll('.generate-qr').forEach(button => {
          button.addEventListener('click', function() {
              var tableId = this.getAttribute('data-table-id'); // get tableid
              var menuId = document.getElementById('menuSelect').value; // get menuid

              // build the ordering url with tableid and menuid
              var orderPageUrl = baseURL + `order/${tableId}/${menuId}`;

              // create a whole new qrcode
              var qrContainer = document.getElementById('qrCodeDisplay');
              qrContainer.innerHTML = ''; 
              var qrCode = new QRCode(qrContainer, {
                  text: orderPageUrl,
                  width: 300,
                  height: 300,
                  colorDark: "#000000",
                  colorLight: "#ffffff",
                  correctLevel: QRCode.CorrectLevel.H
              });
          });
      });
  });
</script>
<?= $this->endSection() ?>