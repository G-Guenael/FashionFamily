<section class="product-detail" style="padding: 2rem;">
    <a href="<?= BASE_URL ?>/products">&larr; Retour aux articles</a>

    <?php if (!empty($article)): ?>
        <h1><?= escape($article['title']) ?></h1>
        <img src="<?= BASE_URL . escape($article['image_path']) ?>" alt="<?= escape($article['title']) ?>"
            style="max-width: 400px; display: block; margin: 1rem 0;">
        <p><?= escape($article['description']) ?></p>
        <p><strong>Prix :</strong> <?= number_format((float) $article['price'], 2) ?>€</p>
        <p><strong>En stock :</strong> <?= (int) $article['quantity'] ?></p>
        <p><strong>Condition :</strong> <?= escape($article['article_condition']) ?></p>
        <p><strong>Vendu par :</strong> <?= escape($article['seller_name']) ?></p>
        <button><a href="#">Ajouter au panier</a></button>
    <?php endif; ?>
</section>
