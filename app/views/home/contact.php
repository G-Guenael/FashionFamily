<section>
    <?php $msg = getFlashMessage('success'); ?>
    <?php if ($msg): ?>
        <p>
            <?= escape($msg) ?>
        </p>
    <?php endif; ?>
    <h2>Contactez nous</h2>
    <form method="POST" action="<?= BASE_URL ?>/contact">
        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
        <input type="text" name="message" required>
        <button type="submit">Envoyer</button>
    </form>
</section>