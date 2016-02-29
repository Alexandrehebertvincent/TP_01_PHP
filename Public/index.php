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
<div id="page">
    <!-- Si l'utilisateur est connectÃ© en tant qu'admin -->

    <h2>Ajouter un film</h2>
    <form method="post" action="upload1.php" enctype="multipart/form-data">
        <p>
            <label for="titreFilm">Titre du film: </label><input type="text" name="titre" id="titre"/>
        </p>
        <p>
            <label for="possesseur">Description: </label><input type="text" name="resume" id="resume"/>
        </p>
        <p>
            <label for="image">Image: </label><input type="file" name="monfichier" id="monfichier" />
        </p>
        <p>
            <input type="submit" />
        </p>
    </form>
</div>
</body>
</html>