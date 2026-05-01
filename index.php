<?php
require_once 'db.php';
$page_title = 'SmartBike — Vélos Électriques Premium';
 
// Produits vedettes : Urban Glide X1 (id=1), Trail Blazer (id=2), Speed Demon S45 (id=5)
$stmt = $pdo->query("SELECT * FROM produits WHERE id IN (1, 2, 5) ORDER BY note DESC");
$featured = $stmt->fetchAll();
 
// Statistiques dynamiques pour la section chiffres
$stats = $pdo->query("SELECT COUNT(*) as nb_produits, AVG(note) as note_moy FROM produits")->fetch();
require_once 'header.php';
?>
 
<section class="hero-section">
    <div class="hero-bg">
        <div class="hero-particles">
            <?php for($i=0; $i<20; $i++): ?>
            <div class="particle" style="--delay: <?= rand(0,50)/10 ?>s; --x: <?= rand(0,100) ?>%; --size: <?= rand(2,6) ?>px;"></div>
            <?php endfor; ?>
        </div>
    </div>
 
    <div class="container hero-content">
        <div class="hero-text reveal">
            <span class="hero-eyebrow">✦ Mobilité du futur</span>
            <h1 class="hero-title">
                Roulez<br>
                <em>plus vite.</em><br>
                Plus loin.
            </h1>
            <p class="hero-subtitle">
                Des vélos électriques d'exception, conçus pour les exigeants.
                Technologie allemande, âme française.
            </p>
            <div class="hero-cta">
                <a href="catalogue.php" class="btn btn-gold">Découvrir le catalogue</a>
                <a href="magasins.php"  class="btn btn-ghost">Nos magasins →</a>
            </div>
        </div>
 
        <!-- Carte produit flottante — Speed Demon S45 -->
        <div class="hero-card reveal" style="animation-delay:.2s">
            <div class="floating-card">
                <img src="https://images.unsplash.com/photo-1571188654248-7a89213915f7?w=800" alt="Speed Demon S45">
                <div class="floating-card-info">
                    <span class="floating-badge">⚡ Nouveau</span>
                    <h3>Speed Demon S45</h3>
                    <p>45 km/h · 120 km</p>
                    <strong>4 299 €</strong>
                </div>
            </div>
        </div>
    </div>
 
    <div class="scroll-indicator">
        <div class="scroll-dot"></div>
    </div>
</section>
 
<section class="stats-section">
    <div class="container stats-grid">
        <div class="stat-item reveal">
            <span class="stat-number" data-target="<?= $stats['nb_produits'] ?>">0</span>
            <span class="stat-label">Modèles exclusifs</span>
        </div>
        <div class="stat-item reveal" style="animation-delay:.1s">
            <span class="stat-number" data-target="4">0</span>
            <span class="stat-label">Boutiques en France</span>
        </div>
        <div class="stat-item reveal" style="animation-delay:.2s">
            <span class="stat-number" data-target="180">0</span>
            <span class="stat-label">km d'autonomie max</span>
        </div>
        <div class="stat-item reveal" style="animation-delay:.3s">
            <span class="stat-number" data-target="98">0</span>
            <span class="stat-label">% clients satisfaits</span>
        </div>
    </div>
</section>
 
 
<section class="categories-section">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-eyebrow">Notre gamme</span>
            <h2 class="section-title">Un vélo pour chaque aventure</h2>
        </div>
 
        <div class="categories-grid">
            <a href="catalogue.php?categorie=urban" class="cat-card reveal" style="--cat-color:#00e5a0">
                <div class="cat-icon">🏙️</div>
                <h3>Urban</h3>
                <p>Dominez la ville</p>
                <span class="cat-arrow">→</span>
            </a>
            <a href="catalogue.php?categorie=trail" class="cat-card reveal" style="--cat-color:#ff6b35; animation-delay:.1s">
                <div class="cat-icon">🏔️</div>
                <h3>Trail</h3>
                <p>Conquérez les sommets</p>
                <span class="cat-arrow">→</span>
            </a>
            <a href="catalogue.php?categorie=cargo" class="cat-card reveal" style="--cat-color:#c4a35a; animation-delay:.2s">
                <div class="cat-icon">📦</div>
                <h3>Cargo</h3>
                <p>Transportez tout</p>
                <span class="cat-arrow">→</span>
            </a>
            <a href="catalogue.php?categorie=speed" class="cat-card reveal" style="--cat-color:#e040fb; animation-delay:.3s">
                <div class="cat-icon">⚡</div>
                <h3>Speed</h3>
                <p>Repoussez les limites</p>
                <span class="cat-arrow">→</span>
            </a>
        </div>
    </div>
