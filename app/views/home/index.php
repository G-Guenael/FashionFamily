<section class="hero">
    <div class="hero_container">
        <div class="hero_title">
            <h1>Fresh Arrivals Online</h1>
            <p>Discover Our Newest Collection Today.</p>
            <button>View Collection &rarr;</button>
        </div>
        <div class="hero_image">
            <img src="<?= BASE_URL ?>/img/Hero Image.png" alt="Modèle masculin portant un tshirt de la nouvelle collection" />
            <img src="<?= BASE_URL ?>/img/Burst-pucker.png" alt="" aria-hidden="true" />
        </div>
    </div>
</section>

<section class="feature">
    <div class="feature_container">
        <div class="feature_cart">
            <div class="feature_img">
                <img src="<?= BASE_URL ?>/img/camion.png" aria-hidden="true" alt="">
            </div>
            <h3>Free Shipping</h3>
            <p>Livraison gratuite sur toutes vos commandes.</p>
        </div>
        <div class="feature_cart">
            <div class="feature_img">
                <img src="<?= BASE_URL ?>/img/Badge.png" aria-hidden="true" alt="">
            </div>
            <h3>Qualité garantie</h3>
            <p>Des articles vérifiés par notre équipe.</p>
        </div>
        <div class="feature_cart">
            <div class="feature_img">
                <img src="<?= BASE_URL ?>/img/Bouclier.png" aria-hidden="true" alt="">
            </div>
            <h3>Paiement sécurisé</h3>
            <p>Vos transactions sont protégées.</p>
        </div>
    </div>
</section>

<section class="best-selling">
    <h3>Les derniers articles ajoutés</h3>
    <div class="best_selling_container">
        <?php if (!empty($articlesByDateDesc)): ?>
            <?php foreach ($articlesByDateDesc as $a): ?>
                <div class="best_selling_card">
                    <div class="best_selling_img">
                        <img src="<?= BASE_URL . escape($a['image_path']) ?>" alt="<?= escape($a['title']) ?>" />
                    </div>
                    <p><?= escape($a['title']) ?></p>
                    <p><?= escape($a['description']) ?></p>
                    <div class="stock">
                        <span>En stock : <?= (int) $a['quantity'] ?></span>
                        <span>€<?= number_format((float) $a['price'], 2) ?></span>
                    </div>
                    <button><a href="<?= BASE_URL ?>/products/show?id=<?= $a['id'] ?>">Voir plus</a></button>
                    <button><a href="#">Ajouter au panier</a></button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun article pour le moment. Revenez plus tard !</p>
        <?php endif; ?>
    </div>
</section>

<section class="cta">
    <div class="cta_container">
        <div class="content_left">
            <h3>Browse our Fashion Paradise</h3>
            <p>Step into a world of style and explore our diverse collection of clothing categories.</p>
            <a href="<?= BASE_URL ?>/products">Start Browsing &#8594;</a>
        </div>
        <div class="content_right">
            <img src="<?= BASE_URL ?>/img/Category Image.png" alt="">
        </div>
    </div>
</section>
