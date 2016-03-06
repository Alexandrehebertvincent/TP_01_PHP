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
    <?php if ($_SESSION['utilisateur']['Acces'] == 'admin') {
		include ("navbar-top-admin.php"); 
	}
	else {
		include ("navbar-top.php"); 
	}
	echo "Connecté en tant que: " . $_SESSION['utilisateur']['Nom'] . " (" . $_SESSION['utilisateur']['Acces'] . ")";
	?>
	<h1> Accueil </h1>
	<div id="page">     
		<h2>Films disponibles</h2>
		<?php require("include/affichage-films.php"); ?>
	</div>
</body>
</html>	