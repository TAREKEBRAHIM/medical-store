<?= $this->Html->css('admin/admin-orders') ?>

<section class="order-details-page">

    <div class="order-details-header">
        <div>
            <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="back-link">
                ← Back to Orders
            </a>

            <p class="orders-eyebrow">MEDIFIT ADMIN</p>
            <h1>Order #<?= h($order->id) ?></h1>
            <p>Review customer information and purchased products.</p>
        </div>

        <span class="order-status">
            <?= h(ucfirst($order->status)) ?>
        </span>
    </div>

    <div class="order-info-grid">

        <div class="order-info-card">
            <h3>Customer Information</h3>

            <div class="info-row">
                <span>Customer Name</span>
                <strong><?= h($order->customer_name) ?></strong>
            </div>

            <div class="info-row">
                <span>Email</span>
                <strong><?= h($order->user->email ?? '-') ?></strong>
            </div>

            <div class="info-row">
                <span>Phone</span>
                <strong><?= h($order->phone) ?></strong>
            </div>
        </div>

        <div class="order-info-card">
            <h3>Delivery Information</h3>

            <div class="info-row">
                <span>City</span>
                <strong><?= h($order->city) ?></strong>
            </div>

            <div class="info-row">
                <span>Address</span>
                <strong><?= h($order->address) ?></strong>
            </div>

            <div class="info-row">
                <span>Payment Method</span>
                <strong><?= h(ucwords(str_replace('_', ' ', $order->payment_method))) ?></strong>
            </div>
        </div>

    </div>

    <div class="order-products-card">

        <div class="section-heading">
            <div>
                <p class="orders-eyebrow">ORDER CONTENTS</p>
                <h2>Purchased Products</h2>
            </div>

            <span><?= count($order->order_items) ?> Items</span>
        </div>

        <div class="order-products-table-wrapper">
            <table class="order-products-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($order->order_items as $item): ?>
                        <tr>
                            <td>
                                <strong><?= h($item->product_name) ?></strong>
                            </td>

                            <td><?= h($item->quantity) ?></td>

                            <td>
                                EGP <?= number_format((float)$item->unit_price, 2) ?>
                            </td>

                            <td>
                                EGP <?= number_format((float)$item->subtotal, 2) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="order-total">
            <span>Order Total</span>
            <strong>EGP <?= number_format((float)$order->total, 2) ?></strong>
        </div>

    </div>



    <div class="order-info-card order-status-update">

        <h3>Update Order Status</h3>

        <p>Change the current status of this order.</p>

        <?= $this->Form->create(null, [
            'url' => [
                'action' => 'updateStatus',
                $order->id
            ],
            'type' => 'post'
        ]) ?>

        <div class="form-group">

            <?= $this->Form->control('status', [
                'type' => 'select',
                'label' => 'Order Status',
                'options' => [
                    'pending' => 'Pending',
                    'processing' => 'Processing',
                    'shipped' => 'Shipped',
                    'delivered' => 'Delivered',
                    'cancelled' => 'Cancelled'
                ],
                'value' => $order->status,
                'class' => 'form-select'
            ]) ?>

        </div>

        <?= $this->Form->button('Update Status', [
            'type' => 'submit',
            'class' => 'btn btn-primary'
        ]) ?>

        <?= $this->Form->end() ?>

    </div>


</section>