<footer class="site-footer">
    <div class="footer-grid container">
 
        <div class="footer-brand">
            <a href="index.php" class="nav-logo">
                <span class="logo-bolt">⚡</span>
                <span>Smart<strong>Bike</strong></span>
            </a>
            <p>Pionniers de la mobilité électrique depuis 2019. Conçu en France, pour le monde.</p>
            <div class="footer-social">
                <a href="#" title="Instagram">📸</a>
                <a href="#" title="Facebook">👥</a>
                <a href="#" title="YouTube">▶️</a>
            </div>
        </div>
 
        <div class="footer-col">
            <h4>Navigation</h4>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="catalogue.php">Catalogue</a></li>
                <li><a href="magasins.php">Nos Magasins</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
 
        <div class="footer-col">
            <h4>Catégories</h4>
            <ul>
                <li><a href="catalogue.php?categorie=urban">🏙️ Urban</a></li>
                <li><a href="catalogue.php?categorie=trail">🏔️ Trail</a></li>
                <li><a href="catalogue.php?categorie=cargo">📦 Cargo</a></li>
                <li><a href="catalogue.php?categorie=speed">⚡ Speed</a></li>
            </ul>
        </div>
 
        <div class="footer-col">
            <h4>Contact</h4>
            <ul>
                <li>📍 Paris, Lyon, Bordeaux, Marseille</li>
                <li>📞 01 42 77 88 99</li>
                <li>✉️ hello@smartbike.fr</li>
                <li>🕐 Lun-Sam 9h-19h</li>
            </ul>
        </div>
 
    </div>
 
    <div class="footer-bottom container">
        <p>© <?= date('Y') ?> SmartBike — Projet BTS SIO Portfolio | Tous droits réservés</p>
    </div>
</footer>
 
<script>
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 50);
});
 
const burger = document.getElementById('navBurger');
const mobileMenu = document.getElementById('mobileMenu');
if (burger) {
    burger.addEventListener('click', () => {
        mobileMenu.classList.toggle('open');
        burger.classList.toggle('active');
    });
}
 
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) entry.target.classList.add('visible');
    });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
 
<!-- Leaflet JS via jsDelivr (CDN fiable) — utilisé sur magasins.php -->
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.js"></script>
 
</body>
</html>
