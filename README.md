#  Smart Bike Premium — v2.0
### Projet E-commerce · Portfolio BTS SIO · PHP 8 + MySQL + Leaflet.js
##  Arborescence complète

smart_bike_v2/
│
├── 📄 database.sql          → BDD : tables produits, magasins, avis + données
├── 📄 db.php                → Connexion PDO + fonctions utilitaires (e, formatPrix, etoiles…)
├── 📄 index.php             → Accueil : Hero animé, stats, catégories, produits vedettes
├── 📄 catalogue.php         → Catalogue : filtres par catégorie + tri dynamique
├── 📄 produit.php           → Fiche produit : specs, galerie, avis, produits similaires
├── 📄 magasins.php          → 4 boutiques + carte Leaflet.js interactive
├── 📄 contact.php           → Formulaire validé côté serveur (PHP)
│
├── 📄 style.css             → CSS Premium "Luxury Dark Tech" — 19 sections
│
└── includes/
    ├── header.php           → <head> + navbar sticky responsive
    └── footer.php           → Footer + scripts JS globaux


## Installation

### 1. Créer la base de données
1. Lancer **XAMPP** → démarrer Apache + MySQL
2. Ouvrir `http://localhost/phpmyadmin`
3. Onglet **Importer** → sélectionner `database.sql` → Exécuter

### 2. Déployer le projet
```
Copier smart_bike_v2/ dans : C:/xampp/htdocs/smart_bike_v2/
```

### 3. Configurer `db.php` si nécessaire
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');          // vide sur XAMPP par défaut
define('DB_NAME', 'smart_bike');
```

### 4. Ouvrir dans le navigateur
```
http://localhost/smart_bike_v2/
```

---

##  Carte géographique (Leaflet.js)

La page `magasins.php` utilise **Leaflet.js** avec les tuiles **OpenStreetMap** (100% gratuit).

Les coordonnées GPS sont stockées en base de données (`lat`, `lng`).
Le code PHP encode les données en JSON avec `json_encode()`, puis JavaScript crée les marqueurs dynamiquement.

**Fonctionnalités de la carte :**
- Marqueurs personnalisés (icône ⚡ dorée)
- Popup avec adresse, téléphone, horaires au clic
- Animation `flyTo()` lors du clic sur une boutique dans la liste
- Lien "Itinéraire" vers Google Maps
- Fond sombre (filtre CSS `hue-rotate`)

---

##  Sécurité — Récapitulatif

| Technique | Où | Pourquoi |
|-----------|-----|----------|
| `htmlspecialchars()` via `e()` | Partout | Anti-XSS |
| Requêtes préparées + `bindValue()` | `produit.php`, `catalogue.php` | Anti-injection SQL |
| `(int)` cast sur `$_GET['id']` | `produit.php` | Validation de type |
| `in_array()` sur les filtres | `catalogue.php` | Liste blanche de valeurs |
| `FILTER_VALIDATE_EMAIL` | `contact.php` | Validation d'email PHP natif |
| `PDO::ERRMODE_EXCEPTION` | `db.php` | Remontée d'erreurs SQL |
| `http_response_code(500)` | `db.php` | Codes HTTP appropriés |
| `trim()` sur tous les inputs | `contact.php` | Nettoyage des espaces |


##  Stack technique

| Technologie | Usage |
|-------------|-------|
| **PHP 8** (procédural) | Logique serveur, templates |
| **PDO** | Accès BDD sécurisé |
| **MySQL** | 3 tables : produits, magasins, avis |
| **HTML5** | Structure sémantique |
| **CSS3** | Variables, Grid, Flexbox, animations, responsive |
| **JavaScript** (vanilla) | Navbar scroll, burger, IntersectionObserver, compteurs |
| **Leaflet.js** (CDN) | Carte interactive open source |
| **Google Fonts** (CDN) | Cormorant Garamond + DM Sans |

>  Leaflet.js et Google Fonts sont les **seules dépendances externes** — chargées via CDN, pas installées localement.


## Fonctionnalités

- [x] Accueil avec hero animé (particules CSS) et carte produit 3D flottante
- [x] Statistiques animées au scroll (IntersectionObserver)
- [x] Catalogue avec **filtres par catégorie** et **tri** (prix, note, autonomie)
- [x] Fiche produit avec galerie d'images switchable
- [x] Spécifications techniques (autonomie, puissance, poids)
- [x] **Avis clients** depuis la BDD avec étoiles dynamiques
- [x] Produits similaires (même catégorie)
- [x] **Carte interactive** (Leaflet.js) avec marqueurs personnalisés
- [x] Focus + animation `flyTo()` depuis la liste des boutiques
- [x] **Formulaire de contact** avec validation PHP côté serveur
- [x] Navbar sticky responsive + menu burger mobile
- [x] Footer avec colonnes de navigation
- [x] Design responsive (desktop / tablette / mobile)
- [ ] Panier d'achat *(extension possible)*
- [ ] Espace client + commandes *(extension possible)*
- [ ] Système d'administration *(extension possible)*
