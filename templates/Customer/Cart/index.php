<?= $this->Html->css('customer/cart') ?>

<section class="cart-page">
    <div class="container">

        <header class="cart-header">
            <div>
                <p class="section-eyebrow">YOUR SHOPPING BAG</p>
                <h1>Shopping Cart</h1>
                <p>Review your selected healthcare products.</p>
            </div>

            <a href="<?= $this->Url->build(['_name' => 'customerProducts']) ?>" class="continue-shopping">
                Continue Shopping
            </a>
        </header>

        <div id="cart-message" class="cart-message" hidden></div>

        <div
            id="cart-content"
            data-products-url="<?= h($this->Url->build(['_name' => 'customerProducts'])) ?>">

            <?php if (count($products) > 0): ?>

                <div class="cart-layout">

                    <div class="cart-items">

                        <?php foreach ($products as $product): ?>

                            <article
                                class="cart-item"
                                data-product-id="<?= h($product->id) ?>">

                                <div class="cart-item-image">
                                    <?php if (!empty($product->image)): ?>
                                        <?= $this->Html->image($product->image, [
                                            'alt' => $product->name
                                        ]) ?>
                                    <?php else: ?>
                                        <span><?= h(mb_substr($product->name, 0, 1)) ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="cart-item-details">

                                    <p class="cart-category">
                                        <?= h($product->category->name ?? 'Healthcare') ?>
                                    </p>

                                    <h2><?= h($product->name) ?></h2>

                                    <p class="cart-unit-price">
                                        EGP <?= number_format((float)$product->price, 2) ?> each
                                    </p>

                                    <div class="cart-item-bottom">

                                        <?= $this->Form->create(null, [
                                            'url' => [
                                                '_name' => 'customerCartUpdate',
                                                'id' => $product->id,
                                            ],
                                            'class' => 'cart-quantity-form',
                                            'data-cart-action' => 'update'
                                        ]) ?>

                                        <?= $this->Form->hidden('quantity', [
                                            'value' => $product->cart_quantity,
                                            'class' => 'quantity-input'
                                        ]) ?>

                                        <div class="quantity-control">
                                            <button type="button" class="quantity-btn decrease-btn">−</button>

                                            <span class="quantity-value">
                                                <?= h($product->cart_quantity) ?>
                                            </span>

                                            <button type="button" class="quantity-btn increase-btn">+</button>
                                        </div>

                                        <?= $this->Form->end() ?>

                                        <?= $this->Form->create(null, [
                                            'url' => [
                                                '_name' => 'customerCartRemove',
                                                'id' => $product->id,
                                            ],
                                            'class' => 'cart-remove-form',
                                            'data-cart-action' => 'remove'
                                        ]) ?>

                                        <button type="submit" class="remove-item">
                                            Remove
                                        </button>

                                        <?= $this->Form->end() ?>

                                    </div>

                                </div>

                                <div class="cart-item-subtotal">
                                    <span>Subtotal</span>
                                    <strong class="item-subtotal">
                                        EGP <?= number_format($product->subtotal, 2) ?>
                                    </strong>
                                </div>

                            </article>

                        <?php endforeach; ?>

                    </div>

                    <aside class="cart-summary">

                        <h2>Order Summary</h2>

                        <div class="summary-row">
                            <span>Items</span>
                            <strong id="cart-count"><?= h($cartCount) ?></strong>
                        </div>

                        <div class="summary-divider"></div>

                        <div class="summary-total">
                            <span>Total</span>
                            <strong id="cart-total">
                                EGP <?= number_format($total, 2) ?>
                            </strong>
                        </div>

                        <p class="summary-note">
                            Shipping and payment details will be calculated at checkout.
                        </p>

                        <a href="<?= $this->Url->build(['_name' => 'customerCheckout']) ?>" class="checkout-button">
                            Proceed to Checkout
                        </a>

                    </aside>

                </div>

            <?php else: ?>

                <div class="empty-cart">
                    <div class="empty-cart-icon">🛒</div>
                    <h2>Your cart is empty</h2>
                    <p>You haven't added any products yet.</p>
                    <a href="<?= $this->Url->build(['_name' => 'customerProducts']) ?>" class="continue-shopping">
                        Explore Products
                    </a>
                </div>

            <?php endif; ?>

        </div>

    </div>
</section>

<?= $this->Html->script('customer/cart', ['defer' => true]) ?>