<?php

require_once 'db.php';

// Validation de l'ID
if (!isset($_GET['id']) || ($id = (int)$_GET['id']) <= 0) {
    redirect('catalogue.php');
}

// Récupération du produit
$stmt = $pdo->prepare("SELECT * FROM produits WHERE id = :id LIMIT 1");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$p = $stmt->fetch();
if (!$p) redirect('catalogue.php');

// Récupération des avis liés à ce produit
$stmt2 = $pdo->prepare("SELECT * FROM avis WHERE produit_id = :id ORDER BY date_avis DESC");
$stmt2->execute([':id' => $id]);
$avis_list = $stmt2->fetchAll();

// Produits similaires (même catégorie, autre id)
$stmt3 = $pdo->prepare("SELECT * FROM produits WHERE categorie = :cat AND id != :id LIMIT 3");
$stmt3->execute([':cat' => $p['categorie'], ':id' => $id]);
$similaires = $stmt3->fetchAll();

$page_title = e($p['nom']) . ' — SmartBike';
require_once 'header.php';
?>

<!-- FIL D'ARIANE -->
<nav class="breadcrumb">
    <div class="container">
        <a href="index.php">Accueil</a> <span>›</span>
        <a href="catalogue.php">Catalogue</a> <span>›</span>
        <a href="catalogue.php?categorie=<?= e($p['categorie']) ?>"><?= e(ucfirst($p['categorie'])) ?></a> <span>›</span>
        <span><?= e($p['nom']) ?></span>
    </div>
</nav>

<main class="produit-page">
<div class="container">

    <!-- LAYOUT PRINCIPAL : Image | Infos -->
    <div class="produit-layout reveal">

        <!-- Colonne image -->
        <div class="produit-img-col">
            <div class="produit-img-wrapper">
                <img src="<?= e($p['image_url']) ?>" alt="<?= e($p['nom']) ?>" class="produit-main-img">
            </div>
            <!-- Miniatures fictives -->
            <div class="produit-thumbnails">
                <img src="<?= e($p['image_url']) ?>" alt="" class="thumb active">
                <img src="https://images.unsplash.com/photo-1571188654248-7a89213915f7?w=150" alt="" class="thumb">
                <img src="https://images.unsplash.com/photo-1618587259069-a58cf73fe53e?w=150" alt="" class="thumb">
            </div>
        </div>

        <!-- Colonne infos -->
        <div class="produit-info-col">

            <div class="produit-badges">
                <?= badgeCategorie($p['categorie']) ?>
                <?php if ($p['stock'] <= 3 && $p['stock'] > 0): ?>
                <span class="badge badge-stock">⚠️ Plus que <?= $p['stock'] ?> en stock</span>
                <?php elseif ($p['stock'] === 0): ?>
                <span class="badge badge-rupture">Rupture de stock</span>
                <?php else: ?>
                <span class="badge badge-available">✓ En stock</span>
                <?php endif; ?>
            </div>

            <h1 class="produit-title"><?= e($p['nom']) ?></h1>

            <div class="produit-rating">
                <?= etoiles($p['note']) ?>
                <span><?= $p['note'] ?>/5 · <?= count($avis_list) ?> avis</span>
            </div>

            <div class="produit-price"><?= formatPrix($p['prix']) ?></div>

            <!-- Specs techniques -->
            <div class="produit-specs-grid">
                <div class="spec-item">
                    <span class="spec-icon">🔋</span>
                    <div>
                        <span class="spec-label">Autonomie</span>
                        <span class="spec-val"><?= $p['autonomie'] ?> km</span>
                    </div>
                </div>
                <div class="spec-item">
                    <span class="spec-icon">⚡</span>
                    <div>
                        <span class="spec-label">Puissance</span>
                        <span class="spec-val"><?= $p['puissance'] ?> W</span>
                    </div>
                </div>
                <div class="spec-item">
                    <span class="spec-icon">⚖️</span>
                    <div>
                        <span class="spec-label">Poids</span>
                        <span class="spec-val"><?= $p['poids'] ?> kg</span>
                    </div>
                </div>
                <div class="spec-item">
                    <span class="spec-icon">📦</span>
                    <div>
                        <span class="spec-label">Stock</span>
                        <span class="spec-val"><?= $p['stock'] ?> unités</span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="produit-description">
                <p><?= nl2br(e($p['description'])) ?></p>
            </div>

            <!-- Actions -->
            <div class="produit-actions">
                <button class="btn btn-gold btn-large" onclick="alert('Panier — fonctionnalité à développer !')">
                    🛒 Ajouter au panier
                </button>
                <button class="btn btn-ghost" onclick="alert('Essai gratuit en boutique — appelez-nous !')">
                    📞 Essai gratuit
                </button>
            </div>

            <!-- Financement -->
            <div class="produit-finance">
                💳 Ou <strong><?= formatPrix($p['prix'] / 36) ?></strong>/mois en 36× sans frais
            </div>

        </div>
    </div>


    <!-- SECTION AVIS -->
    <section class="avis-section reveal">
        <h2 class="section-title">Avis clients</h2>
        <?php if (empty($avis_list)): ?>
            <p class="empty-msg">Aucun avis pour ce produit.</p>
        <?php else: ?>
        <div class="avis-grid">
            <?php foreach ($avis_list as $a): ?>
            <div class="avis-card">
                <div class="avis-header">
                    <div class="avis-avatar"><?= mb_substr($a['auteur'], 0, 1) ?></div>
                    <div>
                        <strong><?= e($a['auteur']) ?></strong>
                        <span class="avis-date"><?= date('d/m/Y', strtotime($a['date_avis'])) ?></span>
                    </div>
                    <div class="avis-note"><?= etoiles($a['note']) ?></div>
                </div>
                <p><?= e($a['commentaire']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </section>


    <!-- PRODUITS SIMILAIRES -->
    <?php if (!empty($similaires)): ?>
    <section class="similaires-section reveal">
        <h2 class="section-title">Vous aimerez aussi</h2>
        <div class="featured-grid">
            <?php foreach ($similaires as $s): ?>
            <article class="product-card">
                <div class="product-card-img">
                    <img src="<?= e($s['image_url']) ?>" alt="<?= e($s['nom']) ?>" loading="lazy">
                    <?= badgeCategorie($s['categorie']) ?>
                </div>
                <div class="product-card-body">
                    <div class="product-card-meta"><?= etoiles($s['note']) ?></div>
                    <h3><?= e($s['nom']) ?></h3>
                    <div class="product-card-footer">
                        <span class="price"><?= formatPrix($s['prix']) ?></span>
                        <a href="produit.php?id=<?= (int)$s['id'] ?>" class="btn btn-gold btn-sm">Voir →</a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

</div>
</main>

<!-- Thumbnail switcher JS -->
<script>
document.querySelectorAll('.thumb').forEach(thumb => {
    thumb.addEventListener('click', () => {
        document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
        document.querySelector('.produit-main-img').src = thumb.src.replace('w=150', 'w=800');
    });
});
</script>

<?php require_once 'footer.php'; ?>
