<?php
include("fonctions.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier s'il y a eu une requête de connexion.
    if (isset($_POST['pseudo']) && isset($_POST['mdp']) && isset($_POST['mdpR'])) {
        // Vérifier si les champs ne sont pas vides.
        if ($_POST['pseudo'] != '' && $_POST['mdp'] != '' && $_POST['mdpR'] != '') {
            if ($_POST['mdp'] == $_POST["mdpR"]){
                try {
                    // Inclure le fichier de connexion.
                    include ("config.php");

                    $cost = 10;
                    $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
                    $salt = sprintf("$2a$%02d$", $cost) . $salt;
                    $hash = crypt($_POST['mdp'], $salt);
					
					// Vérifie que ce nom d'utilisateur n'est pas déjà utilisé
					if (!VerifierPseudoUserExistant($_POST['pseudo'])) {

                    $req = $connBD->prepare('INSERT INTO users(Nom, Date_Naissance, Adresse, Telephone, Email, Mot_de_Passe, Acces) VALUES(:nom, :dateNaissance, :adresse, :telephone, :email, :mdp, :acces)');
                    $req->execute(array(
                        "nom"=>$_POST['pseudo'],
                        "dateNaissance"=>$_POST['dateNaissance'],
                        "adresse"=>$_POST['adresse'],
                        "telephone"=>$_POST['telephone'],
                        "email"=>$_POST['email'],
                        "mdp"=>$hash,
                        "acces"=>$_POST['acces']
                    ));

                    $req = $connBD->prepare('SELECT * FROM users WHERE Nom =:nom');
                    $req->execute(array("nom"=>$_POST['pseudo']));
					
                    // Si les données existent, l'utilisateur est alors créé.
                    while ($donnees = $req->fetch()) {
                        if($donnees["Mot_de_Passe"] == crypt($_POST['mdp'], $donnees["Mot_de_Passe"])){
							echo 'condition1';
							//Si le compte est créé à partir de la page "connexion"
							if ($_POST['pagedorigine'] == "connexion") {
                            $_SESSION['utilisateur'] = array(
                                "Id" => $donnees["Id"],
                                "Nom" => $donnees["Nom"],
                                "DateNaissance" => $donnees["Date_Naissance"],
                                "Adresse" => $donnees["Adresse"],
                                "Telephone" => $donnees["Telephone"],
                                "Email" => $donnees["Email"],
                                "Acces" => $donnees["Acces"]
                            );
								header("LOCATION: ../index.php");
							}
							else if ($_POST['pagedorigine'] == "gestion") {
                                $_SESSION["messages"][] = 17;
								header("LOCATION: ../gestion-utilisateurs.php");
							}
							
							//Sinon, le compte est créé depuis la page d'administration d'un admin
							
                        } else {
                            $_SESSION = array();
                            $_SESSION["messages"][] = 3;
                            header("LOCATION:../connexion.php?");
                        }

                    $req->closeCursor();
                    $connBD = null;
					}
					}
					else {
                        $_SESSION["messages"][] = 4;
                        header("LOCATION:../connexion.php");
					}
                } catch (PDOException $e) {
                    exit( "Erreur lors de l'exécution de la requête SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQUÊTE = SELECT");
                }
            // } 
			// else {
                // // echo '<div class="error error-orange"><h3>Les mots de passes ne concordent pas!</h3></div>';
            // // }
        } else {
                $_SESSION["messages"][] = 2;
                header("LOCATION:../connexion.php");
        }
			}
			else {
                $_SESSION["messages"][] = 2;
                header("LOCATION:../connexion.php");
    }
}
}