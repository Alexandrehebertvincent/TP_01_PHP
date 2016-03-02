<?php
// Vérification
include ("verificationConnexion.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Partage de films | Panama</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
    <link rel="icon" href="favicon.ico" />
</head>
<body>

    <!-- Menu -->
    <?php include ("navbar_top.php"); ?>

	<div id="page">
		 <!-- Si l'utilisateur est connecté en tant qu'admin -->
        <?php
        if ($_SESSION['utilisateur']['Acces'] == "admin"){
			
			
            echo '
                <h2>Ajouter un film</h2>
                <form method="post" id="frmajout" action="upload.php" enctype="multipart/form-data">
                    <label for="titreFilm">Titre du film: </label>
                    <input type="text" name="titre" id="titre"/>
                    <label for="possesseur">Description: </label>
                    <textarea name="resume" id="resume" form="frmajout" cols="40" rows="9"></textarea>
                    <label for="image">Image: </label>
                    <input type="file" name="monfichier" id="monfichier" />
                    <input type="submit" value="Ajouter"/>
                </form>
		';
        }
		else if (($_SESSION['utilisateur']['Acces'] == "user")) { // Si l'utilisateur est connecté comme simple utilisateur
			
		}
		else
		{
			header('Location: connexion.php');
		}
		echo "Connecté en tant que: " . $_SESSION['utilisateur']['Nom'] . "(" . $_SESSION['utilisateur']['Acces'] . ")";
			echo '<h2>Films disponibles</h2>';
			require("affichageFilms.php");
        ?>
	</div>
</body>
</html>	