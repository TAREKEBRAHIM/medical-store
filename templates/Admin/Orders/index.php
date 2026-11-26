<?= $this->Html->css('admin/admin-orders') ?>

<section class="orders-page">

    <div class="orders-header">
        <div>
            <p class="orders-eyebrow">MEDIFIT ADMIN</p>
            <h1>Customer Orders</h1>
            <p>Manage and track all customer orders.</p>
        </div>
    </div>

    <div class="orders-table-wrapper">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($orders->isEmpty()): ?>
                    <tr>
                        <td colspan="6" class="empty-orders">
                            No orders found.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>
                                <?= $this->Html->link(
                                    '#' . $order->id,
                                    ['action' => 'view', $order->id],
                                    ['class' => 'order-id-link']
                                ) ?>
                            </td>
                            <td>
                                <?= h($order->customer_name) ?>
                            </td>
                            <td><?= h($order->phone) ?></td>
                            <td>
                                EGP <?= number_format((float)$order->total, 2) ?>
                            </td>
                            <td>
                                <span class="order-status">
                                    <?= h(ucfirst($order->status)) ?>
                                </span>
                            </td>
                            <td>
                                <?= $order->created
                                    ? h($order->created->format('d M Y'))
                                    : '-' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</section>