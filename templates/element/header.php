<?php
$currentPath = trim($this->request->getPath(), '/');

$isHome = $currentPath === '';
$isShop = $currentPath === 'products'
    || str_starts_with($currentPath, 'products/')
    || $currentPath === 'customer/products'
    || str_starts_with($currentPath, 'customer/products/')
    || $currentPath === 'admin/products'
    || str_starts_with($currentPath, 'admin/products/');

$isAbout = $currentPath === 'pages/about';
$isContact = $currentPath === 'pages/contact';

$identity = $this->request->getAttribute('identity');
$isAdmin = $identity && $identity->get('role') === 'admin';

$headerCart = $this->request->getSession()->read('Cart', []);
$headerCartCount = array_sum($headerCart);
?>

<div class="header-container">
    <div class="container">
        <header class="site-header">

            <a href="<?= $this->Url->build('/') ?>" class="brand">
                <span class="brand-icon">✚</span>
                <span>Medifit</span>
            </a>

            <button
                class="menu-toggle"
                id="menu-toggle"
                aria-label="Toggle navigation"
                aria-expanded="false"
                aria-controls="main-navigation"
                type="button">
                ☰
            </button>

            <nav class="main-navigation" id="main-navigation">

                <a
                    class="<?= $isHome ? 'nav-link active' : 'nav-link' ?>"
                    href="<?= $this->Url->build('/') ?>">
                    Home
                </a>

                <a
                    class="<?= $isShop ? 'nav-link active' : 'nav-link' ?>"
                    href="<?= $isAdmin
                        ? $this->Url->build(['prefix' => 'Admin', 'controller' => 'Products', 'action' => 'index'])
                        : $this->Url->build(['_name' => 'customerProducts']) ?>">
                    <?= $isAdmin ? 'Dashboard' : 'Shop' ?>
                </a>

                <a
                    class="<?= $isAbout ? 'nav-link active' : 'nav-link' ?>"
                    href="<?= $this->Url->build('/pages/about') ?>">
                    About
                </a>

                <a
                    class="<?= $isContact ? 'nav-link active' : 'nav-link' ?>"
                    href="<?= $this->Url->build('/pages/contact') ?>">
                    Contact
                </a>

            </nav>

            <div class="header-actions">

                <a href="<?= $this->Url->build(['_name' => 'customerProducts']) ?>" class="icon-button">
                    Search
                </a>

                <a href="<?= $this->Url->build(['_name' => 'customerCart']) ?>" class="icon-button cart-icon">
                    Cart

                    <?php if ($headerCartCount > 0): ?>
                        <span class="cart-badge">
                            <?= $headerCartCount ?>
                        </span>
                    <?php endif; ?>
                </a>

                <?php if ($identity): ?>
                    <?= $this->Form->postLink(
                        'Logout',
                        '/users/logout',
                        ['class' => 'icon-button']
                    ) ?>
                <?php endif; ?>

            </div>

        </header>
    </div>
</div>
