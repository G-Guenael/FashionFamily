<?php $successMsg = getFlashMessage('success'); ?>
<?php if ($successMsg): ?>
    <p style="color: green; text-align: center; padding: 0.5rem;"><?= escape($successMsg) ?></p>
<?php endif; ?>
<?php $errorMsg = getFlashMessage('error'); ?>
<?php if ($errorMsg): ?>
    <p style="color: red; text-align: center; padding: 0.5rem;"><?= escape($errorMsg) ?></p>
<?php endif; ?>

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

        <?php if ((int) $article['quantity'] > 0): ?>
            <form action="<?= BASE_URL ?>/cart/add" method="POST" style="margin-top: 1rem; display: flex; align-items: center; gap: 0.75rem;">
                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                <input type="hidden" name="article_id" value="<?= (int) $article['id'] ?>">
                <input type="hidden" name="redirect" value="/products/show?id=<?= (int) $article['id'] ?>">
                <label for="quantity">Quantité :</label>
                <input type="number" id="quantity" name="quantity"
                       value="1" min="1" max="<?= (int) $article['quantity'] ?>"
                       style="width: 60px; padding: 0.4rem; text-align: center;">
                <button type="submit" style="padding: 0.5rem 1.25rem; cursor: pointer;">
                    Ajouter au panier
                </button>
            </form>
        <?php else: ?>
            <p style="color: red; margin-top: 1rem;"><strong>Rupture de stock</strong></p>
        <?php endif; ?>

        <p style="margin-top: 0.75rem;">
            <a href="<?= BASE_URL ?>/cart">Voir mon panier</a>
        </p>
    <?php endif; ?>
</section>
