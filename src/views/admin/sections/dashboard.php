<section>
  <div class="container_top">
    <div class="container_left card">
      <div class="card_header">
        <div class="txt">
          <h2>Total Articles</h2><span><?= $totalArticles ?></span>
        </div>

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
    </div>
    <div class="container_right card">
      <div class="card_header">
        <div class="txt">
          <h2>Commandes</h2>
          <h3>Ce mois</h3>
        </div>
        <span>0</span>
      </div>
    </div>
  </div>

  <div class="container_bottom">
    <div class="container_bottom_left card">
      <canvas id="chart-articles"></canvas>
    </div>
    <div class="container_bottom_right card">
      <canvas id="chart-users"></canvas>
    </div>
  </div>
</section>