<?php

session_start();

if (isset($_GET['userid'])) {
    if ($_GET['userid'] != "") {
        // Lancer la requ�te pour identifer l'utilisateur.
        try {
            // Inclure le fichier de connexion.
            require("config.php");
            $req = $connBD->prepare("DELETE FROM users WHERE Id=:userid");
            $req->execute(array("userid"=>$_GET['userid']));
            $req->closeCursor();
            $connBD = null;
            if ($_GET["userid"] == $_SESSION["utilisateur"]["Id"]){
                $_SESSION["messages"][] = 13;
                require "deconnexion.php";
            }
            $_SESSION["messages"][] = 13;
        } catch (PDOException $e) {
            exit( "Erreur lors de l'exécution de la requête SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQUËTE = SELECT");
        }
    } else {
        $_SESSION["messages"][] = 2;
    }
}
header("Location:../gestion-utilisateurs.php");