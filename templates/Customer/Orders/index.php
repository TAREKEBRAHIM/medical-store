<?= $this->Html->css('customer/customer-orders') ?>

<section class="customer-orders-page">

    <div class="orders-header">
        <div>
            <span class="orders-eyebrow">YOUR ACCOUNT</span>
            <h1>My Orders</h1>
            <p>Track and manage your recent purchases.</p>
        </div>
    </div>

    <?php if ($orders->isEmpty()): ?>

        <div class="empty-orders">
            <h2>No orders yet</h2>
            <p>You haven't placed any orders yet.</p>
            <a href="<?= $this->Url->build(['_name' => 'customerProducts']) ?>" class="shop-btn">Start Shopping</a>
        </div>

    <?php else: ?>

        <div class="orders-list">

            <?php foreach ($orders as $order): ?>

                <article class="order-card">

                    <div class="order-card-header">
                        <div>
                            <span class="order-label">ORDER NUMBER</span>
                            <h3>#<?= h($order->id) ?></h3>
                        </div>

                        <span class="order-status status-<?= h($order->status) ?>">
                            <?= h(ucfirst($order->status)) ?>
                        </span>
                    </div>

                    <div class="order-card-info">

                        <div>
                            <span>Order Date</span>
                            <strong>
                                <?= $order->created
                                    ? h($order->created->format('d M Y'))
                                    : 'N/A' ?> </strong>
                        </div>

                        <div>
                            <span>Total Amount</span>
                            <strong>
                                EGP <?= number_format((float)$order->total, 2) ?>
                            </strong>
                        </div>

                    </div>

                    <div class="order-card-footer">

                        <a href="<?= $this->Url->build([
                                        '_name' => 'customerOrderView',
                                        'id' => $order->id,
                                    ]) ?>" class="details-btn">
                            View Details
                        </a>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</section>