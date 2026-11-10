<?php
$currentPath = trim($this->request->getPath(), '/');

$isHome = $currentPath === '';
$isShop = $currentPath === 'products'
    || str_starts_with($currentPath, 'products/');
$isAbout = $currentPath === 'pages/about';
$isContact = $currentPath === 'pages/contact';
$identity = $this->request->getAttribute('identity');
?>

<div class="header-container">

    <div class="container">

        <header class="site-header">

            <a href="/" class="brand">
                <span class="brand-icon">✚</span>
                <span>Medifit</span>
            </a>

            <button
                class="menu-toggle"
                id="menu-toggle"
                aria-label="Toggle navigation"
                aria-expanded="false"
                aria-controls="main-navigation"
                type="button"
            >
                ☰
            </button>

            <nav class="main-navigation" id="main-navigation">

                <a
                    class="<?= $isHome ? 'nav-link active' : 'nav-link' ?>"
                    href="/"
                >
                    Home
                </a>

                <a
                    class="<?= $isShop ? 'nav-link active' : 'nav-link' ?>"
                    href="/products"
                >
                    Shop
                </a>

                <a
                    class="<?= $isAbout ? 'nav-link active' : 'nav-link' ?>"
                    href="/pages/about"
                >
                    About
                </a>

                <a
                    class="<?= $isContact ? 'nav-link active' : 'nav-link' ?>"
                    href="/pages/contact"
                >
                    Contact
                </a>

            </nav>

            <div class="header-actions">

                <a href="/products" class="icon-button">
                    Search
                </a>

                <a href="/cart" class="icon-button">
                    Cart
                </a>

                <?php if ($identity): ?>
                    <?= $this->Form->postLink(
                        'Logout',
                        ['controller' => 'Users', 'action' => 'logout'],
                        ['class' => 'icon-button']
                    ) ?>
                <?php endif; ?>

            </div>

        </header>

    </div>

</div>