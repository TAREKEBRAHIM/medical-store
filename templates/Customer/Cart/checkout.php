<?= $this->Html->css('customer/cart') ?>

<section class="checkout-page">
    <div class="container">

        <header class="checkout-header">
            <p class="section-eyebrow">COMPLETE YOUR ORDER</p>
            <h1>Checkout</h1>
            <p>Enter your delivery details to place your order.</p>
        </header>

        <div class="checkout-layout">

            <div class="checkout-form-wrapper">

                <?= $this->Form->create(null, [
                    'url' => [
                        '_name' => 'customerCheckout',
                    ],
                    'class' => 'checkout-form'
                ]) ?>

                <h2>Delivery Information</h2>

                <div class="form-group">
                    <?= $this->Form->control('customer_name', [
                        'label' => 'Full Name',
                        'placeholder' => 'Enter your full name',
                        'required' => true
                    ]) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->control('phone', [
                        'label' => 'Phone Number',
                        'placeholder' => 'Enter your phone number',
                        'required' => true
                    ]) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->control('city', [
                        'label' => 'City',
                        'placeholder' => 'Enter your city',
                        'required' => true
                    ]) ?>
                </div>

                <div class="form-group">
                    <?= $this->Form->control('address', [
                        'type' => 'textarea',
                        'label' => 'Delivery Address',
                        'placeholder' => 'Enter your full delivery address',
                        'required' => true,
                        'rows' => 4
                    ]) ?>
                </div>

                <div class="payment-method">
                    <h3>Payment Method</h3>

                    <label>
                        <input type="radio" checked disabled>
                        Cash on Delivery
                    </label>

                    <p>Pay when your order arrives.</p>
                </div>

                <button type="submit" class="checkout-button">
                    Confirm Order
                </button>

                <?= $this->Form->end() ?>

            </div>

            <aside class="checkout-summary">

                <h2>Order Summary</h2>

                <?php foreach ($products as $product): ?>
                    <div class="checkout-product">
                        <div>
                            <h4><?= h($product->name) ?></h4>
                            <p>
                                <?= $product->cart_quantity ?> ×
                                EGP <?= number_format((float)$product->price, 2) ?>
                            </p>
                        </div>

                        <strong>
                            EGP <?= number_format((float)$product->subtotal, 2) ?>
                        </strong>
                    </div>
                <?php endforeach; ?>

                <div class="checkout-total">
                    <span>Total</span>
                    <strong>EGP <?= number_format($total, 2) ?></strong>
                </div>

                <a href="<?= $this->Url->build(['_name' => 'customerCart']) ?>" class="continue-shopping">
                    Back to Cart
                </a>

            </aside>

        </div>
    </div>
</section>
