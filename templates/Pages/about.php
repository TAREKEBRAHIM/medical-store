<?= $this->Html->css('content-pages') ?>

<section class="about-page">

    <!-- About Hero -->
    <div class="about-hero container">

        <h1>
            Health products you can trust,
            <br>
            service you deserve
        </h1>

        <?= $this->Html->image('products/hero-products.png', [
            'alt' => 'Medifit healthcare products',
            'class' => 'about-hero-image'
        ]) ?>

    </div>

    <!-- About Us -->
    <section class="about-content container">

        <h2>About us</h2>

        <p>
            Our focus is on elevating wellness and empowering health
            for all ages, providing quality care and reliable healthcare
            products for everyday needs.
        </p>

    </section>

    <!-- Statistics -->
    <section class="about-stats container">

        <div>
            <h3>15+</h3>
            <p>Years of experience</p>
        </div>

        <div>
            <h3>100+</h3>
            <p>Products</p>
        </div>

        <div>
            <h3>500+</h3>
            <p>Happy customers</p>
        </div>

        <div>
            <h3>24/7</h3>
            <p>Customer support</p>
        </div>

    </section>

    <!-- Mission -->
    <section class="about-mission">

        <div class="container mission-inner">

            <div>
                <p class="section-eyebrow">OUR PURPOSE</p>

                <h2>What to Expect When You Join Our Journey</h2>

                <div class="mission-values">
                    <p><strong>Our Mission</strong> – Making healthcare essentials accessible.</p>
                    <p><strong>Our Commitment</strong> – Quality and customer satisfaction.</p>
                    <p><strong>Our Vision</strong> – A healthier community for everyone.</p>
                </div>
            </div>

            <?= $this->Html->image('products/hero-products.png', [
                'alt' => 'Our healthcare products',
                'class' => 'mission-image'
            ]) ?>

        </div>

    </section>

    <!-- Final Section -->
    <section class="about-cta container">

        <div>
            <h2>Join our Medifit product community</h2>

            <p>
                Discover healthcare essentials selected to support
                your everyday wellness.
            </p>

            <a href="/products">Explore Products</a>
        </div>

        <?= $this->Html->image('products/hero-products.png', [
            'alt' => 'Medifit product collection'
        ]) ?>

    </section>

</section>