<?php

require_once 'db.php';
 
$stmt = $pdo->query("SELECT * FROM magasins ORDER BY id ASC");
$magasins = $stmt->fetchAll();
 
$magasins_json = json_encode($magasins);
 
$page_title = 'Nos Magasins — SmartBike';
require_once 'header.php';
?>
 
<div class="page-hero">
    <div class="container">
        <span class="section-eyebrow">📍 Trouvez-nous</span>
        <h1 class="page-hero-title">Nos boutiques</h1>
        <p><?= count($magasins) ?> points de vente en France — Essayez avant d'acheter</p>
    </div>
</div>
 
<main class="magasins-page">
<div class="container">
 
    <div class="magasins-layout">
 
        <!-- Liste des magasins -->
        <div class="magasins-list">
            <?php foreach ($magasins as $i => $m): ?>
            <div class="magasin-card reveal" style="animation-delay: <?= $i * 0.1 ?>s"
                 id="magasin-<?= $m['id'] ?>"
                 onclick="focusMarker(<?= $m['id'] ?>, <?= $m['lat'] ?>, <?= $m['lng'] ?>)">
 
                <div class="magasin-card-header">
                    <div class="magasin-num"><?= sprintf('%02d', $i+1) ?></div>
                    <div>
                        <h3><?= e($m['nom']) ?></h3>
                        <span class="magasin-ville">📍 <?= e($m['ville']) ?></span>
                    </div>
                </div>
 
                <div class="magasin-details">
                    <p><strong>Adresse :</strong> <?= e($m['adresse']) ?>, <?= e($m['code_postal']) ?> <?= e($m['ville']) ?></p>
                    <p><strong>Téléphone :</strong> <a href="tel:<?= e($m['telephone']) ?>"><?= e($m['telephone']) ?></a></p>
                    <p><strong>Email :</strong> <a href="mailto:<?= e($m['email']) ?>"><?= e($m['email']) ?></a></p>
                    <p><strong>Horaires :</strong> <?= e($m['horaires']) ?></p>
                </div>
 
                <div class="magasin-actions">
                    <button class="btn btn-gold btn-sm"
                            onclick="event.stopPropagation(); focusMarker(<?= $m['id'] ?>, <?= $m['lat'] ?>, <?= $m['lng'] ?>)">
                        🗺️ Voir sur la carte
                    </button>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?= $m['lat'] ?>,<?= $m['lng'] ?>"
                       target="_blank" class="btn btn-ghost btn-sm" onclick="event.stopPropagation()">
                        🧭 Itinéraire
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
 
        <!-- Carte Leaflet -->
        <div class="map-wrapper reveal">
            <div id="map"></div>
            <div class="map-legend">
                <span>🟢 Cliquez sur un marqueur pour les détails</span>
            </div>
        </div>
 
    </div>
</div>
</main>
 
 
<script>
// On attend que toute la page soit chargée (Leaflet JS inclus dans footer)
window.addEventListener('load', function () {
 
    const magasins = <?= $magasins_json ?>;
 
    const map = L.map('map', {
        center: [46.8, 2.3],
        zoom: 6,
        zoomControl: true,
    });
 
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
        maxZoom: 19,
    }).addTo(map);
 
    const bikeIcon = L.divIcon({
        className: 'custom-marker',
        html: `<div class="marker-pin">⚡</div>`,
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -40],
    });
 
    const markers = {};
 
    magasins.forEach(m => {
        const marker = L.marker([parseFloat(m.lat), parseFloat(m.lng)], { icon: bikeIcon })
            .addTo(map)
            .bindPopup(`
                <div class="map-popup">
                    <strong>⚡ ${m.nom}</strong><br>
                    📍 ${m.adresse}, ${m.code_postal} ${m.ville}<br>
                    📞 <a href="tel:${m.telephone}">${m.telephone}</a><br>
                    🕐 ${m.horaires}
                </div>
            `, { maxWidth: 280 });
 
        markers[m.id] = marker;
    });
 
    window.focusMarker = function(id, lat, lng) {
        map.flyTo([lat, lng], 14, { duration: 1.2 });
        setTimeout(() => markers[id].openPopup(), 1200);
        document.querySelectorAll('.magasin-card').forEach(c => c.classList.remove('focused'));
        document.getElementById('magasin-' + id).classList.add('focused');
    };
 
    if (window.innerWidth < 768) {
        map.setZoom(5);
    }
 
});
</script>
 
<?php require_once 'footer.php'; ?>
