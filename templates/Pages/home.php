<?= $this->Html->css('home') ?>
<?= $this->Html->css('home-sections') ?>
<?= $this->Html->script('home', ['defer' => true]) ?>
<?= $this->Html->script('home-sections', ['defer' => true]) ?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-decoration decoration-left" aria-hidden="true">
        ♧
    </div>

    <div class="hero-decoration decoration-top" aria-hidden="true">
        ♧
    </div>

    <div class="hero-content">
        <p class="hero-eyebrow">YOUR WELLNESS, OUR PRIORITY</p>

        <h1>
            Your trusted<br>
            care now<br>
            and always
        </h1>

        <p class="hero-description">
            For the best results, align your health needs
            with your medication plan.
        </p>

        <a href="/products" class="shop-button">
            <span aria-hidden="true">♧</span>
            Shop now
        </a>
    </div>

    <div class="hero-visual">
        <div class="hero-circle"></div>

        <?= $this->Html->image(
            'products/hero-products.png',
            [
                'alt' => 'Medifit healthcare products',
                'class' => 'hero-product-image'
            ]
        ) ?>
    </div>

    <div class="medical-decoration" aria-hidden="true">
        <svg viewBox="0 0 100 100">
            <path d="M24 15 40 10 48 30 32 36Z"></path>
            <path d="M38 22 51 18 58 38 45 43Z"></path>
            <path d="M42 28 54 32"></path>
            <path d="M28 24 42 20"></path>
        </svg>
    </div>
</section>

<!-- Categories Section -->
<section class="home-section categories-section" aria-labelledby="categories-heading">

    <div class="container home-container">

        <header class="section-heading">
            <p class="section-eyebrow">FIND WHAT YOU NEED</p>
            <h2 id="categories-heading">Shop by category</h2>
            <p>Everyday essentials for a healthier you.</p>
        </header>

        <div class="category-grid">

            <?php foreach ($categories as $category): ?>

                <a
                    class="category-card"
                    href="/products?category_id=<?= h($category->id) ?>"
                >

                    <span class="category-icon" aria-hidden="true">

                        <?php if (!empty($category->image)): ?>

                            <?= $this->Html->image($category->image, [
                                'alt' => '',
                            ]) ?>

                        <?php else: ?>

                            <span>✚</span>

                        <?php endif; ?>

                    </span>

                    <span class="category-name">
                        <?= h($category->name) ?>
                    </span>

                    <span class="category-link">
                        Explore <span aria-hidden="true">→</span>
                    </span>

                </a>

            <?php endforeach; ?>

        </div>

    </div>

</section>

<!-- Featured Products Section -->
<section class="home-section featured-section" aria-labelledby="featured-heading">

    <div class="container home-container">

        <header class="section-heading">
            <p class="section-eyebrow">CAREFULLY CHOSEN FOR YOU</p>
            <h2 id="featured-heading">Latest health products</h2>
            <p>Trusted essentials to support your everyday wellbeing.</p>
        </header>

        <div class="product-grid">

            <?php foreach ($products as $product): ?>

                <article class="home-product-card">

                    <!-- Product Image -->
                    <div class="product-visual">

                        <?php if (!empty($product->image)): ?>

                            <?= $this->Html->image($product->image, [
                                'alt' => $product->name,
                                'class' => 'product-art'
                            ]) ?>

                        <?php else: ?>

                            <span class="product-placeholder" aria-hidden="true">
                                <?= h(mb_substr($product->name, 0, 1)) ?>
                            </span>

                        <?php endif; ?>

                    </div>

                    <!-- Product Information -->
                    <div class="product-copy">

                        <div class="product-title-row">
                            <h3>
                                <?= h($product->name) ?>
                            </h3>
                        </div>

                        <p class="product-description">
                            <?= h($product->description ?? '') ?>
                        </p>

                        <div class="product-buy-row">

                            <span class="product-price">
                                EGP <?= number_format((float)$product->price, 2) ?>
                            </span>

                            <button
                                class="add-to-cart-button"
                                type="button"
                                data-product="<?= h($product->name) ?>"
                            >
                                Add to cart
                            </button>

                        </div>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

        <p class="cart-feedback" role="status" aria-live="polite"></p>

        <div class="section-action">

            <a class="text-link" href="/products">
                Explore all products <span aria-hidden="true">→</span>
            </a>

        </div>

    </div>

</section>

