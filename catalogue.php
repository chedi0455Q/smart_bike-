<?php
// ============================================================
// FICHIER : catalogue.php — Catalogue filtrable
// ============================================================
require_once 'db.php';

// -------------------------------------------------------
// FILTRE PAR CATÉGORIE (paramètre GET optionnel)
// -------------------------------------------------------
$categories_valides = ['urban', 'trail', 'cargo', 'speed'];
$filtre = isset($_GET['categorie']) && in_array($_GET['categorie'], $categories_valides)
    ? $_GET['categorie']
    : null;

// -------------------------------------------------------
// TRI (paramètre GET optionnel)
// -------------------------------------------------------
$tris_valides = ['prix_asc', 'prix_desc', 'note_desc', 'autonomie_desc'];
$tri = isset($_GET['tri']) && in_array($_GET['tri'], $tris_valides) ? $_GET['tri'] : 'note_desc';

$order_map = [
    'prix_asc'       => 'prix ASC',
    'prix_desc'      => 'prix DESC',
    'note_desc'      => 'note DESC',
    'autonomie_desc' => 'autonomie DESC',
];
$order_sql = $order_map[$tri];

// -------------------------------------------------------
// REQUÊTE AVEC FILTRE DYNAMIQUE
// -------------------------------------------------------
if ($filtre) {
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE categorie = :cat ORDER BY $order_sql");
    $stmt->execute([':cat' => $filtre]);
} else {
    $stmt = $pdo->query("SELECT * FROM produits ORDER BY $order_sql");
}
$produits = $stmt->fetchAll();

$cat_labels = ['urban'=>'Urban 🏙️','trail'=>'Trail 🏔️','cargo'=>'Cargo 📦','speed'=>'Speed ⚡'];
$page_title = $filtre ? ("Catalogue " . $cat_labels[$filtre]) . " — SmartBike" : "Catalogue — SmartBike";
require_once 'header.php';
?>

<!-- PAGE HEADER -->
<div class="page-hero">
    <div class="container">
        <span class="section-eyebrow">Catalogue</span>
        <h1 class="page-hero-title">
            <?= $filtre ? $cat_labels[$filtre] : 'Tous nos vélos' ?>
        </h1>
        <p><?= count($produits) ?> modèle<?= count($produits) > 1 ? 's' : '' ?> disponible<?= count($produits) > 1 ? 's' : '' ?></p>
    </div>
</div>

<main class="catalogue-page">
    <div class="container">

        <!-- FILTRES & TRI -->
        <div class="filters-bar reveal">

            <!-- Filtres catégorie -->
            <div class="filter-tabs">
                <a href="catalogue.php" class="filter-tab <?= !$filtre ? 'active' : '' ?>">Tous</a>
                <?php foreach ($cat_labels as $key => $label): ?>
                <a href="catalogue.php?categorie=<?= $key ?><?= $tri !== 'note_desc' ? '&tri='.$tri : '' ?>"
                   class="filter-tab <?= $filtre === $key ? 'active' : '' ?>">
                    <?= $label ?>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Sélecteur de tri -->
            <div class="sort-select-wrapper">
                <select class="sort-select" onchange="
                    const url = new URL(window.location);
                    url.searchParams.set('tri', this.value);
                    window.location = url.toString();
                ">
                    <option value="note_desc"      <?= $tri==='note_desc'      ? 'selected':'' ?>>Meilleures notes</option>
                    <option value="prix_asc"       <?= $tri==='prix_asc'       ? 'selected':'' ?>>Prix croissant</option>
                    <option value="prix_desc"      <?= $tri==='prix_desc'      ? 'selected':'' ?>>Prix décroissant</option>
                    <option value="autonomie_desc" <?= $tri==='autonomie_desc' ? 'selected':'' ?>>Autonomie max</option>
                </select>
            </div>
        </div>

        <!-- GRILLE DE PRODUITS -->
        <?php if (empty($produits)): ?>
            <div class="empty-state">
                <p>🔍 Aucun vélo dans cette catégorie.</p>
                <a href="catalogue.php" class="btn btn-gold">Voir tout le catalogue</a>
            </div>
        <?php else: ?>
        <div class="catalogue-grid">
            <?php foreach ($produits as $i => $p): ?>
            <article class="product-card reveal" style="animation-delay: <?= ($i % 3) * 0.1 ?>s">
                <div class="product-card-img">
                    <img src="<?= e($p['image_url']) ?>" alt="<?= e($p['nom']) ?>" loading="lazy">
                    <?= badgeCategorie($p['categorie']) ?>
                    <?php if ($p['stock'] === 0): ?>
                        <span class="badge badge-rupture">Rupture</span>
                    <?php elseif ($p['stock'] <= 3): ?>
                        <span class="badge badge-stock">⚠️ <?= $p['stock'] ?> restants</span>
                    <?php endif; ?>
                </div>
                <div class="product-card-body">
                    <div class="product-card-meta">
                        <?= etoiles($p['note']) ?>
                        <span class="note-text"><?= $p['note'] ?>/5</span>
                    </div>
                    <h3><?= e($p['nom']) ?></h3>
                    <div class="product-specs">
                        <span>🔋 <?= $p['autonomie'] ?> km</span>
                        <span>⚡ <?= $p['puissance'] ?> W</span>
                        <span>⚖️ <?= $p['poids'] ?> kg</span>
                    </div>
                    <div class="product-card-footer">
                        <span class="price"><?= formatPrix($p['prix']) ?></span>
                        <a href="produit.php?id=<?= (int)$p['id'] ?>" class="btn btn-gold btn-sm">Voir →</a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</main>

<?php require_once 'footer.php'; ?>
