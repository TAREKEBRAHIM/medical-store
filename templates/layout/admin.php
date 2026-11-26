<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?= $this->fetch('title') ?: 'Medical Store Admin' ?>
    </title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- OverlayScrollbars -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css">

    <!-- AdminLTE 4 -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/admin-lte@4.10.0/dist/css/adminlte.min.css">

    <!-- Page-specific CSS -->
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">

        <!-- Top Navbar -->
        <nav class="app-header navbar navbar-expand bg-body">

            <div class="container-fluid">

                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link"
                            data-lte-toggle="sidebar"
                            href="#"
                            role="button"
                            aria-label="Toggle sidebar">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>

                    <li class="nav-item d-none d-md-block">
                        <span class="nav-link fw-semibold">
                            Medical Store Admin
                        </span>
                    </li>

                </ul>

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="<?= $this->Url->build('/') ?>" target="_blank">
                            <i class="bi bi-box-arrow-up-right"></i>
                            View Store
                        </a>
                    </li>

                </ul>

            </div>

        </nav>

        <!-- Sidebar -->
        <aside class="app-sidebar bg-dark shadow"
            data-bs-theme="dark">

            <div class="sidebar-brand">
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Products', 'action' => 'index']) ?>" class="brand-link">
                    <span class="brand-text fw-light">
                        Medical Store
                    </span>
                </a>
            </div>

            <div class="sidebar-wrapper">

                <nav class="mt-2">

                    <ul class="nav sidebar-menu flex-column"
                        data-lte-toggle="treeview"
                        role="menu">

                        <li class="nav-item">
                            <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Products', 'action' => 'index']) ?>" class="nav-link active"> <i class="nav-icon bi bi-box-seam"></i>
                                <p>Products</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Orders', 'action' => 'index']) ?>" class="nav-link">
                                <i class="nav-icon bi bi-receipt"></i>
                                <p>Orders</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="<?= $this->Url->build('/') ?>" class="nav-link" target="_blank">
                                <i class="nav-icon bi bi-shop"></i>
                                <p>View Store</p>
                            </a>
                        </li>

                    </ul>

                </nav>

            </div>

        </aside>

        <!-- Main Content -->
        <main class="app-main">

            <div class="app-content">
                <div class="container-fluid py-3">

                    <?= $this->Flash->render() ?>

                    <?= $this->fetch('content') ?>

                </div>
            </div>

        </main>

        <!-- Footer -->
        <footer class="app-footer">
            <strong>Medical Store</strong>
            <span class="float-end d-none d-sm-inline">
                Admin Panel
            </span>
        </footer>

    </div>

    <!-- JavaScript Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.10.0/dist/js/adminlte.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <?= $this->fetch('script') ?>

</body>

</html>