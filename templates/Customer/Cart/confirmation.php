<?= $this->Html->css('customer/order-confirmation') ?>

<section class="order-confirmation-page">
    <div class="confirmation-container">

        <div class="confirmation-success">
            <div class="success-icon">✓</div>
            <p class="success-eyebrow">ORDER CONFIRMED</p>
            <h1>Thank You for Your Order!</h1>
            <p>
                Your order has been placed successfully.
                We will process it as soon as possible.
            </p>
            <span class="order-number">
                Order #<?= h($order->id) ?>
            </span>
        </div>

        <div class="confirmation-details">

            <div class="details-heading">
                <h2>Order Details</h2>
                <span class="order-status">
                    <?= h(ucfirst($order->status)) ?>
                </span>
            </div>

            <div class="order-info">
                <div>
                    <span>Order Date</span>
                    <strong>
                        <?= $order->created
                            ? h($order->created->format('d M Y'))
                            : 'Not available' ?>
                    </strong>
                </div>

                <div>
                    <span>Payment Method</span>
                    <strong>Cash on Delivery</strong>
                </div>

                <div>
                    <span>Order Total</span>
                    <strong>
                        EGP <?= number_format((float)$order->total, 2) ?>
                    </strong>
                </div>
            </div>

            <div class="confirmation-section">
                <h3>Ordered Products</h3>

                <?php foreach ($order->order_items as $item): ?>
                    <div class="confirmation-product">
                        <div>
                            <h4><?= h($item->product_name) ?></h4>
                            <p>
                                Quantity: <?= h($item->quantity) ?>
                            </p>
                        </div>

                        <strong>
                            EGP <?= number_format((float)$item->subtotal, 2) ?>
                        </strong>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="confirmation-section">
                <h3>Delivery Information</h3>

                <div class="delivery-info">
                    <p>
                        <strong>Name:</strong>
                        <?= h($order->customer_name) ?>
                    </p>

                    <p>
                        <strong>Phone:</strong>
                        <?= h($order->phone) ?>
                    </p>

                    <p>
                        <strong>City:</strong>
                        <?= h($order->city) ?>
                    </p>

                    <p>
                        <strong>Address:</strong>
                        <?= h($order->address) ?>
                    </p>
                </div>
            </div>

            <div class="confirmation-actions">
                <a href="<?= $this->Url->build(['_name' => 'customerProducts']) ?>" class="back-to-shop">
                    Continue Shopping
                </a>
            </div>

        </div>
    </div>
</section>
