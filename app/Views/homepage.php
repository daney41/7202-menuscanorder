<?= $this->extend('template') ?>
<?= $this->section('content') ?>

        <section class="py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h1 class="display-4">Create your own contactless order Menu</h1>
                        <p class="lead">MenuScanOrder makes it simple to create your own Menu; simply type in or upload your Menu, and everything will be completed in seconds.</p>
                        <a href="log_in.html" class="btn btn-primary btn-lg mb-3 mb-lg-0">Get Started</a>
                    </div>
                    <div class="col-lg-6">
                        <img src= "<?= base_url("picture/menuscanorder.png"); ?>" alt="writing menu" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <h2 class="text-center mb-4">Features</h2>
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Digital Menu Creation</h4>
                                <p class="card-text">Easily create and manage a digital menu with categories, items, and pricing.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">QR Code Generation</h4>
                                <p class="card-text">Automatically generates unique QR codes for each table, facilitating easy access to the menu by guests.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Order Management</h4>
                                <p class="card-text">Staff can view and manage orders in real time, ensuring a smooth dining experience for guests.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
<?= $this->endSection() ?>