<?php
require 'fonctions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fichier_emails'])) {
   $cheminUpload = $_FILES['fichier_emails']['tmp_name'];
   $cheminFinal='emails.txt';
   move_uploaded_file($cheminUpload, $cheminFinal);
   $emails = LireEmails($cheminFinal);
   [$valides, $invalides] = separerValidesInvalides($emails);
    ecrireFichier('invalides.txt', $invalides);
    $validesUniques=array_unique($valides);
    sort($validesUniques);
    ecrireFichier('valides.txt', $validesUniques);
    separerParDomaine($validesUniques);
    echo"<h3>Traitement terminé. Les fichiers ont été générés.</h3>";
    echo"<a href='invalides.txt' download>Télécharger invalides.txt</a><br>";
}

?>
<a href="index.php">Retour à l'accueil</a>