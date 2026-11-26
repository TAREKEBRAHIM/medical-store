<?= $this->Html->css('admin/admin-products') ?>

<?php
$user = $this->request->getAttribute('identity');
?>

<div class="admin-layout">

    <aside class="admin-sidebar">
        <div class="admin-brand">
            <span>Medical</span> Store
            <small>ADMIN PANEL</small>
        </div>

        <nav class="admin-nav">
            <a href="<?= $this->Url->build([
                            'prefix' => 'Admin',
                            'controller' => 'Products',
                            'action' => 'index'
                        ]) ?>" class="active">
                <span>▦</span> Products
            </a>

            <a href="/" class="nav-link" target="_blank">
                <span>◈</span> View Store
            </a>

            <a href="<?= $this->Url->build([
                            'controller' => 'Users',
                            'action' => 'logout',
                            'prefix' => false,
                        ]) ?>">
                <span>↪</span> Logout
            </a>
        </nav>
    </aside>

    <main class="admin-main">

        <header class="admin-topbar">
            <div>
                <p class="admin-eyebrow">MANAGEMENT</p>
                <h1>Products</h1>
            </div>

            <div class="admin-user">
                <span class="admin-avatar">A</span>
                <div>
                    <strong><?= h($user?->get('email') ?? 'Administrator') ?></strong>
                    <small>Administrator</small>
                </div>
            </div>
        </header>

        <section class="admin-stats">

            <div class="stat-card">
                <span>Total Products</span>
                <strong><?= h($totalProducts) ?></strong>
                <small>All products in store</small>
            </div>

            <div class="stat-card">
                <span>Active Products</span>
                <strong><?= h($activeProducts) ?></strong>
                <small>Currently visible products</small>
            </div>

            <div class="stat-card">
                <span>Low Stock</span>
                <strong><?= h($lowStockProducts) ?></strong>
                <small>Products with 5 or less items</small>
            </div>

        </section>

        <section class="products-panel">

            <div class="panel-header">
                <div>
                    <h2>All Products</h2>
                    <p>Manage your store products</p>
                </div>

                <?= $this->Html->link(
                    '+ Add New Product',
                    [
                        'prefix' => 'Admin',
                        'controller' => 'Products',
                        'action' => 'add'
                    ],
                    ['class' => 'add-product-btn']
                ) ?>
            </div>

            <form method="get"
                action="<?= $this->Url->build([
                            'prefix' => 'Admin',
                            'controller' => 'Products',
                            'action' => 'index'
                        ]) ?>"
                class="product-filters">

                <input
                    type="search"
                    name="q"
                    placeholder="Search products..."
                    value="<?= h($search) ?>">

                <select name="category_id">
                    <option value="">All Categories</option>

                    <?php foreach ($categories as $id => $name): ?>
                        <option
                            value="<?= h($id) ?>"
                            <?= (string)$categoryId === (string)$id ? 'selected' : '' ?>>
                            <?= h($name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">Filter</button>

                <a href="<?= $this->Url->build([
                                'prefix' => 'Admin',
                                'controller' => 'Products',
                                'action' => 'index'
                            ]) ?>">
                    Reset
                </a>

            </form>

            <div class="table-wrapper">
                <table class="admin-products-table">

                    <thead>
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
                                    <div class="product-info">

                                        <?php if (!empty($product->image)): ?>
                                            <img
                                                src="<?= $this->Url->image($product->image) ?>"
                                                alt="<?= h($product->name) ?>">
                                        <?php else: ?>
                                            <div class="product-placeholder">P</div>
                                        <?php endif; ?>

                                        <strong><?= h($product->name) ?></strong>

                                    </div>
                                </td>

                                <td>
                                    <?= h($product->category?->name ?? 'Uncategorized') ?>
                                </td>

                                <td>
                                    EGP <?= number_format((float)$product->price, 2) ?>
                                </td>

                                <td>
                                    <?= h($product->stock) ?>
                                </td>

                                <td>
                                    <?php if ($product->is_active): ?>
                                        <span class="status active">Active</span>
                                    <?php else: ?>
                                        <span class="status inactive">Inactive</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="product-actions">

                                        <?= $this->Html->link(
                                            'View',
                                            [
                                                'prefix' => 'Admin',
                                                'controller' => 'Products',
                                                'action' => 'view',
                                                $product->id
                                            ],
                                            ['class' => 'action-view']
                                        ) ?>

                                        <?= $this->Html->link(
                                            'Edit',
                                            [
                                                'prefix' => 'Admin',
                                                'controller' => 'Products',
                                                'action' => 'edit',
                                                $product->id
                                            ],
                                            ['class' => 'action-edit']
                                        ) ?>

                                        <?= $this->Form->postLink(
                                            'Delete',
                                            [
                                                'prefix' => 'Admin',
                                                'controller' => 'Products',
                                                'action' => 'delete',
                                                $product->id
                                            ],
                                            [
                                                'class' => 'action-delete',
                                                'confirm' => 'Are you sure you want to delete this product?',
                                            ]
                                        ) ?>

                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        <?php if (count($products) === 0): ?>
                            <tr>
                                <td colspan="6" class="empty-products">
                                    No products found.
                                </td>
                            </tr>
                        <?php endif; ?>

                    </tbody>

                </table>
            </div>

            <div class="pagination">
                <?= $this->Paginator->prev('Previous') ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next('Next') ?>
            </div>

        </section>

    </main>

</div>