</section>
 
<section class="featured-section">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-eyebrow">Sélection</span>
            <h2 class="section-title">Nos meilleures ventes</h2>
        </div>
 
        <div class="featured-grid">
            <?php foreach ($featured as $i => $p): ?>
            <article class="product-card reveal" style="animation-delay: <?= $i * 0.15 ?>s">
                <div class="product-card-img">
                    <img src="<?= e($p['image_url']) ?>" alt="<?= e($p['nom']) ?>" loading="lazy">
                    <?= badgeCategorie($p['categorie']) ?>
                    <?php if ($p['stock'] <= 3): ?>
                    <span class="badge badge-stock">⚠️ <?= $p['stock'] ?> en stock</span>
                    <?php endif; ?>
                </div>
                <div class="product-card-body">
                    <div class="product-card-meta">
                        <?= etoiles($p['note']) ?>
                        <span class="note-text"><?= $p['note'] ?>/5</span>
                    </div>
                    <h3><?= e($p['nom']) ?></h3>
                    <div class="product-specs">
                        <span title="Autonomie">🔋 <?= $p['autonomie'] ?> km</span>
                        <span title="Puissance">⚡ <?= $p['puissance'] ?> W</span>
                        <span title="Poids">⚖️ <?= $p['poids'] ?> kg</span>
                    </div>
                    <div class="product-card-footer">
                        <span class="price"><?= formatPrix($p['prix']) ?></span>
                        <a href="produit.php?id=<?= (int)$p['id'] ?>" class="btn btn-gold btn-sm">Voir →</a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
 
        <div class="text-center reveal">
            <a href="catalogue.php" class="btn btn-outline-gold">Voir tous les vélos (<?= $stats['nb_produits'] ?>)</a>
        </div>
    </div>
</section>

<section class="usp-section">
    <div class="container usp-grid">
        <div class="usp-item reveal">
            <span class="usp-icon">🚚</span>
            <div>
                <h4>Livraison offerte</h4>
                <p>Assemblage et livraison inclus dès 1 500 €</p>
            </div>
        </div>
        <div class="usp-item reveal" style="animation-delay:.1s">
            <span class="usp-icon">🛡️</span>
            <div>
                <h4>Garantie 3 ans</h4>
                <p>Cadre, moteur et batterie couverts</p>
            </div>
        </div>
        <div class="usp-item reveal" style="animation-delay:.2s">
            <span class="usp-icon">🔧</span>
            <div>
                <h4>SAV en boutique</h4>
                <p>Techniciens certifiés dans 4 villes</p>
            </div>
        </div>
        <div class="usp-item reveal" style="animation-delay:.3s">
            <span class="usp-icon">💳</span>
            <div>
                <h4>Financement 0%</h4>
                <p>Jusqu'à 36 mois sans frais</p>
            </div>
        </div>
    </div>
</section>
 
<script>
document.querySelectorAll('.stat-number').forEach(el => {
    const target = parseInt(el.dataset.target);
    const observer = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
            let count = 0;
            const step = Math.ceil(target / 60);
            const timer = setInterval(() => {
                count = Math.min(count + step, target);
                el.textContent = count;
                if (count >= target) clearInterval(timer);
            }, 20);
            observer.disconnect();
        }
    });
    observer.observe(el);
});
</script>
 
<?php require_once 'footer.php'; ?>
