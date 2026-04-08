<?php
// ============================================================
// FICHIER : contact.php — Formulaire de contact
// ============================================================
require_once 'db.php';

// -------------------------------------------------------
// TRAITEMENT DU FORMULAIRE (POST)
// -------------------------------------------------------
$success = false;
$errors  = [];
$form    = ['nom'=>'', 'email'=>'', 'sujet'=>'', 'message'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération et nettoyage des données
    $form['nom']     = trim($_POST['nom']     ?? '');
    $form['email']   = trim($_POST['email']   ?? '');
    $form['sujet']   = trim($_POST['sujet']   ?? '');
    $form['message'] = trim($_POST['message'] ?? '');

    // Validation des champs obligatoires
    if (empty($form['nom']))     $errors[] = 'Le nom est obligatoire.';
    if (empty($form['email']))   $errors[] = "L'email est obligatoire.";
    elseif (!filter_var($form['email'], FILTER_VALIDATE_EMAIL))
                                  $errors[] = "L'email n'est pas valide.";
    if (empty($form['sujet']))   $errors[] = 'Le sujet est obligatoire.';
    if (strlen($form['message']) < 20) $errors[] = 'Le message doit faire au moins 20 caractères.';

    // Si aucune erreur : traitement (simulation d'envoi)
    if (empty($errors)) {
        // En production : mail($to, $subject, $body) ou librairie PHPMailer
        // Ici on simule le succès pour le portfolio
        $success = true;
        $form = ['nom'=>'', 'email'=>'', 'sujet'=>'', 'message'=>''];
    }
}

$page_title = 'Contact — SmartBike';
require_once 'header.php';
?>

<!-- PAGE HERO -->
<div class="page-hero">
    <div class="container">
        <span class="section-eyebrow">✉️ Écrivez-nous</span>
        <h1 class="page-hero-title">Contact</h1>
        <p>Une question ? Un essai à planifier ? On répond sous 24h.</p>
    </div>
</div>

<main class="contact-page">
<div class="container">

    <div class="contact-layout">

        <!-- INFORMATIONS DE CONTACT -->
        <div class="contact-info reveal">

            <h2>Parlons de votre prochain vélo</h2>
            <p class="contact-intro">Notre équipe de passionnés est là pour vous conseiller sur le modèle idéal, organiser un essai en boutique ou répondre à vos questions techniques.</p>

            <div class="contact-items">
                <div class="contact-item">
                    <span class="contact-icon">📞</span>
                    <div>
                        <strong>Téléphone</strong>
                        <p><a href="tel:0142778899">01 42 77 88 99</a></p>
                        <small>Lun–Sam 9h–19h</small>
                    </div>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">✉️</span>
                    <div>
                        <strong>Email</strong>
                        <p><a href="mailto:hello@smartbike.fr">hello@smartbike.fr</a></p>
                        <small>Réponse sous 24h ouvrées</small>
                    </div>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">📍</span>
                    <div>
                        <strong>Boutiques</strong>
                        <p>Paris · Lyon · Bordeaux · Marseille</p>
                        <a href="magasins.php" class="contact-link">Voir nos magasins →</a>
                    </div>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">🚴</span>
                    <div>
                        <strong>Essai gratuit</strong>
                        <p>30 minutes d'essai sans engagement</p>
                        <small>Sur rendez-vous en boutique</small>
                    </div>
                </div>
            </div>
        </div>


        <!-- FORMULAIRE DE CONTACT -->
        <div class="contact-form-wrapper reveal" style="animation-delay:.15s">

            <?php if ($success): ?>
            <!-- Message de succès -->
            <div class="form-success">
                <div class="success-icon">✅</div>
                <h3>Message envoyé !</h3>
                <p>Merci <strong><?= e($_POST['nom'] ?? 'vous') ?></strong>, nous reviendrons vers vous sous 24h.</p>
                <a href="contact.php" class="btn btn-gold">Envoyer un autre message</a>
            </div>
            <?php else: ?>

            <!-- Affichage des erreurs -->
            <?php if (!empty($errors)): ?>
            <div class="form-errors">
                <?php foreach ($errors as $err): ?>
                <p>⚠️ <?= e($err) ?></p>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Formulaire -->
            <form method="POST" action="contact.php" class="contact-form" novalidate>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nom">Votre nom <span class="required">*</span></label>
                        <input type="text" id="nom" name="nom"
                               value="<?= e($form['nom']) ?>"
                               placeholder="Marie Dupont"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" id="email" name="email"
                               value="<?= e($form['email']) ?>"
                               placeholder="marie@exemple.fr"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="sujet">Sujet <span class="required">*</span></label>
                    <select id="sujet" name="sujet" required>
                        <option value="">-- Choisissez un sujet --</option>
                        <option value="conseil" <?= $form['sujet']==='conseil' ? 'selected':'' ?>>Conseil produit</option>
                        <option value="essai"   <?= $form['sujet']==='essai'   ? 'selected':'' ?>>Réserver un essai</option>
                        <option value="sav"     <?= $form['sujet']==='sav'     ? 'selected':'' ?>>Service après-vente</option>
                        <option value="commande"<?= $form['sujet']==='commande'? 'selected':'' ?>>Suivi de commande</option>
                        <option value="autre"   <?= $form['sujet']==='autre'   ? 'selected':'' ?>>Autre</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="message">Message <span class="required">*</span></label>
                    <textarea id="message" name="message" rows="6"
                              placeholder="Décrivez votre demande en détail..."
                              required><?= e($form['message']) ?></textarea>
                </div>

                <button type="submit" class="btn btn-gold btn-large">
                    Envoyer le message ✈️
                </button>

                <p class="form-rgpd">🔒 Vos données sont traitées conformément au RGPD et ne seront jamais partagées.</p>
            </form>

            <?php endif; ?>
        </div>

    </div>
</div>
</main>

<?php require_once 'footer.php'; ?>
