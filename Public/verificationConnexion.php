<?php

session_start();

$bUtilisateurConnecte = false;

// Vérifier si le cookie existe.
if(isset($_COOKIE['utilisateur']) && $_COOKIE['utilisateur'] != NULL){
    // L'utilisateur enregistré dans un cookie.
    // Création de la session.
    $_SESSION["utilisateur"] = array(
        "Id" => $_COOKIE['utilisateur']["Id"],
        "Nom" => $_COOKIE['utilisateur']["Nom"],
        "Acces" => $_COOKIE['utilisateur']["Acces"]
    );
    $bUtilisateurConnecte = true;
}

// Vérifier si une session est en cours, s'il n'y avait pas de cookie.
if (!$bUtilisateurConnecte) {
    if (isset($_SESSION["utilisateur"]) && $_SESSION["utilisateur"] != NULL) {
        // L'utilisateur est déjà connecté.
        $bUtilisateurConnecte = true;
    }
}

if ($bUtilisateurConnecte) {
    header("LOCATION: index.php");
} else {
    // Si l'utilisateur n'est pas connecté, rediriger vers le formulaire de connexion.
    header("LOCATION: connexion.php");
}

// Sinon, ne rien faire.