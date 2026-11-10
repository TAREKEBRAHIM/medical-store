<?php $this->assign('title', 'Edit Product | Medifit Store'); ?>

<?= $this->Html->css('add-product') ?>

<section class="add-product-page">

    <div class="container">

        <div class="add-product-header">
            <p class="section-eyebrow">PRODUCT MANAGEMENT</p>
            <h1>Edit Product</h1>
            <p>Update the information of this product.</p>
        </div>

        <div class="add-product-card">

            <?= $this->Form->create($product, [
                'class' => 'add-product-form'
            ]) ?>

                <?= $this->Form->control('name', [
                    'label' => 'Product Name',
                    'placeholder' => 'Enter product name',
                    'required' => true
                ]) ?>

                <?= $this->Form->control('slug', [
                    'label' => 'Product Slug',
                    'placeholder' => 'example-product',
                    'required' => true
                ]) ?>

                <?= $this->Form->control('category_id', [
                    'type' => 'select',
                    'options' => $categories,
                    'empty' => 'Select a category',
                    'label' => 'Category'
                ]) ?>

                <?= $this->Form->control('description', [
                    'type' => 'textarea',
                    'label' => 'Product Description',
                    'rows' => 5
                ]) ?>

                <?= $this->Form->control('price', [
                    'type' => 'number',
                    'label' => 'Price (EGP)',
                    'step' => '0.01',
                    'min' => '0',
                    'required' => true
                ]) ?>

                <?= $this->Form->control('stock', [
                    'type' => 'number',
                    'label' => 'Stock Quantity',
                    'min' => '0'
                ]) ?>

                <?= $this->Form->control('image', [
                    'label' => 'Product Image Path'
                ]) ?>

                <div class="add-product-actions">

                    <?= $this->Form->button('Update Product', [
                        'class' => 'save-product-button'
                    ]) ?>

                    <?= $this->Html->link('Cancel', '/products', [
                        'class' => 'cancel-product-button'
                    ]) ?>

                </div>

            <?= $this->Form->end() ?>

        </div>

    </div>

</section>