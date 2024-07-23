<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h2 class="text-center mb-4"><?= isset($restaurant) ? 'Edit Restaurant' : 'Add Restaurant' ?></h2>
                <form method="post" action="<?= base_url('admin/addedit' . (isset($restaurant) ? '/' . $restaurant['user_id'] : '')) ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Cafe Name</label>
                        <input type="text" class="form-control" id="name" name="cafe_name" value="<?= isset($restaurant) ? esc($restaurant['cafe_name']) : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= esc($user['email']) ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?= isset($restaurant) ? esc($restaurant['address']) : '' ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><?= isset($restaurant) ? 'Update' : 'Add' ?> Restaurant</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
