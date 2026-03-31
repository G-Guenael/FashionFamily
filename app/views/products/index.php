<section class="best-selling">
    <h1>Tous nos articles</h1>
    <div class="best_selling_container">
        <?php if (!empty($articles)): ?>
            <?php foreach ($articles as $a): ?>
                <div class="best_selling_card">
                    <div class="best_selling_img">
                        <img src="<?= BASE_URL . escape($a['image_path']) ?>" alt="<?= escape($a['title']) ?>" />
                    </div>
                    <p><?= escape($a['title']) ?></p>
                    <div class="stock">
                        <span>En stock : <?= (int) $a['quantity'] ?></span>
                        <span>€<?= number_format((float) $a['price'], 2) ?></span>
                    </div>
                    <a href="<?= BASE_URL ?>/products/show?id=<?= $a['id'] ?>">Voir plus</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun article disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</section>
