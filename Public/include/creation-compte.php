<?php

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

                    $req = $connBD->prepare('INSERT INTO users(Nom, Mot_de_Passe, Acces) VALUES(:nom, :mdp, :acces)');
                    $req->execute(array("nom"=>$_POST['pseudo'],"mdp"=>$hash,"acces"=>$_POST['acces']));

                    $req = $connBD->prepare('SELECT * FROM users WHERE Nom =:nom');
                    $req->execute(array("nom"=>$_POST['pseudo']));

                    // Si les données existes, l'utilisateur est alors créé.
                    while ($donnees = $req->fetch()) {
                        if($donnees["Mot_de_Passe"] == crypt($_POST['mdp'], $donnees["Mot_de_Passe"])){
                            $_SESSION['utilisateur'] = array(
                                "Id" => $donnees["Id"],
                                "Nom" => $donnees["Nom"],
                                "Acces" => $donnees["Acces"]
                            );
                            header("LOCATION: index.php");
                        } else {
                            $_SESSION = array();
                            echo '<div class="error error-red"><h3>Le pseudo et le mot de passe ne concorde pas!</h3></div>';
                        }
                    }

                    $req->closeCursor();
                    $connBD = null;

                } catch (PDOException $e) {
                    exit( "Erreur lors de l'exécution de la requête SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQUÊTE = SELECT");
                }
            } else {
                echo '<div class="error error-orange"><h3>Les mots de passes ne concordent pas!</h3></div>';
            }
        } else {
            echo '
                <div class="error error-orange"><h3>Vous devez remplir tous les champs du formulaire!</h3></div>
                ';
        }
    }
}