<?= $this->extend('template') ?>
<?= $this->section('content') ?>

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h2 class="text-center mb-4"><?= isset($menu) ? 'Edit Menu' : 'Add Menu' ?></h2>
                    <form method="post" action="<?= base_url('menu/addedit' . (isset($menu) ? '/' . $menu['menu_id'] : '')) ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Menu Name</label>
                            <input type="text" class="form-control" id="name" name="menu_name" value="<?= isset($menu) ? esc($menu['menu_name']) : '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description" value="<?= isset($menu) ? esc($menu['description']) : '' ?>">
                        </div>
                        <?php
                        // 判断menu是否存在且包含user_id，如果不存在或没有user_id，则尝试使用user的user_id
                        $userId = isset($menu['user_id']) ? $menu['user_id'] : (isset($user['user_id']) ? $user['user_id'] : null);
                        ?>
                        <input type="hidden" class="user-id" name = "user_id" value="<?= esc($userId) ?>">
                        <button type="submit" class="btn btn-primary"><?= isset($menu) ? 'Update Menu' : 'Add Menu' ?></button>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>