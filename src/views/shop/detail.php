<?php partial('header', [
    'title' => $title,
    'description' => $description,
    'image' => $image
]); ?>

<h1>Détail</h1>

<?php dump($article) ?>

<h3>Vendu par : <?= $article['name'] ?></h3>
<p>Prix : <?= $article['price'] ?>€</p>
<p>En stock: <?= $article['quantity'] ?></p>
<img src="<?= BASE_URL . $article['image_path'] ?>" alt="">
<button><a href="">Ajouter au panier</a></button>

<?php partial('footer'); ?>