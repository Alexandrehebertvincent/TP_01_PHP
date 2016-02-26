<?php

session_start();

echo $_POST['pseudo'];
print_r($_POST);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo "charmante";
}

// Vérifier s'il y a eu une requête de connexion.
if (isset($_POST['pseudo']) && isset($_POST['mdp'])) {
    // Vérifier si les champs ne sont pas vides.
    if ($_POST['pseudo'] != '' && $_POST['mdp'] != '') {
        // Lancer la requête pour identifer l'utilisateur.
        try {
            // Inclure le fichier de connexion.
            include ("config.php");

            $req = $connBD->prepare('SELECT * FROM users WHERE Nom = ? AND Mot_de_Passe = ?');
            $req->execute(array($_POST['pseudo'], $_POST['mdp']));

            // L'utilisateur est initialisé à NULL.
            $_SESSION['utilisateur'] = NULL;
            // Si les données existes, l'utilisateur est alors créé.
            while ($donnees = $req->fetch()) {
                $_SESSION['utilisateur'] = array(
                    "Id" => $donnees["Id"],
                    "Nom" => $donnees["Nom"],
                    "Acces" => $donnees["Acces"]
                );
            }

            $req->closeCursor();
            $connBD = null;
        } catch (PDOException $e) {
            exit( "Erreur lors de l'exécution de la requête SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQUÊTE = SELECT");
        }

        // Vérifier si l'utilisateur est créé.
        // Si oui, rediriger vers la page d'accueil.
        if ($_SESSION["utilisateur"] != NULL && isset($_SESSION["utilisateur"])) {
            header("LOCATION: index.php");
        }
    }
}

echo 'Connexion!';
echo $_POST['pseudo'];
print_r($_POST);
echo 'Essai 1';
var_dump($_SESSION['utilisateur']);
var_dump($_COOKIE["utilisateur"]);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Connexion/Création d'un compte</title>


    <link rel="stylesheet" href="css/normalize.css">

    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

    <link rel="stylesheet" href="css/style.css">


</head>

<body>

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
                        <span class="logmod__heading-subtitle">Entrez vos informations <strong>pour créer un compte</strong></span>
                    </div>
                    <div class="logmod__form">
                        <form accept-charset="utf-8" action="#" class="simform">
                            <div class="sminputs">
                                <div class="input full">
                                    <label class="string optional" for="user-name">Pseudo</label>
                                    <input class="string optional" maxlength="255" id="user-email" placeholder="Pseudo" type="text" size="50" />
                                </div>
                            </div>
                            <div class="sminputs">
                                <div class="input string optional">
                                    <label class="string optional" for="user-pw">Mot de passe</label>
                                    <input class="string optional" maxlength="255" id="user-pw" placeholder="Mot de passe" type="text" size="50" />
                                </div>
                                <div class="input string optional">
                                    <label class="string optional" for="user-pw-repeat">Répétez</label>
                                    <input class="string optional" maxlength="255" id="user-pw-repeat" placeholder="Répéter mot de passe" type="text" size="50" />
                                </div>
                            </div>
                            <div class="simform__actions">
                                <input class="sumbit" name="commit" type="sumbit" value="Creation compte" />
                                <span class="simform__actions-sidetext">Par la création de votre compte, vous acceptez <a class="special" href="#" target="_blank" role="link">nos termes d'utilisation.</a></span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="logmod__tab lgm-2">
                    <div class="logmod__heading">
                        <span class="logmod__heading-subtitle">Entrez votre pseudo et votre mot de passe <strong>pour vous connecter</strong></span>
                    </div>
                    <div class="logmod__form">
                        <form class="simform" method="post">
                            <div class="sminputs">
                                <div class="input full">
                                    <label class="string optional" for="pseudo">Pseudo</label>
                                    <input class="string optional" maxlength="255" name="pseudo" placeholder="Pseudo" type="text" size="50" />
                                </div>
                            </div>
                            <div class="sminputs">
                                <div class="input full">
                                    <label class="string optional" for="user-pw">Mot de passe</label>
                                    <input class="string optional" maxlength="255" name="mdp" placeholder="Mot de passe" type="password" size="50" />
                                    <span class="hide-password">Voir</span>
                                </div>
                            </div>
                            <div class="simform__actions">
							<input class="sumbit" type="submit" value="Connexion" >
                                <span class="simform__actions-sidetext"><a class="special" role="link" href="#">Vous avez oublié votre mot de passe?<br>Cliquer ici</a></span> 
                            </div>
                        </form>
                    </div>
					<form method="post">
			<p>
				<label for="nome">Nom: </label>
				<input type="text" name="pseudo" />
			</p>
			<p>
				<label for="age">Âge: </label>
				<input type="text" name="mdp" />
			</p>
			<p>
				<label for="couleur">COULEUR</label>
				<input type="text" name="couleur" />
			</p>
			<p>
				<input type="submit" value="Envoyer" />
			</p>
		</form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="js/index.js"></script>


</body>

</html>

