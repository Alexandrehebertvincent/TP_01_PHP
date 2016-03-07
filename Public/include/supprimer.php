<?php

session_start();

$message = '';
if (isset($_GET['filmid'])) {
	if ($_GET['filmid'] != "") {
            // Lancer la requ�te pour identifer l'utilisateur.
            try {
                // Inclure le fichier de connexion.
                require("config.php");
                include_once ("fonctions.php");
                // Supprimer l'image existante.
                unlink("../".ObtenirCheminImageFilm($_GET["filmid"]));
                $req = $connBD->prepare("DELETE FROM films WHERE Id=:Id");
                $req->execute(array("Id"=>$_GET['filmid']));
                $req->closeCursor();
                $connBD = null;
                // Opération réussie.
                $message = 10;
            } catch (PDOException $e) {
                exit( "Erreur lors de l'exécution de la requête SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQUËTE = SELECT");
            }
        } else {
            $message = 11;
        }
    }else{
    $message = 11;
}
$_SESSION["messages"][] = $message;
header("Location:../index.php");