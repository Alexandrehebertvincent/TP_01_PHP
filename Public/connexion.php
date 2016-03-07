<?php

session_start();

// Libère les cookies existants.
unset($_COOKIE["resterConnId"]);
setcookie("resterConnId", '', time()-3600);

// Vérification s'il y a un message.
if (isset($_SESSION["messages"])) {
    include_once("include/fonctions.php");
    foreach ($_SESSION["messages"] as $mess) {
        GetErreur($mess);
    }
    $_SESSION["messages"] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier s'il y a eu une requête de connexion.
    if (isset($_POST['pseudo'], $_POST['mdp'])) {
        // Vérifier si les champs ne sont pas vides.
        if ($_POST['pseudo'] != '' && $_POST['mdp'] != '') {
            // Lancer la requête pour identifer l'utilisateur.
            try {
                // Inclure le fichier de connexion.
                require("include/config.php");

                $cost = 10;
                $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
                $salt = sprintf("$2a$%02d$", $cost) . $salt;
                $hash = crypt($_POST['mdp'], $salt);

                // Option de rester connecté
                $_SESSION['rester'] = (isset($_POST["resterL"]) == true ? true : false);

                $req = $connBD->prepare('SELECT * FROM users WHERE Nom =:nom');
                $req->execute(array("nom"=>$_POST['pseudo']));

                // Si les données existent, l'utilisateur est alors créé.
                while ($donnees = $req->fetch()) {
                    if ($donnees != null){
                        if($donnees["Mot_de_Passe"] == crypt($_POST['mdp'], $donnees["Mot_de_Passe"])){
                            $_SESSION['utilisateur'] = array(
                                "Id" => $donnees["Id"],
                                "Nom" => $donnees["Nom"],
                                "Acces" => $donnees["Acces"]
                            );

                            // Création du cookie
                            if ($_SESSION["rester"] == true){
                                setcookie("resterConnId", $donnees["Id"], time()+3600);
                            }

                            header("LOCATION: index.php");
                        } else {
                            $_SESSION = array();
                            echo '<div class="error error-red"><h3>Le pseudo et le mot de passe ne concorde pas!</h3></div>';
                        }
                    }
                }

                if ($donnees == NULL){
                    echo '<div class="error error-red"><h3>Utilisateur inexistant!</h3></div>';
                }

                $req->closeCursor();
                $connBD = null;
            } catch (PDOException $e) {
                exit( "Erreur lors de l'exécution de la requête SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQUÊTE = SELECT");
            }
        } else {
            echo '<div class="error error-orange"><h3>Vous devez remplir tous les champs du formulaire!</h3></div>';
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Connexion/Création d'un compte</title>
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic|Lato:400,100,300,700,900:latin' rel='stylesheet' type='text/css'>
    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="favicon.ico" />
</head>
<body id="body-connexion">
<div class="filter filter-noir"></div>
<div class="logmod">
    <div class="logmod__wrapper">
        <div class="logmod__container">
            <ul class="logmod__tabs">
                <li data-tabtar="lgm-2"><a href="#">Connexion</a></li>
                <li data-tabtar="lgm-1"><a href="#">Créer un compte</a></li>
            </ul>
            <div class="logmod__tab-wrapper">
                <div class="logmod__tab lgm-1">
                    <div class="logmod__heading">
                        <span class="logmod__heading-subtitle">Entrez vos informations <strong>pour créer un compte.</strong></span>
                    </div>
                    <div class="logmod__form">
                        <form method="post" action="include/creation-compte.php" class="simform">
                            <div class="sminputs">
                                <div class="input full">
                                    <label class="string" for="user-name">Pseudo</label>
                                    <input class="string" maxlength="255" name="pseudo" placeholder="Pseudo" type="text" size="50" />
                                </div>
                            </div>
                            <div class="sminputs">
                                <div class="input string">
                                    <label class="string" for="user-pw">Mot de passe</label>
                                    <input class="string" maxlength="255" name="mdp" placeholder="Mot de passe" type="password" size="50" />
                                </div>
                                <div class="input string">
                                    <label class="string" for="user-pw-repeat">Répétez</label>
                                    <input class="string" maxlength="255" name="mdpR" placeholder="Répéter mot de passe" type="password" size="50" />
                                </div>
                            </div>
                            <div class="sminputs sminputs-radio">
                                <label class="string" for="admin_radio">Administrateur</label>
                                <input title="Administrateur" id="admin_radio" class="radio" type="radio" name="acces" value="admin">
                                <label class="string" for="user_radio">Utilisateur</label>
                                <input title="Utilisateur" id="user_radio" class="radio" type="radio" name="acces" value="user" checked>
                            </div>
                            <div class="simform__actions">
                                <input class="sumbit" type="submit" value="Créer" />
                            </div>
							<input type="hidden" name="pagedorigine" id="hiddenField" value="connexion" >
                        </form>
                    </div>
                </div>
                <div class="logmod__tab lgm-2">
                    <div class="logmod__heading">
                        <span class="logmod__heading-subtitle">Entrez votre pseudo et votre mot de passe <strong>pour vous connecter.</strong></span>
                    </div>
                    <div class="logmod__form">
                        <form class="simform" action="connexion.php" method="post">
                            <div class="sminputs">
                                <div class="input full">
                                    <label class="string optional" for="pseudo">Pseudo</label>
                                    <input class="string optional" maxlength="255" name="pseudo" placeholder="Pseudo" type="text" size="50"
                                    <?php
                                        echo isset($_POST['pseudo']) == true ? 'value="'.$_POST['pseudo'].'"' : '';
                                    ?>
                                    />
                                </div>
                            </div>
                            <div class="sminputs">
                                <div class="input full">
                                    <label class="string optional" for="mdp">Mot de passe</label>
                                    <input class="string optional" maxlength="255" name="mdp" placeholder="Mot de passe" type="password" size="50" />
                                    <span class="hide-password">Voir</span>
                                </div>
                            </div>
                            <div class="simform__actions">
                                <label class="string" for="checkbox_rester">Restez connecté</label>
                                <input class="string" id="checkbox_rester" type="checkbox" value="" name="resterL" />
							<input class="sumbit" type="submit" value="Connexion" >
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/index.js"></script>
</body>
</html>

