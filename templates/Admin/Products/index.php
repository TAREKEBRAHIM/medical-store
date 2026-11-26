<?php
$this->assign('title', 'Products Management');
?>

<div class="container-fluid">

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Products Management</h2>
            <p class="text-muted">Manage your healthcare products.</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Total Products</p>
                    <h3 class="fw-bold mb-0">
                        <?= number_format($totalProducts) ?>
                    </h3>
                    <i class="bi bi-box-seam text-primary fs-4"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Active Products</p>
                    <h3 class="fw-bold mb-0">
                        <?= number_format($activeProducts) ?>
                    </h3>
                    <i class="bi bi-check-circle text-success fs-4"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Low Stock Products</p>
                    <h3 class="fw-bold mb-0">
                        <?= number_format($lowStockProducts) ?>
                    </h3>
                    <i class="bi bi-exclamation-triangle text-warning fs-4"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Total Categories</p>
                    <h3 class="fw-bold mb-0">
                        <?= number_format($totalCategories) ?>
                    </h3>
                    <i class="bi bi-tags text-info fs-4"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Total Customers</p>
                    <h3 class="fw-bold mb-0">
                        <?= number_format($totalCustomers) ?>
                    </h3>
                    <i class="bi bi-people text-secondary fs-4"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Charts -->
    <div class="row g-3 mb-4">

        <div class="col-12 col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="fw-bold mb-0">Products by Category</h5>
                </div>
                <div class="card-body">
                    <div style="height: 280px;">
                        <canvas
                            id="categoryChart"
                            data-labels="<?= h($categoryLabelsJson) ?>"
                            data-values="<?= h($categoryDataJson) ?>"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="fw-bold mb-0">Product Status</h5>
                </div>
                <div class="card-body">
                    <div style="height: 280px;">
                        <canvas
                            id="statusChart"
                            data-values="<?= h($statusDataJson) ?>"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Products Table -->
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                <div>
                    <h5 class="fw-bold mb-1">All Products</h5>
                    <p class="text-muted mb-0">Manage your healthcare products.</p>
                </div>

                <?= $this->Html->link(
                    '<i class="bi bi-plus-lg"></i> Add New Product',
                    [
                        'prefix' => 'Admin',
                        'controller' => 'Products',
                        'action' => 'add'
                    ],
                    [
                        'class' => 'btn btn-primary',
                        'escape' => false
                    ]
                ) ?>

            </div>
        </div>

        <div class="card-body">

            <!-- Search and Filter -->
            <?= $this->Form->create(null, [
                'type' => 'get',
                'url' => [
                    'prefix' => 'Admin',
                    'controller' => 'Products',
                    'action' => 'index'
                ],
                'class' => 'row g-2 mb-4'
            ]) ?>

            <div class="col-12 col-md-5">
                <?= $this->Form->control('q', [
                    'label' => false,
                    'placeholder' => 'Search products...',
                    'value' => $search,
                    'class' => 'form-control'
                ]) ?>
            </div>

            <div class="col-12 col-md-4">
                <?= $this->Form->control('category_id', [
                    'type' => 'select',
                    'label' => false,
                    'options' => $categories,
                    'empty' => 'All Categories',
                    'value' => $categoryId,
                    'class' => 'form-select'
                ]) ?>
            </div>

            <div class="col-12 col-md-3 d-flex gap-2">
                <?= $this->Form->button(
                    '<i class="bi bi-funnel"></i> Filter',
                    [
                        'class' => 'btn btn-dark',
                        'escapeTitle' => false
                    ]
                ) ?>

                <?= $this->Html->link(
                    'Reset',
                    [
                        'prefix' => 'Admin',
                        'controller' => 'Products',
                        'action' => 'index'
                    ],
                    ['class' => 'btn btn-outline-secondary']
                ) ?>
            </div>

            <?= $this->Form->end() ?>

            <!-- Products Table -->
            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($products as $product): ?>

                            <tr>

                                <td>
                                    <div class="d-flex align-items-center gap-2">

                                        <?php if (!empty($product->image)): ?>
                                            <?= $this->Html->image($product->image, [
                                                'alt' => $product->name,
                                                'style' => 'width:45px;height:45px;object-fit:cover;border-radius:8px;'
                                            ]) ?>
                                        <?php endif; ?>

                                        <strong><?= h($product->name) ?></strong>

                                    </div>
                                </td>

                                <td>
                                    <?= h($product->category->name ?? 'Uncategorized') ?>
                                </td>

                                <td>
                                    EGP <?= number_format((float)$product->price, 2) ?>
                                </td>

                                <td>
                                    <?= h($product->stock) ?>
                                </td>

                                <td>
                                    <?php if ($product->is_active): ?>
                                        <span class="badge text-bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge text-bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="d-flex gap-2">

                                        <?= $this->Html->link(
                                            '<i class="bi bi-pencil"></i>',
                                            [
                                                'prefix' => 'Admin',
                                                'controller' => 'Products',
                                                'action' => 'edit',
                                                $product->id
                                            ],
                                            [
                                                'class' => 'btn btn-sm btn-outline-primary',
                                                'escape' => false,
                                                'title' => 'Edit'
                                            ]
                                        ) ?>

                                        <?= $this->Form->postLink(
                                            '<i class="bi bi-trash"></i>',
                                            [
                                                'prefix' => 'Admin',
                                                'controller' => 'Products',
                                                'action' => 'delete',
                                                $product->id
                                            ],
                                            [
                                                'confirm' => 'Are you sure you want to delete this product?',
                                                'class' => 'btn btn-sm btn-outline-danger',
                                                'escapeTitle' => false,
                                                'title' => 'Delete'
                                            ]
                                        ) ?>

                                    </div>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                        <?php if ($products->count() === 0): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No products found.
                                </td>
                            </tr>
                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <!-- Pagination -->
           <!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    <nav aria-label="Products pagination">
        <ul class="pagination pagination-sm gap-2 mb-0">

            <?= $this->Paginator->prev(
                'Previous',
                ['class' => 'page-link rounded']
            ) ?>

            <?= $this->Paginator->numbers([
                'class' => 'page-link rounded',
                'currentClass' => 'active',
                'modulus' => 2,
            ]) ?>

            <?= $this->Paginator->next(
                'Next',
                ['class' => 'page-link rounded']
            ) ?>

        </ul>
    </nav>
</div>

        </div>

    </div>

</div>



<?php
$categoryLabelsJson = json_encode(
    $categoryChartLabels,
    JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
);

$categoryDataJson = json_encode($categoryChartData);

$statusDataJson = json_encode($statusChartData);
?>

<?= $this->Html->script('admin/products-dashboard') ?>