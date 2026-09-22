<?php

function lireEmails($fichier) {
    return array_filter(array_map('trim', file($fichier)));
}

function separerValidesInvalides($emails) {
    $valides = [];
    $invalides = [];
    foreach ($emails as $email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $valides[] = $email;
        } else {
            $invalides[] = $email;
        }
    }
    return [$valides, $invalides];
}

function ecrireFichier($fichier, $lignes) {
    file_put_contents($fichier, implode(PHP_EOL, $lignes));
}

function separerParDomaine($emails) {
    $domaines = [];
    foreach ($emails as $email) {
        $domaine = explode('@', $email)[1];
        $domaines[$domaine][] = $email;
    }
    foreach ($domaines as $domaine => $liste) {
        sort($liste);
        ecrireFichier("$domaine.txt", $liste);
    }
}