<section>
  <div class="container_top">
    <div class="container_left card">
      <div class="card_header">
        <div class="txt">
          <h2>Total Articles</h2>
          <h3>En ligne</h3>
        </div>
        <span><?= $totalArticles ?></span>
      </div>
      <div class="img">
        <img src="<?= BASE_URL ?>/img/img-dash/graphique_sales.png" alt="Sales Graph" />
      </div>
    </div>
    <div class="container_middle card">
      <div class="card_header">
        <div class="txt">
          <h2>Utilisateurs</h2>
          <h3>Inscrits</h3>
        </div>
        <span><?= $totalUsers ?></span>
      </div>
      <div class="img">
        <img src="<?= BASE_URL ?>/img/img-dash/customer_graph.png" alt="Customer Graph" />
      </div>
    </div>
    <div class="container_right card">
      <div class="card_header">
        <div class="txt">
          <h2>Commandes</h2>
          <h3>Ce mois</h3>
        </div>
        <span>0</span>
      </div>
      <div class="img">
        <img src="<?= BASE_URL ?>/img/img-dash/order_graph.png" alt="Order Graph" />
      </div>
    </div>
  </div>

  <div class="container_bottom">
    <div class="container_bottom_left card"></div>
    <div class="container_bottom_right card"></div>
  </div>
</section>