<!-- Promotional Section -->
<section class="home-promotion" aria-labelledby="promotion-heading">

    <div class="container home-container promotion-inner">

        <div class="promotion-copy">

            <p class="section-eyebrow">A LITTLE SOMETHING FOR YOU</p>

            <h2 id="promotion-heading">
                Feel good about<br>
                your everyday care.
            </h2>

            <p>
                Discover thoughtfully selected health essentials
                and enjoy 15% off your first order.
            </p>

            <a class="promotion-button" href="/products">
                Shop the collection <span aria-hidden="true">→</span>
            </a>

            <span class="promotion-note">
                Use code <strong>WELCOME15</strong> at checkout
            </span>

        </div>

        <div class="promotion-art" aria-hidden="true">

            <span class="promotion-sun"></span>
            <span class="promotion-leaf promotion-leaf-one"></span>
            <span class="promotion-leaf promotion-leaf-two"></span>

            <svg viewBox="0 0 280 250" fill="none">

                <ellipse cx="142" cy="219" rx="112" ry="15" fill="#bba98e" opacity=".32"/>

                <rect x="48" y="108" width="55" height="100" rx="11" fill="#e5d6bd"/>

                <rect x="57" y="92" width="37" height="21" rx="5" fill="#8d765b"/>

                <path d="M62 145h27v43H62z" fill="#f3eee4"/>

                <path d="M75 151v29m-8-14h16" stroke="#93aa95" stroke-width="4" stroke-linecap="round"/>

                <rect x="121" y="75" width="72" height="133" rx="14" fill="#f8f5ed"/>

                <rect x="133" y="57" width="48" height="24" rx="6" fill="#c6a889"/>

                <path d="M134 117h46v64h-46z" fill="#e7d8bd"/>

                <path d="M157 128c-17 18-14 30 0 34 14-4 17-16 0-34Z" fill="#8eaa96"/>

                <rect x="210" y="126" width="34" height="82" rx="9" fill="#d5e0d8"/>

                <rect x="216" y="113" width="22" height="16" rx="4" fill="#8d765b"/>

                <path d="M220 153h14v31h-14z" fill="#f3eee4"/>

            </svg>

            <span class="promotion-sparkle promotion-sparkle-one" aria-hidden="true">✦</span>

            <span class="promotion-sparkle promotion-sparkle-two" aria-hidden="true">✦</span>

        </div>

    </div>

</section>

<!-- Benefits Section -->
<section class="home-section benefits-section" aria-labelledby="benefits-heading">

    <div class="container home-container">

        <header class="section-heading">
            <p class="section-eyebrow">HERE FOR YOUR HEALTH</p>
            <h2 id="benefits-heading">Care you can count on</h2>
            <p>Making it easier to look after yourself and the people you love.</p>
        </header>

        <div class="benefit-grid">

            <article class="benefit-card">

                <span class="benefit-icon" aria-hidden="true">

                    <svg viewBox="0 0 48 48" fill="none">
                        <path d="M24 40s-15-9-15-21a8 8 0 0 1 15-4 8 8 0 0 1 15 4c0 12-15 21-15 21Z"/>
                        <path d="M17 23h5l3-5 4 10 3-5h3"/>
                    </svg>

                </span>

                <h3>Quality you trust</h3>

                <p>Carefully selected products from brands you can feel confident in.</p>

            </article>

            <article class="benefit-card">

                <span class="benefit-icon" aria-hidden="true">

                    <svg viewBox="0 0 48 48" fill="none">
                        <path d="M8 16h20v19H8z"/>
                        <path d="M28 22h7l6 7v6H28z"/>
                        <circle cx="16" cy="37" r="4"/>
                        <circle cx="34" cy="37" r="4"/>
                        <path d="M13 22h10m-5-5v10"/>
                    </svg>

                </span>

                <h3>Fast, friendly delivery</h3>

                <p>Get your everyday essentials delivered right to your door.</p>

            </article>

            <article class="benefit-card">

                <span class="benefit-icon" aria-hidden="true">

                    <svg viewBox="0 0 48 48" fill="none">
                        <path d="M24 8 38 14v10c0 9-6 14-14 18-8-4-14-9-14-18V14l14-6Z"/>
                        <path d="m17 24 5 5 10-11"/>
                    </svg>

                </span>

                <h3>Secure shopping</h3>

                <p>Your peace of mind matters at every step of your shopping experience.</p>

            </article>

            <article class="benefit-card">

                <span class="benefit-icon" aria-hidden="true">

                    <svg viewBox="0 0 48 48" fill="none">
                        <path d="M9 12h30v22H22l-9 7v-7H9z"/>
                        <path d="M17 20h14m-14 7h9"/>
                    </svg>

                </span>

                <h3>Here to help</h3>

                <p>Our caring team is ready to help you find what you need.</p>

            </article>

        </div>

    </div>

</section>

<!-- Newsletter Section -->
<section class="newsletter-section" aria-labelledby="newsletter-heading">

    <div class="container home-container newsletter-inner">

        <div class="newsletter-copy">

            <p class="section-eyebrow">GOOD THINGS, OCCASIONALLY</p>

            <h2 id="newsletter-heading">
                A little more wellness in your inbox.
            </h2>

            <p>
                Sign up for health tips, new arrivals, and a welcome treat
                on your first order.
            </p>

        </div>

        <form class="newsletter-form" novalidate>

            <label for="newsletter-email">Your email address</label>

            <div class="newsletter-controls">

                <input
                    id="newsletter-email"
                    name="email"
                    type="email"
                    placeholder="you@example.com"
                    autocomplete="email"
                    required
                >

                <button type="submit">
                    Subscribe <span aria-hidden="true">→</span>
                </button>

            </div>

            <p class="newsletter-feedback" role="status" aria-live="polite"></p>

            <p class="newsletter-privacy">
                No spam, just the good stuff. Unsubscribe anytime.
            </p>

        </form>

    </div>

</section>