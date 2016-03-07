<?php

	// V�rification connexion
	include ("include/verification-connexion.php");
	include_once ("include/fonctions.php");

	if (isset($_SESSION["messages"])) {
		foreach ($_SESSION["messages"] as $mess) {
			GetErreur($mess);
		}
		$_SESSION["messages"] = array();
	}
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
		include("include/navbar-top-admin.php");
	}
	else {
		include("include/navbar-top.php");
	}
	?>
	<section id="contenu">
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
						<label class="string" for="admin_radio" style="width: auto;">Administrateur</label>
						<input title="Administrateur" id="admin_radio" class="radio" type="radio" name="acces" value="admin">
						<label class="string" for="user_radio" style="width: auto;">Utilisateur</label>
						<input title="Utilisateur" id="user_radio" class="radio" type="radio" name="acces" value="user" checked>
					</p>
					<p>
						<input id="submit" class="button file-upload-btn btn-auto" type="submit" value="Créer l'utilisateur"/>
					</p>
					<input type="hidden" name="pagedorigine" id="pagedorigine" value="gestion" />
				</form>
			</div>
			<h2>Utilisateurs existants</h2>
			<?php include("include/affichage-utilisateurs.php"); ?>
		</div>
		<?php include "include/footer.php"; ?>
	</section>
</body>
</html>	