<?php
// Vérification
include ("include/verification-connexion.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Partage de films | Panama</title>
	<link rel="stylesheet" type="text/css" href="css/styleIndex.css" media="all" />
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
    <link rel="icon" href="favicon.ico" />
</head>
<body>

    <!-- Menu -->
    <?php include ("navbar-top.php"); ?>
	<h1> Accueil </h1>
	<div id="page">
		 <!-- Si l'utilisateur est connecté en tant qu'admin -->
        <?php
		echo "Connecté en tant que: " . $_SESSION['utilisateur']['Nom'] . " (" . $_SESSION['utilisateur']['Acces'] . ")";
        if ($_SESSION['utilisateur']['Acces'] == "admin"){
            echo '
			<div id="blocAlign">
                <h2>Ajouter un film</h2>
                <form method="post" id="frmajout" action="include/upload.php" enctype="multipart/form-data">
					<p>
						<label for="titreFilm">Titre du film: </label>
						<input type="text" name="titre" id="titre" size="42"/>
					</p>
					<p>
						<label for="description">Description: </label>
						<textarea name="resume" id="resume" form="frmajout" cols="40" rows="9"></textarea>
					</p>
					<p>
						<label for="image">Image: </label>
						<input type="file" name="monfichier" id="monfichier" />
					</p>
					<p>
						<input id="submit" type="submit" value="Ajouter le film"/>
					</p>
                </form>
			</div>
		';
        }
		else if (($_SESSION['utilisateur']['Acces'] == "user")) { // Si l'utilisateur est connecté comme simple utilisateur
			
		}
		else
		{
			header('Location: connexion.php');
		}
			echo '<h2>Films disponibles</h2>';
			require("include/affichage-films.php");
        ?>
	</div>
</body>
</html>	