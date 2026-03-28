<?php partial('header', ['title' => $title, 'description' => $description]); ?>

<section class="hero">
    <div class="hero_container">
        <div class="hero_title">
            <h1>Fresh Arrivals Online</h1>
            <p>Discover Our Newest Collection Today.</p>
            <button>View Collection &rarr;</button>
        </div>
        <div class="hero_image">
            <img src="./img/Hero Image.png" alt="Modèle masculin portant un tshirt de la nouvelle collection" />
            <img src="./img/Burst-pucker.png" alt="" aria-hidden="true" />
        </div>
    </div>
</section>

<section class="feature">
    <div class="feature_container">
        <div class="feature_cart">
            <div class="feature_img">
                <img src="./img/camion.png" aria-hidden="true" alt="">
            </div>
            <h3>Free Shipping</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum cum quis impedit sed unde.</p>
        </div>
        <div class="feature_cart">
            <div class="feature_img">
                <img src="./img/Badge.png" aria-hidden="true" alt="">
            </div>
            <h3>Free Shipping</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum cum quis impedit sed unde.</p>
        </div>
        <div class="feature_cart">
            <div class="feature_img">
                <img src="./img/Bouclier.png" aria-hidden="true" alt="">
            </div>
            <h3>Free Shipping</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum cum quis impedit sed unde.</p>
        </div>
    </div>
</section>

<section class="best-selling">
    <h3>Best Selling</h3>
    <div class="best_selling_container">
        <!-- Génération des articles avec une boucle PHP -->
        <?php foreach ($articles as $a): ?>
            <div class="best_selling_card">
                <div class="best_selling_img">
                    <img src="<?= $a['image_path'] ?>" alt="Tshirt le mieux vendu" />
                </div>
                <p><?= $a['title'] ?></p>
                <p><?= $a['description'] ?></p>
                <div class="stock">
                    <span>En stock : <?= $a['quantity'] ?></span>
                    <span>€<?= $a['price'] ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="cta">
    <div class="cta_container">
        <div class="content_left">
            <h3>Browse our Fashion Paradise</h3>
            <p>Step into a world of style and explore our diverse collection of clothing categories.</p>
            <a href="#">Start Browsing &#8594</a>
        </div>
        <div class="content_right">
            <img src="./img/Category Image.png" alt="">
        </div>
    </div>
</section>

<section class="produit_list">

    <div class="produit_container">
        <div class="produit_card">
            <div class="produit_list_img">
                <img src="./img/pull1.png" alt="Tshirt le mieux vendu" />
            </div>
            <p>Classic Monochrome Tees</p>
            <div class="stock">
                <span>En stock</span>
                <span>€35.00</span>
            </div>
        </div>
        <div class="best_selling_card">
            <div class="best_selling_img">
                <img src="./img/pull2.png" alt="Tshirt le mieux vendu" />
            </div>
            <p> Monochromatic Wardrobe</p>
            <div class="stock">
                <span>En stock</span>
                <span>€27.00</span>
            </div>
        </div>
        <div class="best_selling_card">
            <div class="best_selling_img">
                <img src="./img/tshirt5.png" alt="Tshirt le mieux vendu" />
            </div>
            <p>Essential Neutrals</p>
            <div class="stock">
                <span>En stock</span>
                <span>€22.00</span>
            </div>
        </div>
        <div class="best_selling_card">
            <div class="best_selling_img">
                <img src="./img/tshirt6.png" alt="Tshirt le mieux vendu" />
            </div>
            <p>UTRAANET Black</p>
            <div class="stock">
                <span>En stock</span>
                <span>€43.00</span>
            </div>
        </div>
    </div>
</section>

<?php partial('footer'); ?>