<?php

$page_title = $page_title ?? 'SmartBike — Vélos Électriques Premium';
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title) ?></title>
 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
 
    <!-- Leaflet CSS via jsDelivr (CDN fiable) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.css">
 
    <link rel="stylesheet" href="style.css">
</head>
<body>
 
<nav class="navbar" id="navbar">
    <div class="nav-container">
        <a href="index.php" class="nav-logo">
            <span class="logo-bolt">⚡</span>
            <span>Smart<strong>Bike</strong></span>
        </a>
        <ul class="nav-links">
            <li><a href="index.php"     class="nav-link <?= $current_page === 'index.php'    ? 'active' : '' ?>">Accueil</a></li>
            <li><a href="catalogue.php" class="nav-link <?= $current_page === 'catalogue.php' ? 'active' : '' ?>">Catalogue</a></li>
            <li><a href="magasins.php"  class="nav-link <?= $current_page === 'magasins.php'  ? 'active' : '' ?>">Nos Magasins</a></li>
            <li><a href="contact.php"   class="nav-link <?= $current_page === 'contact.php'   ? 'active' : '' ?>">Contact</a></li>
        </ul>
        <div class="nav-actions">
            <button class="btn-cart" title="Panier" onclick="alert('Panier — à développer !')">
                🛒 <span class="cart-count">0</span>
            </button>
            <button class="nav-burger" id="navBurger" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>
 
<div class="mobile-menu" id="mobileMenu">
    <a href="index.php">Accueil</a>
    <a href="catalogue.php">Catalogue</a>
    <a href="magasins.php">Nos Magasins</a>
    <a href="contact.php">Contact</a>
</div>
