<?php
function LireEmails($fichier){
    return array_filter(array_map('trim', file($fichier)));

}
function separerValidesInvalides($emails){
    $valides = [];
    $invalides = [];
    foreach ($emails as $email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $valides[] = $email;
        } else {
            $invalides[] = $email;
        }
    }
    return [$valides, $invalides];

}
 function ecrireFichier($fichier , $lignes){
    file_put_contents($fichier, implode(PHP_EOL, $lignes));
 }
 function separerParDomaine($emails){
    $domaines = [];
    foreach ($emails as $email){
        $domaine = explode('@', $email)[1];
        $domaines[$domaine][] = $email;
    }
    foreach ($domaines as $domaine => $liste){
        sort($liste);
        ecrireFichier("$domaine.txt", $liste);
    }
 }
 $emails = LireEmails('emails.txt');
 [$valides, $invalides] = separerValidesInvalides($emails);
 ecrireFichier('invalides.txt', $invalides);
 $validesUniques=array_unique($valides);
 sort($validesUniques);
 ecrireFichier('valides.txt', $validesUniques);
 separerParDomaine($validesUniques);
 echo "Traitement terminé. Les fichiers ont été générés.";
?>
<!DOCTYPE html>
<html>
<head><title>Gestion des emails</title></head>
<body>
    <h2>Uploader le fichier Emails.txt</h2>
    <form action="traiter.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="fichier_emails" accept=".txt" required>
        <button type="submit">Traiter</button>
    </form>

    <br>
    <a href="ajouter.php">Ajouter une adresse manuellement</a>
</body>
</html>