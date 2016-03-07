<?php

// Vérification connexion
include ("include/verification-connexion.php");
include ("include/fonctions.php");

if (isset($_SESSION["messages"])) {
	foreach ($_SESSION["messages"] as $mess) {
		GetErreur($mess);
	}
	$_SESSION["messages"] = array();
}

if (isset($_GET['userid']) AND $_GET['userid'] != "" AND VerifierIdUserExistant($_GET['userid'])) {
	require("include/config.php");
	try {
		$req = $connBD->prepare('SELECT * FROM users WHERE Id=:userid');
		$req->execute(array('userid'=> $_GET['userid'] ));
		$donnees = $req->fetch();
		$req->closeCursor();
		$connBD = null;
	}
	catch (PDOException $e) {
		exit( "Erreur lors de l'exécution de la requête SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQU�TE = SELECT");
	}
}
else {
	$_SESSION["messages"][] = 15;
	header("LOCATION:gestion-utilisateurs.php");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier utilisateur | <?php echo $donnees['Nom']; ?></title>
	<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic|Lato:400,100,300,700,900:latin' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
    <link rel="icon" href="favicon.ico" />
</head>
<body>
	<!-- Menu -->
	<?php if ($_SESSION['utilisateur']['Acces'] == 'admin') {
		include("include/navbar-top-admin.php");
	}
	else {
		include("include/navbar-top.php");
	}
	?>
	<section id="contenu">
		<header id="banner-ajout-film">
			<h1>Modifier utilisateur | <?php echo $donnees['Nom']; ?></h1>
			<img src="http://btckstorage.blob.core.windows.net/site761/Film%20Club/filmreelLEFT.png">
		</header>
		<div id="page">
			<div id="blocAlign">
					<form method="post" id="frmajout" action="include/update-utilisateur.php">
						<p>
							<label for="titreFilm">Nom d'utilisateur: </label>
							<input type="text" name="pseudo" id="pseudo" size="30" value="<?php echo $donnees['Nom'] ?>"> .
						</p>
						<p>
							<label for="mdpuser">Mot de passe: </label>
							<input name="mdp" id="mdp" size="30" type="password" placeholder="Mot de passe">
						</p>
						<p>
							<label for="mdpuser">Confirmez le mot de passe: </label>
							<input name="mdpR" id="mdpR" size="30" type="password" placeholder="Entrez à nouveau">
						</p>
						<p>
						<input class="radio" type="radio" name="acces" value="admin">Administrateur
						<input class="radio" type="radio" name="acces" value="user" checked>Utilisateur
						</p>
						<input type="hidden" name="userid" id="userid" value="<?php echo $donnees['Id'] ?>" />
						<input type="hidden" name="pagedorigine" id="pagedorigine" value="gestion" />
						<p>
							<input class="file-upload-btn btn-dernier btn-auto" type="submit" value="Sauvegarder modifications">
						</p>
					</form>
				</div>
		</div>
	</section>
	<?php include "include/footer.php"; ?>
</body>
</html>	