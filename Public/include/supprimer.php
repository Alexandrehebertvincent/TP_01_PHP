<?php
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
				
            } catch (PDOException $e) {
                exit( "Erreur lors de l'ex�cution de la requ�te SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQU�TE = SELECT");
            }
        } else {
            echo '<div class="error-orange"><h3>Vous devez remplir tous les champs du formulaire!</h3></div>';
        }
    }
	header("Location:../index.php");
?>