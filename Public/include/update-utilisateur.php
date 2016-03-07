<?php

session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['pseudo'], $_POST['mdp'], $_POST['mdpR'])) { 
		if (($_POST['pseudo'] != "" AND $_POST['mdp'] != "" AND  $_POST['mdpR'] != "")) {
			if ($_POST['mdp'] == $_POST['mdpR']) {
				try {
                    // Inclure le fichier de connexion.
                    include ("config.php");

                    $cost = 10;
                    $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
                    $salt = sprintf("$2a$%02d$", $cost) . $salt;
                    $hash = crypt($_POST['mdp'], $salt);
					
					// Si le mot de passe n'a pas été modifié
					if ($hash == $_POST['mdp']) {
						$req = $connBD->prepare('UPDATE users SET Nom=:nom, Acces=:acces WHERE Id=:userid');
						$req->execute(array(
						"nom"=>$_POST['pseudo'],
						"acces"=>$_POST['acces'],
						"userid"=>$_POST['userid']));

						$req = $connBD->prepare('SELECT * FROM users WHERE Nom =:nom');
						$req->execute(array("nom"=>$_POST['pseudo']));
					}
					else
					{

                    $req = $connBD->prepare('UPDATE users SET Nom=:nom, Mot_de_Passe=:mdp, Acces=:acces WHERE Id=:userid');
                    $req->execute(array(
					"nom"=>$_POST['pseudo'],
					"mdp"=>$hash,
					"acces"=>$_POST['acces'],
					"userid"=>$_POST['userid']));

                    $req = $connBD->prepare('SELECT * FROM users WHERE Nom =:nom');
                    $req->execute(array("nom"=>$_POST['pseudo']));
					}
					

                    // Si les donn�es existes, l'utilisateur est alors cr��.
                    while ($donnees = $req->fetch()) {
                        if($donnees["Mot_de_Passe"] == crypt($_POST['mdp'], $donnees["Mot_de_Passe"])){
							//Si le compte est cr�� � partir de la page "connexion"
							if ($_POST['pagedorigine'] == "connexion") {
                            $_SESSION['utilisateur'] = array(
                                "Id" => $donnees["Id"],
                                "Nom" => $donnees["Nom"],
                                "Acces" => $donnees["Acces"]
                            );
                            header("LOCATION: ../index.php");
							}
							else if ($_POST['pagedorigine'] == "gestion") {
								header("LOCATION: ../gestion-utilisateurs.php");
							}
							
							//Sinon, le compte est cr�� depuis la page d'administration d'un admin
							
                        } else {
                            $_SESSION = array();
                            echo '<div class="error error-red"><h3>Le pseudo et le mot de passe ne concorde pas!</h3></div>';
                        }
                    }

                    $req->closeCursor();
                    $connBD = null;
					
					//header("Location:../gestion-utilisateurs.php");

                } catch (PDOException $e) {
                    exit( "Erreur lors de l'ex�cution de la requ�te SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQU�TE = SELECT");
                }
            } else {
                echo '<div class="error error-orange"><h3>Les mots de passes ne concordent pas!</h3></div>';
            }
        } else {
            $_SESSION["messages"][] = 14;
            header("LOCATION:../modifier-utilisateur.php?userid=".$_POST['userid']);
        }
    } else {
        $_SESSION["messages"][] = 2;
        header("LOCATION:../modifier-utilisateur.php?userid=".$_POST['userid']);
    }
}