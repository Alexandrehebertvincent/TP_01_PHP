<?php

if (isset($_GET['filmid'])) {
	if ($_GET['filmid'] != "") {
            // Lancer la requête pour identifer l'utilisateur.
            try {
                // Inclure le fichier de connexion.
                require("config.php");
				
				
			
                // $cost = 10;
                // $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
                // $salt = sprintf("$2a$%02d$", $cost) . $salt;
                // $hash = crypt($_POST['mdp'], $salt);

                $req = $connBD->prepare("DELETE FROM films WHERE Id=:Id");
				
                $req->execute(array("Id"=>$_GET['filmid']));
				echo "1allo:)";
				echo "2allo:)";

                $req->closeCursor();
                $connBD = null;
            } catch (PDOException $e) {
                exit( "Erreur lors de l'exécution de la requête SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQUÊTE = SELECT");
            }
        } else {
            echo '<div class="error-orange"><h3>Vous devez remplir tous les champs du formulaire!</h3></div>';
        }
    }
	
	header("Location:index.php");

?>