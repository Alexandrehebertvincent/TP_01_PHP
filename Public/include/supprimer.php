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
                unlink("../".ObtenirCheminImageFilm($_GET["filmid"]));

                $req = $connBD->prepare("DELETE FROM films WHERE Id=:Id");
                $req->execute(array("Id"=>$_GET['filmid']));

                $req->closeCursor();
                $connBD = null;

                $message = 10;
				
            } catch (PDOException $e) {
                exit( "Erreur lors de l'ex�cution de la requ�te SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQU�TE = SELECT");
            }
        } else {
            $message = 11;
        }
    }else{
    $message = 11;
}
$_SESSION["messages"][] = $message;
header("Location:../index.php");