<?= $this->Html->css('customer/customer-order-details') ?>

<section class="customer-order-details">

    <div class="details-header">
        <div>
            <span class="details-eyebrow">YOUR ACCOUNT</span>
            <h1>Order Details</h1>
            <p>Track your order and view your purchase details.</p>
        </div>

        <a href="<?= $this->Url->build(['_name' => 'customerOrders']) ?>" class="back-orders-btn">
            Back to My Orders
        </a>
    </div>

    <!-- Order Information -->
    <div class="order-info-card">

        <div>
            <span>Order Number</span>
            <strong>#<?= h($order->id) ?></strong>
        </div>

        <div>
            <span>Order Date</span>
            <strong>
                <?= $order->created
                    ? h($order->created->format('d M Y'))
                    : 'N/A' ?>
            </strong>
        </div>

        <div>
            <span>Total Amount</span>
            <strong>EGP <?= number_format((float)$order->total, 2) ?></strong>
        </div>

        <div>
            <span>Payment Method</span>
            <strong><?= h(ucwords(str_replace('_', ' ', $order->payment_method))) ?></strong>
        </div>

    </div>

    <!-- Order Tracking -->
    <?php
    $statuses = [
        'pending',
        'processing',
        'shipped',
        'delivered'
    ];

    $currentStatus = $order->status;
    $currentIndex = array_search($currentStatus, $statuses, true);
    ?>

    <div class="tracking-card">

        <h2>Order Tracking</h2>

        <?php if ($currentStatus === 'cancelled'): ?>

            <div class="cancelled-message">
                <strong>Order Cancelled</strong>
                <p>This order has been cancelled.</p>
            </div>

        <?php else: ?>

            <div class="tracking-steps">

                <?php foreach ($statuses as $index => $status): ?>

                    <div class="tracking-step
                        <?= ($currentIndex !== false && $index <= $currentIndex) ? 'completed' : '' ?>">

                        <div class="step-circle">
                            <?php if ($currentIndex !== false && $index < $currentIndex): ?>
                                ✓
                            <?php else: ?>
                                <?= $index + 1 ?>
                            <?php endif; ?>
                        </div>

                        <span><?= h(ucfirst($status)) ?></span>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

    <!-- Shipping Information -->
    <div class="shipping-card">

        <h2>Shipping Information</h2>

        <div class="shipping-info">

            <div>
                <span>Customer Name</span>
                <strong><?= h($order->customer_name) ?></strong>
            </div>

            <div>
                <span>Phone Number</span>
                <strong><?= h($order->phone) ?></strong>
            </div>

            <div>
                <span>City</span>
                <strong><?= h($order->city) ?></strong>
            </div>

            <div>
                <span>Address</span>
                <strong><?= h($order->address) ?></strong>
            </div>

        </div>

    </div>

    <!-- Ordered Products -->
    <div class="ordered-products-card">

        <h2>Ordered Products</h2>

        <div class="products-list">

            <?php foreach ($order->order_items as $item): ?>

                <div class="ordered-product">

                    <div class="product-info">
                        <strong><?= h($item->product_name) ?></strong>
                        <span>Quantity: <?= h($item->quantity) ?></span>
                    </div>

                    <div class="product-prices">
                        <span>
                            EGP <?= number_format((float)$item->unit_price, 2) ?>
                            each
                        </span>

                        <strong>
                            EGP <?= number_format((float)$item->subtotal, 2) ?>
                        </strong>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>

        <div class="order-total">
            <span>Order Total</span>
            <strong>EGP <?= number_format((float)$order->total, 2) ?></strong>
        </div>

    </div>

</section>
