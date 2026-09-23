<?php
require 'fonctions.php';

$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // --- validation côté serveur (obligatoire, ne jamais faire confiance au client) ---
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Format d'adresse email invalide.";
    } else {
        // vérifier si l'adresse existe déjà dans valides.txt
        $existants = file_exists('valides.txt')
            ? array_map('trim', file('valides.txt'))
            : [];

        if (in_array($email, $existants)) {
            $erreur = "Cette adresse existe déjà dans la liste.";
        } else {
            $existants[] = $email;
            sort($existants);
            ecrireFichier('valides.txt', $existants);
            $succes = "Adresse ajoutée avec succès : $email";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Ajouter une adresse</title></head>
<body>
    <h2>Ajouter une nouvelle adresse email</h2>

    <?php if ($erreur): ?>
        <p style="color:red;"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <?php if ($succes): ?>
        <p style="color:green;"><?= htmlspecialchars($succes) ?></p>
    <?php endif; ?>

    <form action="ajouter.php" method="POST">
        <!-- validation côté client via l'attribut type="email" + pattern -->
        <input type="email" name="email" placeholder="exemple@domaine.com" required>
        <button type="submit">Ajouter</button>
    </form>

    <br>
    <a href="index.php">Retour à l'accueil</a>
</body>
</html>