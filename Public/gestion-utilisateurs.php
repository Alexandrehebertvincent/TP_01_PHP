<?php

	// V�rification connexion
	include ("include/verification-connexion.php");
	include ("include/fonctions.php");

	//echo "Connect� en tant que: " . $_SESSION['utilisateur']['Nom'] . " (" . $_SESSION['utilisateur']['Acces'] . ")";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Cr�er un utilisateur</title>
	<!--<link rel="stylesheet" type="text/css" href="css/styleIndex.css" media="all" />-->
	<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic|Lato:400,100,300,700,900:latin' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
    <link rel="icon" href="favicon.ico" />
</head>
<body>
     <?php if ($_SESSION['utilisateur']['Acces'] == 'admin') {
		include ("navbar-top-admin.php"); 
	}
	else {
		include ("navbar-top.php"); 
	}
	?>
	 <header id="gestion-user">
		 <h1>Utilisateurs existants</h1>
		 <img src="http://simpleicon.com/wp-content/uploads/multy-user.png">
	 </header>
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
						<input id="submit" class="button file-upload-btn btn-auto" type="submit" value="Créer l'utilisateur"/>
					</p>
					<input type="hidden" name="pagedorigine" id="pagedorigine" value="gestion" />
                </form>
			</div>

			<h2> Utilisateurs existants </h2>
			<?php include("include/affichage-utilisateurs.php"); ?>
	</div>
</body>
</html>	