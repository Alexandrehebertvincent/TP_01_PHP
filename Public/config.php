<?php

// Paramètres de connexion à la base de données MySQL
// ==================================================

// Serveur
$dbHote = "localhost";

// Nom d'utilisateur
$dbUtilisateur = "garneau";

// Mot de passe
$dbMotPasse = "qwerty123";

// Base de données
$dbNom = "tp1_dionlaflamme_hebertvincent";

// Création d'une connexion à la BD.
try {
    $connBD = new PDO('mysql:host='.$dbHote.'; dbname='.$dbNom.'', $dbUtilisateur, $dbMotPasse, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $connBD -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch (PDOException $e) {
    exit( "Erreur lors de la connexion à la BD :<br />\n" .  $e->getMessage() );
}
