<?php

// V�rification connexion
include ("include/verification-connexion.php");
include ("include/fonctions.php");

echo "Connect� en tant que: " . $_SESSION['utilisateur']['Nom'] . " (" . $_SESSION['utilisateur']['Acces'] . ")";			
        ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Cr�er un utilisateur</title>
	<link rel="stylesheet" type="text/css" href="css/styleIndex.css" media="all" />
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
    <link rel="icon" href="favicon.ico" />
</head>
<body>
    <?php include ("navbar-top.php"); ?>
	<h1> Cr�er un nouvel utilisateur</h1>
	<div id="page">
        <div id="blocAlign">
                <form method="post" id="frmajout" action="include/creation-compte.php">
					<p>
						<label for="titreFilm">Nom d'utilisateur: </label>
						<input type="text" name="pseudo" id="pseudo" size="42">
					</p>
					<p>
						<label for="description">Mot de passe: </label>
						<input type="text" name="mdp" id="mdp">
					</p>
					<p>
						<label for="description">Confirmer le mot de passe: </label>
						<input type="text" name="mdpR" id="mdpR">
					</p>
					<p>
					<input class="radio" type="radio" name="acces" value="admin">Administrateur
                    <input class="radio" type="radio" name="acces" value="user" checked>Utilisateur
					</p>
					<p>
						<input id="submit" type="submit" value="Cr�er l'utilisateur"/>
					</p>
					<input type="hidden" name="pagedorigine" id="hiddenField" value="gestion" />
                </form>
			</div>

			<h2> Utilisateurs existants </h2>
			<?php include("include/affichage-utilisateurs.php"); ?>
	</div>
</body>
</html>	