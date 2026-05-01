<?php

define('DB_HOST',    'localhost');
define('DB_NAME',    'smart_bike');
define('DB_USER',    'root');
define('DB_PASS',    '');
define('DB_CHARSET', 'utf8mb4');
define('SITE_NAME',  'SmartBike');
define('SITE_URL',   'http://localhost/smart_bike_v2');

try {
    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        DB_HOST, DB_NAME, DB_CHARSET
    );
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // Page d'erreur propre au lieu d'un message brut
    http_response_code(500);
    die('<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Erreur</title>
    <style>body{background:#0d0f14;color:#fff;font-family:sans-serif;display:flex;
    align-items:center;justify-content:center;height:100vh;flex-direction:column;}
    h1{color:#ff4f4f;}p{color:#8892a4;}</style></head>
    <body><h1>⚠️ Erreur de connexion BDD</h1>
    <p>' . htmlspecialchars($e->getMessage()) . '</p></body></html>');
}


function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function formatPrix(float $prix): string {
    return number_format($prix, 2, ',', ' ') . ' €';
}

function etoiles(float $note): string {
    $html = '<span class="stars">';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= floor($note)) {
            $html .= '<span class="star full">★</span>';
        } elseif ($i - $note < 1 && $i - $note > 0) {
            $html .= '<span class="star half">★</span>';
        } else {
            $html .= '<span class="star empty">★</span>';
        }
    }
    $html .= '</span>';
    return $html;
}

/**
 * Badge HTML pour la catégorie de vélo
 */
function badgeCategorie(string $cat): string {
    $labels = [
        'urban' => ['🏙️ Urban',  'badge-urban'],
        'trail' => ['🏔️ Trail',  'badge-trail'],
        'cargo' => ['📦 Cargo',  'badge-cargo'],
        'speed' => ['⚡ Speed',  'badge-speed'],
    ];
    [$label, $class] = $labels[$cat] ?? ['Autre', 'badge-urban'];
    return '<span class="badge ' . $class . '">' . $label . '</span>';
}

function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}
