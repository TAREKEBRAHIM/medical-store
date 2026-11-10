
<?= $this->Html->css('products') ?>

<?php
$user = $this->request->getAttribute('identity');
$isAdmin = $user && $user->get('role') === 'admin';
?>

<section class="products-page">
    <div class="container">

        <header class="products-header">
            <p class="section-eyebrow">OUR HEALTHCARE COLLECTION</p>
            <h1>All Products</h1>
            <p>Explore our healthcare and wellness products.</p>
        </header>

        <?php if ($isAdmin): ?>
            <div class="add-product-link">

                <?= $this->Html->link(
                    'Add New Product',
                    ['action' => 'add']
                ) ?>

            </div>
        <?php endif; ?>

        <!-- Categories Filter -->
        <div class="products-filter">

            <a
                href="/products"
                class="filter-link<?= $this->getRequest()->getQuery('category_id') === null ? ' is-active' : '' ?>"
                <?= $this->getRequest()->getQuery('category_id') === null ? 'aria-current="true"' : '' ?>>
                All Products
            </a>

            <?php foreach ($categories as $category): ?>

                <a
                    href="/products?category_id=<?= h($category->id) ?>"
                    class="filter-link<?= (string)$this->getRequest()->getQuery('category_id') === (string)$category->id ? ' is-active' : '' ?>"
                    <?= (string)$this->getRequest()->getQuery('category_id') === (string)$category->id ? 'aria-current="true"' : '' ?>>
                    <?= h($category->name) ?>
                </a>

            <?php endforeach; ?>

        </div>

        <!-- Products Grid -->
        <div class="products-grid">

            <?php foreach ($products as $product): ?>

                <article class="product-card">

                    <!-- Product Image -->
                    <div class="product-image">

                        <?php if (!empty($product->image)): ?>

                            <?= $this->Html->image($product->image, [
                                'alt' => $product->name,
                            ]) ?>

                        <?php else: ?>

                            <span class="product-placeholder">
                                <?= h(mb_substr($product->name, 0, 1)) ?>
                            </span>

                        <?php endif; ?>

                    </div>

                    <!-- Product Information -->
                    <div class="product-info">

                        <p class="product-category">
                            <?= h($product->category->name ?? 'Uncategorized') ?>
                        </p>

                        <h2>
                            <?= h($product->name) ?>
                        </h2>

                        <p class="product-description">
                            <?= h($product->description ?? '') ?>
                        </p>

                        <div class="product-bottom">

                            <span class="product-price">
                                EGP <?= number_format((float)$product->price, 2) ?>
                            </span>

                            <button type="button" class="add-to-cart-button">
                                Add to cart
                            </button>

                        </div>

                        <?php if ($isAdmin): ?>

                            <div class="product-actions">

                                <?= $this->Html->link(
                                    'Edit Product',
                                    ['action' => 'edit', $product->id],
                                    ['class' => 'edit-product-button']
                                ) ?>

                                <?= $this->Form->postLink(
                                    'Delete Product',
                                    ['action' => 'delete', $product->id],
                                    [
                                        'class' => 'delete-product-button',
                                        'confirm' => 'Are you sure you want to delete this product?'
                                    ]
                                ) ?>

                            </div>

                        <?php endif; ?>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

        <!-- No Products Message -->
        <?php if ($products->count() === 0): ?>

            <p class="no-products">
                No products found.
            </p>

        <?php endif; ?>

        <!-- Pagination -->
        <div class="products-pagination">
            <?= $this->Paginator->prev('Previous') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('Next') ?>
        </div>

    </div>
</section>
