<?php

session_start();

$bUtilisateurConnecte = false;

// Vérifier si le cookie existe.
if(isset($_COOKIE['resterConnId'])){
    if ($_COOKIE['resterConnId'] != ''){
        // L'utilisateur enregistré dans un cookie.
        // Création de la session.
        include_once "fonctions.php";
        $_SESSION["utilisateur"] = GetUserSelonId($_COOKIE["resterConnId"]);
        if ($_SESSION["utilisateur"] != false) {
            $bUtilisateurConnecte = true;
        }
    }
}

// Vérifier si une session est en cours, s'il n'y avait pas de cookie.
if (!$bUtilisateurConnecte) {
    if (isset($_SESSION["utilisateur"])) {
        if ($_SESSION["utilisateur"] != NULL){
            // L'utilisateur est déjà connecté.
            $bUtilisateurConnecte = true;
        }
    }
}

if ($bUtilisateurConnecte == false) {
    // Si l'utilisateur n'est pas connecté, rediriger vers le formulaire de connexion.
    header("LOCATION: connexion.php");
}

// Sinon, ne rien faire.