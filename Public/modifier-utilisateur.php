<?php

// Vérification connexion
include ("include/verification-connexion.php");
include ("include/fonctions.php");

echo "Connect� en tant que: " . $_SESSION['utilisateur']['Nom'] . " (" . $_SESSION['utilisateur']['Acces'] . ")";

		if (isset($_GET['userid']) AND $_GET['userid'] != "" AND VerifierIdUserExistant($_GET['userid'])) {
		
			require("include/config.php");
		
		try {
			$req = $connBD->prepare('SELECT * FROM users WHERE Id=:id');
				$req->execute(array(
				'id'=> $_GET['userid'] ));
		
			$donnees = $req->fetch();
			
			$req->closeCursor();
			$connBD = null;
		}
		catch (PDOException $e) {
                exit( "Erreur lors de l'ex�cution de la requ�te SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQU�TE = SELECT");
            }
		}
		else {
			var_dump( VerifierIdFilmExistant($_GET['userid']));
			echo "Une erreur s'est produite. Vérifiez le 'Id' de l'utilisateur � modifier...";
			$erreur = true;
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
							<input name="mdp" id="mdp" size="30" type="password" value="<?php echo $donnees['Mot_de_Passe'] ?>">
						</p>
						<p>
							<label for="mdpuser">Confirmez le mot de passe: </label>
							<input name="mdpR" id="mdpR" size="30" type="password" value="<?php echo $donnees['Mot_de_Passe'] ?>">
						</p>
						<p>
						<input class="radio" type="radio" name="acces" value="admin">Administrateur
						<input class="radio" type="radio" name="acces" value="user" checked>Utilisateur
						</p>
						<p>
							<input type="submit" value="Sauvegarder modifications">
						</p>
						<input type="hidden" name="userid" id="userid" value="<?php echo $donnees['Id'] ?>" />
						<input type="hidden" name="pagedorigine" id="pagedorigine" value="gestion" />
					</form>
				</div>
		</div>
	</section>
	<?php include "include/footer.php"; ?>
</body>
</html>	