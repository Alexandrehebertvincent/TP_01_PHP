<?php
// Vérification
include ("verificationConnexion.php");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Partage de films | Panama</title>
	<link rel="stylesheet" type="text/css" href="css/styleIndex.css" media="all" />
</head>
<body>
    <nav id="menu" role="navigation">
        <ul>
            <li><a href="#">Home</a></li>
            <li id="deconnexion"><a href="#">Déconnexion</a></li>
        </ul>
    </nav>
	<div id="page">
		 <!-- Si l'utilisateur est connecté en tant qu'admin -->
        <?php
        if ($_SESSION['utilisateur']['Acces'] == "admin"){
            echo '
                <h2>Ajouter un film</h2>
                <form method="post" action="upload.php" enctype="multipart/form-data">
                    <label for="titreFilm">Titre du film: </label>
                    <input type="text" name="titre" id="titre"/>
                    <label for="possesseur">Description: </label>
                    <input type="text" name="resume" id="resume"/>
                    <label for="image">Image: </label>
                    <input type="file" name="monfichier" id="monfichier" />
                    <input type="submit" />
                </form>
		';
        }
        ?>
	</div>
</body>
</html>	