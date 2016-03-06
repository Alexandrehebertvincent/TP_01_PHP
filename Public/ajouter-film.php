<?php
// Vérification
include ("include/verification-connexion.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un film | Panama</title>
	<link rel="stylesheet" type="text/css" href="css/styleIndex.css" media="all" />
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
    <link rel="icon" href="favicon.ico" />
</head>
<body>

    <!-- Menu -->
    <?php 
		include ("navbar-top-admin.php"); 
		echo "Connecté en tant que: " . $_SESSION['utilisateur']['Nom'] . " (" . $_SESSION['utilisateur']['Acces'] . ")";
	?>
	<h1> Ajouter un film </h1>
	<div id="page">
			<div id="blocAlign">
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
	</div>
</body>
</html>	